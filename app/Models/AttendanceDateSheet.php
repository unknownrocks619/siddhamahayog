<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AttendanceDateSheet
 *
 * @property int $id
 * @property string $attendance_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet whereAttendanceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceDateSheet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttendanceDateSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_date'
    ];
}
