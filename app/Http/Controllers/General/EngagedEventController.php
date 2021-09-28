<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userDetail;
use App\Models\UserSadhakRegistration;
use App\Models\SibirRecord;
use App\Models\EventFund;
use App\Models\EventFundDetail;
use App\Policies\General\EngagedEventPolicy;
use App\Traits\Upload;

class EngagedEventController extends Controller
{
    use Upload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $my_events = UserSadhakRegistration::where('user_detail_id',auth()->user()->user_detail_id)
                                            ->where('sibir_record_id', '!=',NULL)
                                            ->with('sibir_record')
                                            ->get();
        return view('public.user.subscription.index',compact('my_events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction_list(Request $request, $event)
    {
        if ( ! $event ) {
            $request->session()->flash('message',"Invalid Request.");
            return back();
        }
        //
        $sibir_record = SibirRecord::find(decrypt($event));
        if ( ! $sibir_record ) {
            $request->session()->flash('message',"Invalid Request.");
            return back();
        }
        $user_detail = userDetail::findOrFail(auth()->user()->user_detail_id);
        $fund = EventFund::where('sibir_record_id',$sibir_record->id)
                                    ->where('user_login_id',auth()->id())
                                    ->where("user_detail_id", $user_detail->id)
                                    ->first();
        $transactions = ($fund) ? EventFundDetail::where('event_fund_id',$fund->id)->get() : [];
        // dd($transactions);
        return view("public.user.subscription.transaction-list",
        compact('user_detail','sibir_record','fund','transactions'));
    }

    public function add_fund_form($event) {
        if (! auth()->check() ) {
            abort(403);
        }
        $sibir_record = SibirRecord::findOrFail(decrypt($event));
        return view('public.user.subscription.add-funds',compact('sibir_record'));
    }

    public function store_offline_payment(Request $request, $event) {
        if ( ! auth()->check() ) {
            abort(403);
        }
        $request->validate([
            "transaction_medium" => 'required|in:bank_deposit,wire_transfer,international_payment,other',
            "depository_party" => "required|string",
            "reference_number" => "required",
            "file" => "required|mimes:png,jpg,jpeg,gif|mimetypes:image/*",
            "amount" => "required|numeric"
        ]);
        $event_detail = SibirRecord::findOrFail(decrypt($event));

        $event_fund = EventFund::where('sibir_record_id',$event_detail->id)
                                    ->where('user_login_id',auth()->id())
                                    ->first();
        if ( ! $event_fund ) {
            $event_fund = new EventFund;
            $event_fund->sibir_record_id = $event_detail->id;
            $event_fund->user_login_id = auth()->id();
            $event_fund->user_detail_id = auth()->user()->user_detail_id;
            $event_fund->fund_amount = $request->amount;
        } else {
            $event_fund->fund_amount = $request->amount + $event_fund->amount;
        }

        // now lets add fund transaction;
        $transaction = new EventFundDetail;
        $transaction->sibir_record_id = $event_detail->id;
        $transaction->user_detail_id = auth()->user()->user_detail_id;
        $transaction->user_login_id = auth()->id();
        $transaction->amount = $request->amount;
        $transaction->source = $request->depository_party;
        $transaction->reference_number = $request->reference_number;
        $transaction->owner_remarks = $request->remarks;
        $transaction->status = "Pending";

        if ($request->hasFile('file') ) {
            $transaction->file = $this->upload($request,'file')->id;
        }

        try {
            //code...
            \DB::transaction(function() use ($transaction, $event_fund) {
                $event_fund->save();
                $transaction->event_fund_id = $event_fund->id;
                $transaction->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Error While Updating your transaction detail.");
            return back();
        } catch(\Error $er) {
            $request->session()->flash('message',"Failed execute command. Please try again or contact after few minutes.");
            return back();
        }

        $request->session()->flash('success',"Transaction detail has been added.");
        return redirect()->route('public.public_subscription_transaction_list',[encrypt($event_detail->id)]);

    }

    public function store_online_payment(Request $request, $event) {
        if ( ! auth()->check() ) {
            abort(403);
        }
        $request->validate([
            'depository_party' => "required|in:esewa,khalti,ips-connect,other",
            'transaction_id' => "required",
            "amount" => "required|numeric"
        ]);

        $event_detail = SibirRecord::findOrFail(decrypt($event));

        $event_fund = EventFund::where('sibir_record_id',$event_detail->id)
                                    ->where('user_login_id',auth()->id())
                                    ->first();
        if ( ! $event_fund ) {
            $event_fund = new EventFund;
            $event_fund->sibir_record_id = $event_detail->id;
            $event_fund->user_login_id = auth()->id();
            $event_fund->user_detail_id = auth()->user()->user_detail_id;
            $event_fund->fund_amount = $request->amount;
        } else {
            $event_fund->amount = $request->amount + $event_fund->amount;
        }

        // now lets add fund transaction;
        $transaction = new EventFundDetail;
        $transaction->sibir_record_id = $event_detail->id;
        $transaction->user_detail_id = auth()->user()->user_detail_id;
        $transaction->user_login_id = auth()->id();
        $transaction->amount = $request->amount;
        $transaction->source = $request->depository_party;
        $transaction->reference_number = $request->transaction_id;
        $transaction->owner_remarks = $request->remarks;
        $transaction->status = "Pending";

        try {
            \DB::transaction(function() use ($transaction, $event_fund) {
                $event_fund->save();
                $transaction->event_fund_id = $event_fund->id;
                $transaction->save();
            });

        } catch (\Throwable $th) {
            //throw $th;
            $request->session()->flash('message',"Error While Updating your transaction detail.");
            return back();
        }

        $request->session()->flash('success',"Transaction detail has been added.");
        return redirect()->route('public.public_subscription_transaction_list',[encrypt($event_detail->id)]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
