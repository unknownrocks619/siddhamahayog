<?php

namespace App\Models;

use App\Console\Commands\ImageToTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramStudentFeeDetail
 *
 * @property int $id
 * @property string $program_id
 * @property string|null $student_id
 * @property string $program_student_fees_id
 * @property string $amount
 * @property string|null $currency
 * @property string|null $foreign_currency_amount
 * @property string $exchange_rate
 * @property string|null $amount_category Available options: donation, monthly fee, admission fee, others
 * @property string $source available options: Cash Deposit, Cash Receipt, Cheque Deposit, Online
 * @property string|null $source_detail For Cash and cheque deposit write Bank name and for online online transaction party name eg. esewa
 * @property int $verified true verified and false or null unverified
 * @property int $rejected
 * @property string|null $voucher_number
 * @property object|null $file
 * @property object|null $remarks
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $fee_added_by_user
 * @property string|null $remark_from_uploader
 * @property string|null $fee_added_by_center
 * @property int $is_marked_to_print
 * @property-read \App\Models\Centers|null $center
 * @property-read \App\Models\Program|null $program
 * @property-read \App\Models\AdminUser|null $staff
 * @property-read \App\Models\Member|null $student
 * @property-read \App\Models\ProgramStudentFee|null $student_fee
 * @property-read \App\Models\Images|null $voucherImage
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereAmountCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereFeeAddedByCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereFeeAddedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereForeignCurrencyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereIsMarkedToPrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereProgramStudentFeesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereRejected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereRemarkFromUploader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereSourceDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail whereVoucherNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFeeDetail withoutTrashed()
 * @mixin \Eloquent
 */
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
