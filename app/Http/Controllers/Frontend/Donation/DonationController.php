<?php

namespace App\Http\Controllers\Frontend\Donation;

use App\Http\Controllers\Controller;
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
            'pid' => Str::random(10),
            'scd' => config("services.esewa.merchant_code"),
            'su' => route('donations.success', 'esewa'),
            'fu' => route('donations.failed', 'esewa')
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function success(Request $request, $serviceProvider)
    {
        dd(session()->get("amount"));
        $url = config("services.esewa.verification");
        $data = [
            'amt' => session()->get('amount'),
            'rid' => $request->refId,
            'pid' => $request->pid,
            'scd' => config("services.esewa.merchant_code")
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        session()->forget("amount");
    }
}
