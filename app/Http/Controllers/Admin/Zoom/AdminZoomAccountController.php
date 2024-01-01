<?php

namespace App\Http\Controllers\Admin\Zoom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\ZoomAccount;

class AdminZoomAccountController extends Controller
{
    /**
     * Display all available zoom accounts created in db
     */
    public function zoom_accounts() {
        $accounts = ZoomAccount::latest()->paginate();
        return view("admin.zoom.accounts",compact("accounts"));
    }

    public function add_zoom_account() {
        return view("admin.zoom.create_account");
    }

    public function store_zoom_account(Request $request) {
        $request->validate([
            "name" => "required",
            // "account_slug" => "required|unique:zoom_accounts,slug,NULL,id,deleted_at,NULL",
            "username" => "required|email|unique:zoom_accounts,account_username,NULL,id,deleted_at,NULL",
            "api_token" => "required",
            "status" => "required|in:active,inactive,suspend",
            "category" => "required|in:admin,zone,local,other"
        ]);

        $zoom_account_db = new ZoomAccount;

        $zoom_account_db->account_name = $request->name;
        $zoom_account_db->slug = Str::slug($request->name,"-");
        $zoom_account_db->account_status = $request->status;
        $zoom_account_db->account_username = $request->username;
        $zoom_account_db->api_token = $request->api_token;
        $zoom_account_db->category = $request->category;

        try {
            $zoom_account_db->save();
        } catch (\Throwable|\Error $th) {
            return $this->json(false,'Error: '. $th->getMessage());
        }

        return $this->json(true,'New Zoom Account created.','reload');
    }

    public function edit_account(Request $request,ZoomAccount $zoom){

        if ($request->post() ) {
            $request->validate([
                'name'  => 'required'
            ]);

            $zoom->account_name = $request->post('name');
            $zoom->slug = Str::slug($request->post('name'),"-");
            $zoom->account_status = $request->post('status');
            $zoom->account_username = $request->post('username');
            $zoom->category = $request->post('category');

            try {
                $zoom->save();
            } catch ( \Error $error) {
                return $this->json(false, 'Unable to update information.');
            }

            return $this->json(true,'Information Updated.');
        }

        return view('admin.zoom.account-edit',['zoom' => $zoom]);
    }

    public function remove_account(ZoomAccount $zoom) {

        if (! $zoom->delete() ) {
            return $this->json(false,'Unable to delete Account.');
        }

        return $this->json(true,'Zoom Account Deleted.','reload');
    }
}
