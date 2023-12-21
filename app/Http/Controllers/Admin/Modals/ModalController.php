<?php

namespace App\Http\Controllers\Admin\Modals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function displayModal(Request $request) {
        if ( ! $request->view ) {
            return $this->json(false,'Unable to find file.');
        }

        return view('admin.modal.'.$request->view,$request->all());

    }
}
