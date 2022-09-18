<?php

namespace App\Http\Controllers\Frontend\Donation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Donation\AjaxDonationListRequest;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    //

    public function donate(Request $request, $serviceProvider)
    {
        if (!method_exists($this, $serviceProvider)) {
            abort(404);
        }
        return $this->$serviceProvider($request);
    }

    public function esewa(Request $request)
    {
        $request->validate([
            "amount" => "required|numeric"
        ]);
        session()->put('amount', $request->amount);
        $url = config("services.esewa.redirect");
        $data = [
            'amt' => $request->amount,
            'pdc' => 0,
            'psc' => 0,
            'txAmt' => 0,
            'tAmt' => $request->amount,
            'pid' => (string) Str::uuid(),
            'scd' => config("services.esewa.merchant_code"),
            'su' => route('donations.success', 'esewa'),
            'fu' => route('donations.failed', 'esewa')
        ];

        $output =  "<form method='POST' action='{$url}' id='esewa_form' class='d-none'>";
        foreach ($data as $payment_key => $payment_value) :
            $output .= "<input type='hidden' value='{$payment_value}' name='{$payment_key}' />";
        endforeach;
        $output .= "</form>";

        // autosubmit form
        $output .= "<script type='text/javascript'>";
        $output .= "document.getElementById('esewa_form').submit();";
        $output .= "</script>";

        return $output;
    }

    public function success(Request $request, $serviceProvider)
    {
        $url = config("services.esewa.verification");
        $data = [
            'amt' => session()->get('amount'),
            'rid' => $request->refId,
            'pid' => $request->oid,
            'scd' => config("services.esewa.merchant_code")
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $amount = session()->get("amount");
        session()->forget("amount");
        $data = [
            "member_id" => auth()->id(),
            "amount" => $amount,
            "remarks" => $request->all(),
            "type" => " Esewa Guru Sewa",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ];
        if (Str::contains($response, "Success")) {
            $data["verified"] = true;
        } else {
            $data["verified"] = false;
        }

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
            $donations = Donation::where("member_id", auth()->id())->latest()->paginate(10);
            return view('frontend.user.donation.dashboard-donation', compact('donations'));
        }
        abort(404);
    }
}
