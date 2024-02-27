<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
