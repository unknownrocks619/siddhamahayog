<?php

namespace App\Http\Controllers\Admin\PermissionRequest;

use App\Http\Controllers\API\Fee\FeeAPIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\FeeAPIRequest;
use App\Models\PermissionUpdate;
use App\Models\ProgramStudentFeeDetail;
use Illuminate\Http\Request;

class PermissionRequestController extends Controller
{
    //

    public function index(Request $request, ?PermissionUpdate $permission=null, int $type=0) {

        if ($request->ajax()) {
            $response = $this->json(false,'Oops ! Something went wrong.');

            if ($permission->update_column === 'amount') {
                $response = $this->update_amount($request, $permission);
            }

            if ($permission->update_column === 'transaction_verification') {
                $response = $this->update_transaction_verification($request,$permission);
            }

            if ($permission->update_column == 'transaction_voucher_number') {
                $response = $this->update_voucher_number($request, $permission);
            }

            if ($permission->update_column == 'transaction_delete') {
                $respone = $this->delete_transaction($request,$permission);
            }

            if ($type == 2) {
                $permission->status = $permission::STATUS_APPROVED;
            }
            if ($type == 3) {
                $permission->status = $permission::STATUS_REJECTED;
            }

            $permission->save();

            return $this->update_amount($request, $permission,$type);
        }

        $permissionRequests  = PermissionUpdate::with(['center','staffUser'])->where('status',PermissionUpdate::STATUS_PENDING)->get();
        return view('admin.permission-request.index',['permissionRequests' => $permissionRequests]);
    }

    public function update_amount(Request $request, PermissionUpdate $permission) {

        $request->merge(['amount' => $permission->new_value]);
        $apiRequest = new FeeAPIRequest($request->all());
        $newAPIFee = new FeeAPIController();
        $transaction  = $permission->relation_table::find($permission->relation_id);
        return $newAPIFee->update_transaction_fee_amount($apiRequest,$transaction);
    }

    public function update_voucher_number(Request $request, PermissionUpdate $permission) {
        $transaction  = $permission->relation_table::find($permission->relation_id);
        $apiRequest = new FeeAPIRequest($request->all());
        $newAPIFee = new FeeAPIController();
        return $newAPIFee->update_transaction_voucher_number($apiRequest,$transaction);
    }

    public function update_transaction_verification(Request $request, PermissionUpdate $permission){
        $transaction  = $permission->relation_table::find($permission->relation_id);
        $apiRequest = new FeeAPIRequest($request->all());
        $newAPIFee = new FeeAPIController();
        return $newAPIFee->update_fee_status($apiRequest,$transaction);
    }
    public function delete_transaction(Request $request, PermissionUpdate $permission) {
        $transaction  = $permission->relation_table::find($permission->relation_id);
        $apiRequest = new FeeAPIRequest($request->all());
        $newAPIFee = new FeeAPIController();

        $newAPIFee->delete_fee_transaction($transaction);
    }

}
