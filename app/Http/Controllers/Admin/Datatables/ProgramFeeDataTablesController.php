<?php

namespace App\Http\Controllers\Admin\Datatables;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use DataTables;

class ProgramFeeDataTablesController extends Controller
{
    //

    public function programTransactionList(Request $request, Program $program){

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
            if (!\Illuminate\Support\Str::contains($row->source_detail, 'e-sewa', true) && !\Illuminate\Support\Str::contains($row->source, 'stripe', true)) {
                $spanAmount = '<span class="transactionWrapper" data-table-wrapper="program_fee_overview" data-wrapper-id="'.$row->transaction_id.'">';
                    $spanAmount .= "<span class='update-amount-fee-transaction' data-update-amount-id='update_span_{$row->transaction_id}'>". default_currency(strip_tags($row->amount)).'</span>';
                    $spanAmount .= "<span class='update-amount-container d-flex align-items-center d-none' id='update_span_{$row->transaction_id}'>";
                        $spanAmount .= "<input type='text' class='form-control' value='".strip_tags($row->amount)."' />";
                        $spanAmount .= "<span class='text-success mx-2 update-transaction-update' style='cursor: pointer'><i class='fas fa-check'></i> </span>";
                        $spanAmount .= "<span class='text-danger cancel-transaction-update' style='cursor: pointer'><i class='fas fa-close'></i> </span>";
                    $spanAmount .= "</span>";
                $spanAmount .= "</span>";
            } else {
                $spanAmount = "<span>". default_currency(strip_tags($row->amount)).'</span>';
            }
            return $spanAmount;
        })
        ->addColumn('category', function ($row)  use ($program){

           return view('admin.datatable-view.program-fee.transaction-list.category',['program' => $program,'row'=>$row]);
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

            return view('admin.datatable-view.program-fee.transaction-list.action',['program' => $row]);
        })
        ->rawColumns(["member_name", "transaction_amount", "media", "action", "source", "status"])
        ->make(true);
    }
}
