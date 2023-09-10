<?php

namespace App\Http\Controllers\Frontend\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramResourceSubscriptionController extends Controller
{
    //
    public function index(Request $request, string $type, $relatedID)
    {
        if (session()->has(session()->getId())) {
            session()->put(session()->getId(), ['types' => []]);
        }
        $sessionItem = session()->get(session()->getId());
        if (!isset($sessionItem['types'][$type])) {
            $sessionItem['types'][$type] = [$relatedID];
        }
        return view('frontend.user.subscription');
    }

    public function checkOut()
    {
    }
}
