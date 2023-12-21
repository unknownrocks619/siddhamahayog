<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminCourseFeeRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\MemberNotification;
use App\Models\Program;
use App\Models\ProgramCourseFee;
use App\Models\ProgramStudentFee;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use DataTables;
use Upload\Media\Traits\FileUpload;

class ProgramStudentFeeController extends Controller
{
    //
    use FileUpload;

    public function index()
    {
    }

    public function update_transaction_status(Request $request, ProgramStudentFeeDetail $fee_detail)
    {
        $request->validate(["status" => "required|boolean"]);

        $fee_detail->verified =  !$fee_detail->verified;
        $fee_detail->rejected =  !$fee_detail->reject;
        if ($fee_detail->verified) {
            $notification =  new MemberNotification;
            $notification->member_id = $fee_detail->student_id;
            $notification->title = "Payment Verified ";
            $notification->notification_type = "App\Models\ProgramStudentFeeDetail";
            $notification->notification_id = $fee_detail->id;
            $notification->body = "Good News ! <br /> Your payment has been verified.";
            $notification->type = "message";
            $notification->level = "notice";
            $notification->seen = false;
            $notification->save();
        }

        if ($fee_detail->rejected) {
            $notification =  new MemberNotification;
            $notification->member_id = $fee_detail->student_id;
            $notification->title = "Payment Verification Failed ";
            $notification->notification_type = "App\Models\ProgramStudentFeeDetail";
            $notification->notification_id = $fee_detail->id;
            $notification->body = "We are sorry to inform you, Your transaction of amount. NRs. " . $fee_detail->amount . ' has been rejected. <br /><br /> If you think there is a mistake, Create a ticket explaining your issue.';
            $notification->type = "message";
            $notification->level = "notice";
            $notification->seen = false;
            $notification->save();
        }

        $fee_detail->save();
    }

