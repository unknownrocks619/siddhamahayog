<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\ProgramStudentFee
 *
 * @property string $full_name
 * @property int $program_id
 * @property int $student_id
 * @property string $full_address
 * @property string $phone_number
 * @property int $id
 * @property int|null $program_student_id
 * @property int|null $student_batch_id
 * @property string $total_amount
 * @property int $marked_to_print
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Member|null $member
 * @property-read \App\Models\Program|null $program
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudentFeeDetail> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereMarkedToPrint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereProgramStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereStudentBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentFee withoutTrashed()
 * @mixin \Eloquent
 */

class ProgramStudentFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'program_id',
        'full_name',
        'full_address',
        'phone_number',
        'program_student_id',
        'student_batch_id',
        'student_id',
        'total_amount',

    ];

    public function member()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function transactions()
    {
        $transactions =  $this->hasMany(ProgramStudentFeeDetail::class, "program_student_fees_id");


        if (adminUser()?->role()->isCenter() || adminUser()?->role()->isCenterAdmin() ) {
            $transactions->where('fee_added_by_center',adminUser()->center_id);
        }

        return $transactions;

    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    /**
     * Re Calculate total amount submitted by this
     * user for this particular program
     *
     * @return void
     */
    public function reCalculateTotalAmount(): void {
        $this->total_amount = $this->transactions()->where('rejected',false)->sum('amount');
        $this->saveQuietly();
    }
}
