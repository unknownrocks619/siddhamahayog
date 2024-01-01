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

            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            return DataTables::of($program->transactionOverview($searchTerm))
                ->addColumn('member_name', function ($row) use($program) {
                    $member = "<a href='" . route('admin.members.show',['member' => $row->member_id,'_ref' => 'transaction-detail','_refID' => $program->getKey(),'tab' => 'billing']). "'>";
                        $member .= htmlspecialchars($row->full_name) . "";
                    $member .= "</a>";
                    return $member;
                })
                ->addColumn('amount', function ($row) {
                    return default_currency($row->amount);
                })
                ->addColumn('last_transaction', function ($row) {
                    return $row->last_transaction_date;
                })
                ->addColumn('action', function ($row) use($program) {
                    $action = "";
                    $action .= "<a href='" . route('admin.program.fee.admin_fee_by_member', ['program' => $program->getKey(), 'member' => $row->member_id]) . "'>";
                    $action .= "View";
                    $action .= "</a>";

                    $action .= " | ";
                    $action .= " Delete ";

                    return $action;
                })
                ->rawColumns(['member_name', "action"])
                ->make(true);
        }

        return view("admin.fees.program.overview", compact('program'));
    }

    public function transaction_by_program(Request $request, Program $program)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            return DataTables::of($program->transactionsDetail($searchTerm))
                ->addColumn('transaction_date', function ($row) {
                    return date("Y-m-d", strtotime($row->transaction_date));
                })
                ->addColumn('member_name', function ($row) use ($program) {
                    $member = "<a href='" . route('admin.members.show',['member' => $row->member_id,'_ref' => 'transaction-detail','_refID' => $program->getKey(),'tab' => 'billing']) . "' class='text-info text-underline'>";
                    $member .= htmlspecialchars($row->full_name);
                    $member .= "</a>";

                    return $member;
                })
                ->addColumn('transaction_amount', function ($row) {
                    return default_currency(strip_tags($row->amount));
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
//                    $source = ucwords($row->source);
//                    $source .= "<hr />";
                    $source = htmlspecialchars($row->source_detail);
                    return $source;
                })
                ->addColumn('status', function ($row) {
                    $status = "";
                    if ($row->verified) {
                        $status .= '<span class="badge bg-label-success"><a href="#" title="Verified"><i class="fas fa-check"></i></a>';
                    } else {
                        $status .= '<span class="badge bg-label-danger"><a href="#" title="Rejected"><i class="fas fa-cancel"></i></a>';
                    }
                    $status .= "</span>";

                    return $status;
                })
                ->addColumn('media', function ($row) use ($program) {
                    $row->remarks = (json_decode( $row->remarks));
                    if ($row->file) {
                        $string =  "[<a class='ajax-modal' data-bs-toggle='modal' data-action='".route('admin.modal.display',['view' => 'fees.media.images','transactionID' => $row->transaction_id,'programID' => $program->getKey(),'memberID' => $row->member_id])."' data-bs-target='#imageFile' href='" . route('admin.program.fee.admin_display_fee_voucher', $row->transaction_id) . "'> View Image </a>]";
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
                            $string = "";
//                            $string = "OID: " . $row->remarks->oid;
//                            $string .= "<br />";
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

                    $action = "<div class='d-flex justify-content-between'>";
                    if (!\Illuminate\Support\Str::contains($row->source_detail, 'e-sewa', true) && !\Illuminate\Support\Str::contains($row->source, 'stripe', true)) {

//                        $action .= "<form style='display:inline' method='PUT' class='transaction_action_form' action='" . route('admin.program.fee.api_update_fee_detail', [$row->transaction_id]) . "'>";
//                        $action .= "<input type='hidden' name='update_type' value='status' />";

                        if ($row->verified) {
                            $action .= "<button data-method='PUT' data-action='".route('admin.program.fee.api_update_fee_detail', ['fee_detail' => $row->transaction_id])."' data-confirm='You are about to change the transaction status to `Unverified` state. User will be notified about the change. Are you sure you want to continue ?' data-bs-original-title='Reject Transaction' data-bs-toggle='tooltip' type='submit' class='btn btn-danger btn-icon data-confirm'><i class='fas fa-close'></i></button>";
                        } else {
                            $action .= "<button  data-method='PUT'  data-action='".route('admin.program.fee.api_update_fee_detail', ['fee_detail' => $row->transaction_id])."' data-confirm='You are about to update the transaction status to `Verified`. User will be notified about the changes. Do you wish to continue your action ?' type='submit' data-bs-toggle='tooltip' data-bs-original-title='Mark as verified Transaction' class='btn btn-success btn-icon data-confirm'><i class='fas fa-check'></i></button>";
                        }
                    }

                    $action .= "<button type='button' data-confirm='You are about to delete selected transaction. This action cannot be undone. Do you wish to continue your action ?' data-method='DELETE' data-action='".route('admin.program.fee.api_delete_fee', ['fee' => $row->transaction_id])."' class='btn btn-warning btn-icon data-confirm'><i class='fas fa-trash'></i></button>";
                    $action .= "</div>";
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

    public function unpaidList(Request $request, Program $program) {
        if ($request->ajax() && $request->wantsJson()) {
            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            return DataTables::of($program->nonPaidList($searchTerm))

                ->addColumn('member_name', function ($row) use ($program) {
                    $member = "<a href='" . route('admin.members.show',['member' => $row->id,'_ref' => 'transaction-detail','_refID' => $program->getKey(),'tab' => 'billing']) . "' class='text-info text-underline'>";
                    $member .= htmlspecialchars($row->full_name);
                    $member .= "</a>";

                    return $member;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('phone_number', function ($row) {
                   return $row->phone_number;
                })
                ->addColumn('Joined Dated', function ($row) {
                    return date('Y-m-d' ,strtotime($row->joined_date));
                })
                ->addColumn('action',fn($row) => '')
//                ->addColumn('status', function ($row) {
//                    $status = "";
//                    if ($row->verified) {
//                        $status .= '<span class="badge bg-label-success"><a href="#" title="Verified"><i class="fas fa-check"></i></a>';
//                    } else {
//                        $status .= '<span class="badge bg-label-danger"><a href="#" title="Rejected"><i class="fas fa-cancel"></i></a>';
//                    }
//                    $status .= "</span>";
//
//                    return $status;
//                })
                ->rawColumns(["action",'member_name'])
                ->make(true);
        }
        return view('admin.fees.program.unpaid', compact('program'));
    }
}
