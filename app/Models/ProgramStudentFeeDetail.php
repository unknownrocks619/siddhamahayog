<?php

namespace App\Models;

use App\Console\Commands\ImageToTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudentFeeDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'student_id',
        'program_student_fees_id',
        'amount',
        'currency',
        'foreign_currency_amount',
        'amount_category',
        'source',
        'source_detail',
        'verified',
        'rejected',
        'voucher_number',
        'file',
        'remarks',
        'message',
        'fee_added_by_user',
        'remark_from_uploader',
        'fee_added_by_center'
    ];

    protected $casts = [
        "remarks" => "object",
        "file" => "object"
    ];
    public function student_fee()
    {
        return $this->belongsTo(ProgramStudentFee::class, "program_student_fees_id");
    }

    public function student()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    public function voucherImage() {
        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id','id','image_id')
                    ->where('relation',ProgramStudentFeeDetail::class);
    }

    public function center() {
        return $this->belongsTo(Centers::class,'fee_added_by_center');
    }

    public function staff(){
        return $this->belongsTo(AdminUser::class,'fee_added_by_user');
    }
}
