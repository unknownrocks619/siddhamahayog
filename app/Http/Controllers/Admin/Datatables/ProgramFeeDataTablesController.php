<?php

namespace App\Http\Controllers\Admin\Datatables;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;
use DataTables;

class ProgramFeeDataTablesController extends Controller
{
    //

    public function programTransactionList(Request $request, Program $program){

        $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';
        $filters = [];
        if ($request->get('filter_center') ) {
            $filters['center'] = $request->get('filter_center');
        }
        if ($request->get('filter_staff')) {
            $filters['admin'] = $request->get('filter_staff');
        }
        
        if ($request->get('filter_amount') && $request->get('amp;filter_type') ) {
            $filter = $request->get('amp;filter_type');
            $type = '>';
            if ($filter == 'gte') {
                $type = '>=';
            } else if ($filter == 'lt') {
                $type = "<";
            } else if ($filter == 'lte' ) {
                $type = "<=";
            }
            $filters['amount']['value'] = $request->get('filter_amount');
            $filters['amount']['operator'] = $type;
        }

        
        return DataTables::of($program->transactionsDetail($searchTerm,$filters))
                        ->addColumn('transaction_date', function ($row) {
                            return date("Y-m-d", strtotime($row->transaction_date));
                        })
        ->addColumn('printable',function($row) use ($program) {
            return view('admin.datatable-view.program-fee.transaction-list.printable',['row' => $row,'program' => $program])->render();
        })
        ->addColumn('member_name', function ($row) use ($program) {
            $member = "<a href='" . route('admin.members.show',['member' => $row->member_id,'_ref' => 'transaction-detail','_refID' => $program->getKey(),'tab' => 'billing']) . "' class='text-info text-underline'>";
            $member .= htmlspecialchars($row->full_name);
            $member .= "</a>";

            return $member;
        })
        ->addColumn('staff_name', fn($row) => $row->staff_name)
        ->addColumn('center', fn($row)=> $row->center_name)
        ->addColumn('transaction_amount', function ($row) {
            return view('admin.datatable-view.program-fee.transaction-list.transaction_amount',['row' => $row])->render();
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
            return view('admin.datatable-view.program-fee.transaction-list.media',['row' => $row,'program' => $program])->render();
        })
        ->addColumn('action', function ($row) {

            return view('admin.datatable-view.program-fee.transaction-list.action',['program' => $row]);
        })
        ->setRowClass( function ($row) {

            if ( ! $row->request_type || $row->relation_table != ProgramStudentFeeDetail::class) {
                return;
            }

           if ($row->request_type == 'update') {
               return 'bg-label-warning';
           }
           if ($row->request_type == 'delete') {
               return 'bg-label-danger';
           }
        })
        ->rawColumns(["member_name", "transaction_amount", "media", "action", "source", "status","printable"])
        ->make(true);
    }
}
