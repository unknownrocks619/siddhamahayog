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
        } catch (\Throwable $th) {
            $request->session()->flash('error',"Warning: ". $th->getMessage());
            return back()->withInput();
        } catch (\Error $er) {
            $request->session()->flash("error","Error: ". $er->getMessage());
            return back()->withInput();
        }

        $request->session()->flash('success',"New Zoom account created.");
        return back();
    }

    public function edit_account(){

    }

    public function remove_account() {

    }
}
