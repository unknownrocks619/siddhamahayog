<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PartialController extends Controller
{
    //

    protected $partials = [
        'sadhana-registar-type' => 'registration',
    ];
    public function get_partials(Request $request,$type,$partials)
    {        App::setLocale($request->session()->get('locale'));    

        if($request->ajax() && array_key_exists($partials,$this->partials))
        {
            return view("partials.".$type.".".$this->partials[$partials],compact('request'));
        }
        abort(404);
    }
}
