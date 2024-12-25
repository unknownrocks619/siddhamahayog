<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionUpdate
 *
 * @property int $id
 * @property string $relation_table
 * @property string $relation_id
 * @property string $request_type update, delete, create
 * @property string|null $update_column
 * @property string|null $old_value
 * @property string|null $new_value
 * @property array|null $row_old_value
 * @property array|null $row_new_value
 * @property int $status 1: request sent, 2: Approved, 3: Rejected, 4: Waiting Modification
 * @property int $update_request_by_user
 * @property int $update_request_by_center
 * @property int $updated_by_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Centers|null $center
 * @property-read \App\Models\AdminUser|null $staffUser
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereRelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereRelationTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereRequestType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereRowNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereRowOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereUpdateColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereUpdateRequestByCenter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereUpdateRequestByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionUpdate whereUpdatedByUser($value)
 * @mixin \Eloquent
 */
class PermissionUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'relation_table',
        'relation_id',
        'request_type',
        'update_column',
        'old_value',
        'new_value',
        'row_old_value',
        'row_new_value',
        'status',
        'update_request_by_user',
        'update_request_by_center',
        'updated_by_user'
    ];

    protected $casts = [
        'row_old_value' => 'array',
        'row_new_value' => 'array'
    ];

    const STATUS_PENDING = 1;
    const STATUS_APPROVED=2;
    const STATUS_REJECTED=3;

    const REQUEST_UPDATE = 'update';
    const REQUEST_DELETE='delete';
    const REQUEST_NEW='create';
    const REQUEST_READ='read';

    public function center() {
        return $this->belongsTo(Centers::class,'update_request_by_center');
    }

    public function staffUser() {
        return $this->belongsTo(AdminUser::class,'update_request_by_user');
    }
}
