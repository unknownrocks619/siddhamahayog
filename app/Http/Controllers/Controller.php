<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
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

        session()->flash( ! ($status) ? 'success' : 'error' ,$message);
        return redirect()->to($redirect);
    }

    public function adminThemes($view,$data)
    {

    }

    /**
     *  Force generate validation error
     * @param mixed $name
     * @param string|null $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function generateValidationError(mixed $name = [], string $message = null): Application|ResponseFactory|\Illuminate\Http\Response
    {
        $error = [];
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $error['errors'][$key][] = $value;
            }
            $error['message'] = $message ?? 'Invalid form information.';
        } else {
            $error = [
                'message' => $message,
                'errors'    => [$name => [$message]]
            ];
        }

        return response($error, 422);
    }
}
