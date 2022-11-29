<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    //

    public function index()
    {
        if (user()->role_id  != 1) {
            abort(404);
        }
        $intent = user()->createSetupIntent();
        return view('frontend.user.donation.card-donation', compact('intent'));
    }

    public function process_payment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required|integer',
            'card_holder_name' => "required"
        ]);
        if (user()->role_id  != 1) {
            abort(404);
        }
        try {
            user()->createOrGetStripeCustomer();
            user()->updateDefaultPaymentMethod($request->post('payment_method'));
            user()->charge($request->post('amount') * 100, $request->post('payment_method'));
        } catch (\Throwable $th) {
            return false;
        }
        return true;
    }
}
