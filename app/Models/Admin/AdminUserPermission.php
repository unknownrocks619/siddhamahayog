<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Admin\AdminUserPermission
 *
 * @property int $id
 * @property int $user_id
 * @property string $module_name
 * @property string $view
 * @property string $edit
 * @property string $delete
 * @property string $added_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereEdit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereModuleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission whereView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserPermission withoutTrashed()
 * @mixin \Eloquent
 */
class AdminUserPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'module_name',
        'view',
        'edit',
        'delete',
        'added_by'
    ];

    
}
