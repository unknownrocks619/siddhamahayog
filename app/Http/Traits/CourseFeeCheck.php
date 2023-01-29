<?php

namespace App\Http\Traits;

use App\Models\Program;
use App\Models\ProgramStudentFee;
use App\Models\Role;
use App\Models\Scholarship;

trait CourseFeeCheck
{

    protected $model;
    protected array $eagerLoadings;
    protected  $data;

    public function __constructor()
    {
    }

    protected function studentFees(Program $program)
    {
        $this->model = new ProgramStudentFee;
        $this->eagerLoadings = ["transactions"];

        $this->data = $this->model->where("program_id", $program->id)->where('student_id', user()->id);
        // if ($this->eagerLoadings) {
        //     $this->data->with($this->eagerLoadings);
        // }
        $this->data = $this->data->first();
    }

    public function checkFeeDetail(Program $program, $fee_type = null)
    {

        if (Role::ADMIN == user()->role_id) {
            return true;
        }

        $scholarship = Scholarship::where('program_id', $program->getKey())
            ->where('student_id', auth()->id())
            ->first();

        if ($scholarship) {
            return true;
        }

        $this->studentFees($program);

        if (!$this->data) return  false;

        if (!$fee_type) return $this->data;




        return ($this->data->transactions()->where('amount_category', $fee_type)->first()) ? true : false;
    }
}
