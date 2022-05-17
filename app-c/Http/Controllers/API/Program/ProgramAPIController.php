<?php

namespace App\Http\Controllers\API\Program;

use App\Events\Admin\Program\ProgramEvent;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\ProgramAPIRequest;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramAPIController extends Controller
{
    //

    public function store_program(ProgramAPIRequest $request) {

        $program = new Program;
        $program->program_name = $request->program_name;
        $program->slug = Str::slug($request->program_name,'-');
        $program->program_type = $request->program_type;
        
        if ($program->program_type == "paid") {
            $program->monthly_fee = $request->monthly_fee;
            $program->admission_fee = $request->admission_fee;
            $program->overdue_allowed = $request->overdue_allowed;
        }

        if ($request->program_duration_start) {
            $program->program_duration = $request->program_duration_start;
        }

        if ($request->program_duration_start && $request->program_duration_end) {
            $program->program_duration .= "-".$request->program_duration_end;
        }

        $program->description = $request->description;
        $program->promote = ($request->promote == "yes") ? true : false;

        if ( ! $request->zoom || ! $request->batch) {
            $program->status = "pending";
        }

        try {
            $program->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response(["success"=>"false","statusText"=>"Unable to create new program.",'error'=>$th->getMessage()],409);
        }
        event(new ProgramEvent($program));
        return response(["success"=> true,"message" => "New record created",'data'=>$program],200);

    }

    public function update_program(ProgramAPIRequest $request , Program $program) {

        $program->program_name = $request->program_name;

        if ($program->isDirty(('program_name')) ) {
            $program->slug = Str::slug($request->program_name,'-');
        }

        $program->program_type = $request->program_type;
        
        if ($program->program_type == "paid") {
            $program->monthly_fee = $request->monthly_fee;
            $program->admission_fee = $request->admission_fee;
            $program->overdue_allowed = $request->overdue_allowed;
        }

        if ($request->program_duration_start) {
            $program->program_duration = $request->program_duration_start;
        }

        if ($request->program_duration_start && $request->program_duration_end) {
            $program->program_duration .= "-".$request->program_duration_end;
        }

        $program->description = $request->description;
        $program->promote = ($request->promote == "yes") ? true : false;

        try {
            $program->save();
        } catch (\Throwable $th) {
            //throw $th;
            return response([
                "success"=> false,
                "statusText" => "Unable to Update program Detail.",
                "error" => $th->getMessage() 
            ],409);
        }

        return response([
            "success" => true,
            "message" => "Program Detail Updated.",
            "data" => $program
        ]);
    }
}
