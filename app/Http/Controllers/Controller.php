<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function template($view = null , $data = [], $type = "user"){

        if ($type == "user")
        {
            return view($view,$data);
        } else if ($type == "admin")
        {
            return view('admin/'.$view,$data);
        } else if ($type == "center") {
            return view ('admin/'.$view,$data);
        }
        
    }

}
