<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property string $full_name
 * @property int $program_id
 * @property int $student_id
 * @property string $full_address
 * @property string $phone_number
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