    public function delete_transaction(ProgramStudentFeeDetail $fee)
    {
        // check if fee is verified. deduct the amount from overview as well.

        if ($fee->verified) {
            $fee->student_fee->total_amount = $fee->student_fee->total_amount - $fee->amount;
        }

        try {
            DB::transaction(function () use ($fee) {
                if ($fee->student_fee->isDirty()) {
                    $fee->student_fee->save();
                }
                $fee->delete();
            });
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success" => false,
                "message" => "Unable to remove data.",
                "error" => $th->getMessage()
            ]);
        }

        return response([
            "success" => true,
            "message" => "Record Deleted.",
        ]);
    }
    public function list_student_by_program(Request $request, Program $program)
    {
    }

    public function add_fee_to_student_by_program(Program $program)
    {
        return view('admin.programs.fee.add', compact('program'));
    }

    public function store_fee_by_program(Request $request,  ?Member $member , ?Program $program)
    {
        $request->validate([
            "amount" => "required",
            "payment_type" => "required",
            'payment_mode'  => 'required',
            'esewa-reference-number' => 'required_if:payment_mode,esewa',
            'esewa-transaction-id' => 'required_if:payment_mode,esewa',
            'esewa-transaction-date'    => 'required_if:payment_mode,esewa',
            'khalti-reference-number'   => 'required_if:payment_mode,khalti',
            'khalti-transaction-id' => 'required_if:payment_mode,khalti',
            'khalti-transaction-date'    => 'required_if:payment_mode,khalti',
            'file'  => 'required_if:payment_mode,voucher',
            'bank_name' => 'required_if:payment_mode,voucher',
            'voucher_date' => 'required_if:payment_mode,voucher',
            "source_detail" => "sometime|min:10"
        ]);

        if ( ! $program->getKey() ) {
            $request->validate(['program_name' => 'required|int|exists:programs,id']);
            $program = Program::where('id',$request->post('program_name'))->first();
        }

        if (! $member) {
            $request->validate(['member' => 'required|int']);
            $member = Member::find($request->post('member'));
        }


        $program_fee = new ProgramStudentFeeDetail;
        $program_fee->program_id = $program->getKey();
        $program_fee->student_id = $member->getKey();
        $program_fee->amount = $request->post('amount');
        $program_fee->amount_category = ($request->post('payment_type')) ? $request->post('payment_type') : 'monthly_fee';
        $program_fee->source = $request->post('payment_mode');
        $program_fee->source_detail = $request->source_detail;
        $program_fee->verified = $request->post('verified');
        $program_fee->rejected = false;


        if (in_array($request->post('payment_mode'),['esewa','khalti','banking']) ) {
            $program_fee->source = 'Online';
            $program_fee->source_detail = Str::ucfirst($request->post('payment_mode'));
            $program_fee->remarks = [
                'oid'   => $request->post($request->post('payment_mode').'-reference-number'),
                'amt'   =>  $request->post('amount'),
                'refId'=> $request->post($request->post('payment_mode').'-transaction-id')
            ];
        } else {
            $program_fee->source = 'Voucher Upload';
            $program_fee->source_detail = 'Physical Bank Deposit';
            $program_fee->remarks = [
                'upload_date' => $request->post('voucher_date'),
                'bank_name' => $request->post('bank_name'),
            ];
            $this->set_access('file');
            $this->set_upload_path('website/payments/programs');
            $program_fee->file = $this->upload('file');
        }

        $program_fee->fee_added_by_user = auth()->id();

        if ( $program_fee->verified ) {
            $program_fee->message = 'Payment Verified By User '. auth()->user()->full_name;
        }

        //
        $fee_detail = new ProgramStudentFee;
        $check_previous = $fee_detail->where('program_id', $program->id)->where('student_id', $member->id)->first();

        if ($check_previous) {

            $check_previous->total_amount = $check_previous->total_amount + $request->post('amount');
        } else {
            $check_previous = $fee_detail;
            $check_previous->program_id = $program->getKey();
            $check_previous->student_id = $member->getKey();
            $check_previous->total_amount = $request->post('amount');
        }


        try {
            DB::transaction(function () use ($check_previous, $program_fee) {
                $check_previous->save();

                $program_fee->program_student_fees_id = $check_previous->id;
                $program_fee->save();
            });
            $program_fee->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Error: '. $th->getMessage());
        }

        return $this->returnResponse(true,'Payment information added.','reload');
    }

    public function storeFeeByProgram(Request $request, Program|null $program=null, Member $member) {

    }
    public function fee_overview_by_program(Request $request, Program $program)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $overview_payment = ProgramStudentFee::where('program_id', $program->id)
                ->with(["member"])
                ->orderBy("id", "DESC")->get();
            return DataTables::of($overview_payment)
                ->addColumn('member_name', function ($row) {
                    $member = "<a href='" . route('admin.program.fee.admin_fee_by_member', [$row->program_id, $row->student_id]) . "'>";
                    $full_name = htmlspecialchars($row->member->first_name);
                    if ($row->member->middle_name) {
                        $full_name .= " ";
                        $full_name .= $row->member->middle_name;
                    }
                    $full_name .= " ";
                    $full_name .= htmlspecialchars($row->member->last_name);

                    $member .= $full_name;
                    $member .= "</a>";

                    return $member;
                })
                ->addColumn('amount', function ($row) {
                    return default_currency($row->total_amount);
                })
                ->addColumn('last_transaction', function ($row) {
                    return $row->updated_at;
                })
                ->addColumn('action', function ($row) {
                    $action = "";
                    $action .= "<a href='" . route('admin.program.fee.admin_fee_by_member', [$row->program_id, $row->student_id]) . "'>";
                    $action .= "View";
                    $action .= "</a>";

                    $action .= " | ";
                    $action .= " Delete ";

                    return $action;
                })
                ->rawColumns(['member_name', "action", "amount", "last_transaction", "member_name"])
                ->make(true);
        }

        return view("admin.fees.program.overview", compact('program'));
    }

    public function transaction_by_program(Request $request, Program $program)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $all_transaction = ProgramStudentFeeDetail::where('program_id', $program->id)->with(["student"])->orderBy("id", "DESC")->get();
            return DataTables::of($all_transaction)
                ->addColumn('transaction_date', function ($row) {
                    return date("Y-m-d", strtotime($row->created_at));
                })
                ->addColumn('member_name', function ($row) {
                    $member = "<a href='" . route('admin.program.fee.admin_fee_by_member', [$row->program_id, $row->student_id]) . "' class='text-info text-underline'>";
                    $full_name = htmlspecialchars($row->student->first_name);
                    if ($row->student->middle_name) {
                        $full_name .= " ";
                        $full_name .= htmlspecialchars($row->middle_name);
                    }
                    $full_name .= ' ';
                    $full_name .= htmlspecialchars($row->student->last_name);
                    $member .= htmlspecialchars($full_name);
                    $member .= "</a>";

                    return $member;
                })
                ->addColumn('transaction_amount', function ($row) {
                    return strip_tags(default_currency($row->amount));
                })
                ->addColumn('category', function ($row) {
                    $seperate_category = explode("_", $row->amount_category);
                    $category_text = "";
                    foreach ($seperate_category as $value) {
                        $category_text .= ucwords(strtolower($value)) . " ";
                    }

                    return $category_text;
                })
                ->addColumn('source', function ($row) {
                    $source = "<strong>" . $row->source . "</strong>";
                    $source .= "<hr />";
                    $source .= htmlspecialchars($row->source_detail);
                    return $source;
                })
                ->addColumn('status', function ($row) {
                    $status = "";
                    if ($row->verified) {
                        $status .= '<span class="badge bg-success px-2"><a href="#" title="Verified"><i class="text-white zmdi zmdi-check"></i></a>';
                    } else {
                        $status .= '<span class="badge bg-danger px-2"><a href="#" title="Rejected"><i class="text-white zmdi zmdi-minus-circle-outline"></i></a>';
                    }
                    $status .= "</span>";

                    return $status;
                })
                ->addColumn('media', function ($row) {
                    if ($row->file) {
                        $string =  "[<a data-toggle='modal' data-target='#imageFile' href='" . route('admin.program.fee.admin_display_fee_voucher', $row->id) . "'> View Image </a>]";
                        $string .= "<br /> Deposit Date: ";
                        if ($row->remarks && isset($row->remarks->upload_date)) {
                            $string .= $row->remarks->upload_date;
                        } else {
                            $string .= "N/A";
                        }

                        return $string;
                    } else {
                        $searchString = \Illuminate\Support\Str::contains($row->source_detail, 'e-sewa', true);
                        if ($searchString) {
                            $string = "OID: " . $row->remarks->oid;
                            $string .= "<br />";
                            $string .= "refId: " . $row->remarks->refId;
                            return $string;
                        }

                        $searchString = \Illuminate\Support\Str::contains($row->source, 'stripe', true);

                        if ($searchString) {
                            $string = "Rate : " . $row->remarks->rate->exchange_data->buy . 'NRs';
                            $string .= "<br />";
                            $string .= "Currency: " . $row->remarks->paid_currency;
                            $string .= "<br />";
                            $string .= "Amount: " . $row->remarks->paid_amount;
                            return $string;
                        }

                        return "Media Not Available";
                    }
                })
                ->addColumn('action', function ($row) {

                    $action = "";
                    if (!\Illuminate\Support\Str::contains($row->source_detail, 'e-sewa', true) && !\Illuminate\Support\Str::contains($row->source, 'stripe', true)) {

                        $action .= "<form style='display:inline' method='PUT' class='transaction_action_form' action='" . route('admin.program.fee.api_update_fee_detail', [$row->id]) . "'>";
                        $action .= "<input type='hidden' name='update_type' value='status' />";

                        if ($row->verified) {
                            $action .= "<button type='submit' class='btn btn-danger btn-sm'>Reject</button>";
                        } else {
                            $action .= "<button type='submit' class='btn btn-success btn-sm'>Verify</button>";
                        }
                        $action .= "</form>";
                    }

                    $action .= "<form style='display:inline' method='DELETE' action='" . route('admin.program.fee.api_delete_fee', $row->id) . "' class='transaction_delete_form'>";
                    $action .= "<input type='hidden' name='update_type' value='status' />";
                    $action .= "<button type='submit' class='btn btn-danger btn-sm'><i class='zmdi zmdi-delete'></i></button>";
                    $action .= "</form>";
                    return $action;
                })
                ->rawColumns(["member_name", "transaction_amount", "media", "action", "source", "status"])
                ->make(true);
        }
        return view('admin.fees.program.transactions', compact('program'));
    }

    public function transaction_by_program_and_student(Request $request, Program $program, Member $member)
    {
        $transaction = ProgramStudentFee::where('student_id', $member->id)
            ->where('program_id', $program->id)
            ->with(["transactions"])
            ->first();
        return view("admin.fees.program.individual", compact('member', 'program', "transaction"));
    }

    public function store_program_course_fee_structure(AdminCourseFeeRequest $request, Program $program)
    {
        $program_course_fee_structure = new ProgramCourseFee();
        $program_course_fee_structure->program_id = $program->id;
        $program_course_fee_structure->admission_fee = $request->admission_fee;
        $program_course_fee_structure->monthly_fee = $request->monthly_fee;
        $program_course_fee_structure->online = true;
        $program_course_fee_structure->offline = true;
        $program_course_fee_structure->active = true;

        // check fee structure with current program exists.


        $check_existing = ProgramCourseFee::where('program_id', $program->id)->first();

        if ($check_existing) {
            $check_existing->active = false;
        }

        try {
            DB::transaction(function () use ($check_existing, $program_course_fee_structure) {

                if ($check_existing) {
                    $check_existing->save();
                }
                $program_course_fee_structure->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Error: " . $th->getMessage());
            return back()->withInput();
        }
        session()->flash('success', "Congratulation ! New Fee Structure added.");
        return back();
    }

    public function display_uploaded_voucher(int|ProgramStudentFeeDetail $fee_detail)
    {
        if (is_int($fee_detail ) ) {
            $fee_detail = ProgramStudentFeeDetail::with(['remarks','student','file'])->find($fee_detail);
        }

        if (!$fee_detail->file) {
            return "Image Not Found.";
        }

        $html = "<div class='modal-body'>";
            $html .= "<div class='row'>";
            $html .= "<div class='col-md-12'>";
            $html .= "<table class='table table-border table-hover'>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= "<th>";
            $html .= "Bank Name";
            $html .= "</th>";
            $html .= "<th>";
            $html .= "Voucher Date";
            $html .= "</th>";
            $html .= "<th>";
            $html .= "Name";
            $html .= "</th>";
            $html .= "</tr>";
            $html .= "</thead>";
            $html .= "<tbody>";
            $html .= "<tr>";
            $html .= "<td>" . htmlspecialchars($fee_detail->remarks->bank_name) . "</td>";
            $html .= "<td>" . htmlspecialchars($fee_detail->remarks->upload_date) . "</td>";
            $html .= "<td>" . strtoupper($fee_detail->student->full_name) . "</td>";
            $html .= "</tr>";
            $html .= "</tbody>";
            $html .= "</table>";
            $html .= "</div>";
            $html .= "<div class='col-md-12  mt-3 border'>";
            $html .= "<img src='" . asset($fee_detail->file->path) . "' class='img-fluid' />";
            $html .= "</div>";
            $html .= "</div>";
        $html .= "</div>";

        return $html;
    }
}
