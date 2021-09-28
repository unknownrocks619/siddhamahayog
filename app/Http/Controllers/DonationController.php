<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userDetail;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    //

    public function store(Request $request)
    {
        $donation = Donation::where('user_detail_id',$request->user_detail_id)->first();
        if ($donation) {
            $donation->amount += $request->donation;
            // dd($donation);
            // let's call donation controller;
            return $donation->save();
        } else {

            $donation = [
                'user_detail_id' => $request->user_detail_id,
                'amount' => $request->donation,
            ];

            return Donation::create($donation);
        }

    }

    public function store_sadhak_dontaion(Request $request ) {
        $donation = Donation::where('user_detail_id',$request->user_detail)->first();
        try {
            \DB::transaction(function () use ($donation,$request) {
                if ($donation ) {
                    $donation->amount += $request->donation;
                    $donation->save();
                } else {
                    $donation = [
                        'user_detail_id' => $request->user_detail,
                        'amount' => $request->donation,
                    ];
                    Donation::create($donation);
                }

                $transaction = new DonationTransactionController;
                $request->remark = "Donation Received by sadhak. During his visit.";
                $transaction->store($request);
            });

            if ($request->ajax() ) {
                return response ([
                    'success' => true,
                    'message' => "Thank-you for donation."
                ],200);
            }
            $request->session()->flash('success','Thank-you for donation');
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            if ($request->ajax()) {
                return response ([
                    'success' => false,
                    'message' => "Donations Save Failed. Please try again.",
                    'error' => $th->getMessage()
                ],200);
            }
            $request->session()->flash("error",$th->getMessage());
            return back();
        }
    }
}
