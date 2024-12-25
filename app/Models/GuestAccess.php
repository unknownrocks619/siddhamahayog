<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\GuestAccess
 *
 * @property int $id
 * @property string $meeting_id
 * @property int $created_by_user
 * @property int|null $program_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $remarks
 * @property int $used
 * @property object|null $access_detail
 * @property string $access_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Live|null $liveProgram
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereAccessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereAccessDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereCreatedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|GuestAccess withoutTrashed()
 * @mixin \Eloquent
 */
class GuestAccess extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'program_id',
        'remarks',
        'access_code',
        'meeting_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'access_detail' => 'object'
    ];

    public static function boot()
    {
        parent::boot();
        return static::creating(function ($item) {
            return $item['created_by_user'] = auth()->id();
        });
    }

    public function liveProgram()
    {
        return $this->belongsTo(Live::class, 'meeting_id', 'meeting_id');
    }
}
