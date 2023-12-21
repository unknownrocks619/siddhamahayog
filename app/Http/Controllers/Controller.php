<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function json(bool $state, ?string $msg = null, $jsCallback = null, array $params = [], int $status = 200, int $errorStatus = 422)
    {
        $response = [
            'state' => $state,
            'status' => $status,
            'msg' => $msg,
            'params' => $params,
            'callback' => $jsCallback
        ];

        $response = Response::make($response, (($state) ? $status : $errorStatus));
        $response->header('Content-Type', 'application/json');
        return $response;
    }

    public function returnResponse($state,$message,$jsCallback=null,array $params=[],int $status = 200,string $redirect=null) {
        if (request()->ajax()) {
            return $this->json($state,$message,$jsCallback,$params,$status);
        }

        session()->flash(! $status ? 'success' : 'false',$message);
        return redirect()->to($redirect);
    }

    public function adminThemes($view,$data)
    {

    }
}
