<?php

namespace App\Http\Controllers\Frontend\Donation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\EsewaController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Requests\Frontend\User\Donation\AjaxDonationListRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    //

    public function index()
    {
        $donations = Donation::where('member_id', auth()->id())->latest()->get();
        return view('frontend.user.donation.index', compact('donations'));
    }

    public function donate(Request $request, $serviceProvider)
    {
        if (!method_exists($this, $serviceProvider)) {
            abort(404);
        }
        return $this->$serviceProvider($request);
    }


    public function stripe(Request $request)
    {
        
        $strip = new StripeController;
        if ($request->getMethod() == "GET") {
            return $strip->index();
        }

        if (!$strip->process_payment($request)) {
            session()->flash('error', 'Unable to complete your payment. If your amount is deducted from the account please create support ticket with your transaction statement detail. Or you can try again.');
            return back();
        }
        $data = [
            "member_id" => user()->id,
            "amount" => $request->amount,
            "verified" => true,
            "remarks" => ["partner" => "STRIPE", "currency" => "USD", "card_holder_name" => $request->post('card_holder_name')],
            'type' => "Stripe Guru Sewa",
        ];

        if (!$this->store($request, $data)) {
            session()->flash("error", 'Your payment was success, something went wrong. Please create support ticket to address the issue.');
            return back();
        }

        session()->flash("success", 'Thank-you for your sewa.');
        return redirect()->route('donations.list');
        // let's store the information donation table.
    }

    public function esewa(Request $request)
    {
        $request->validate([
            "amount" => "required|numeric"
        ]);
        $esewa = new EsewaController;

        $data = [
            'amt' => $request->amount,
            'pdc' => 0,
            'psc' => 0,
            'txAmt' => 0,
            'tAmt' => $request->amount,
            'pid' => (string) Str::uuid(),
            'su' => route('donations.success', 'esewa'),
            'fu' => route('donations.failed', 'esewa')
        ];
        $esewa->set_config($data);
        return $esewa->process_payment_html();
    }

    public function success(Request $request, $serviceProvider)
    {

        $esewa = new EsewaController;
        $data = [
            "member_id" => auth()->id(),
            // "amount" => $amount,
            "remarks" => $request->all(),
            "type" => " Esewa Guru Sewa",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ];
        if (!$esewa->verify_payment()) {
            $data["verified"] = false;
        } else {
            $data['verified'] = true;
        }
        $data["amount"] = $esewa->get_configs("amt");

        $store_record = $this->store($request, $data);

        if ($store_record && $data["verified"]) {
            session()->flash("success", "We received your donation. Thank-you !");
        } elseif ($store_record &&  !$data["verified"]) {
            session()->flash('error', "We received your amount, but we couldn't verify your transaction. If this issue is not resolved please create support ticket.");
        } elseif (!$store_record && $data["verified"]) {
            session()->flash("success", "Oops !  Unable to save. Please create support ticket if you don't see your donation log.");
        } else {
            session()->flash("error", "Unable to verify your transaction. Please create support ticket if you think this is mistake.");
        }
        return redirect()->route('dashboard');
    }

    public function failed()
    {
        session()->forget("amount");
        session()->flash("error", "Unable to complete your request.");
        return redirect()->route('dashboard');
    }

    public function store(Request $request, array $data)
    {
        return Donation::create($data);
    }

    public function ajaxDonationHistory(AjaxDonationListRequest $request)
    {
        if ($request->ajax()) {
            $donations = Donation::where("member_id", auth()->id())->latest()->paginate(8);
            return view('frontend.user.donation.dashboard-donation', compact('donations'));
        }
        abort(404);
    }
}
