<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LessionPaymentDetail
 *
 * @property int $id
 * @property int|null $lession_payments_id
 * @property int|null $program_chapter_lession_id
 * @property int|null $program_id
 * @property int|null $program_course_id
 * @property int $member_d
 * @property string $amount
 * @property string $transaction_date
 * @property int $status available options: 1,2,3
 * @property string|null $settings
 * @property string $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereLessionPaymentsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereMemberD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereProgramChapterLessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereProgramCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPaymentDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LessionPaymentDetail extends Model
{
    use HasFactory;
}
