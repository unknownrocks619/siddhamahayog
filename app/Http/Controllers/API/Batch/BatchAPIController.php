<?php

namespace App\Http\Controllers\API\Batch;

use App\Http\Controllers\Controller;
use App\Http\Resources\BatchAPIResource;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchAPIController extends Controller
{
    //

    public function list() {
        return BatchAPIResource::collection(Batch::all());
    }
}
