<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ZoomAccount
 *
 * @property int $id
 * @property string $account_name Account identification name
 * @property string $slug unique slug for name
 * @property string $account_status Account Status: active, inactive, suspend
 * @property string $account_username Actual Zoom Account Username
 * @property string $api_token ZOOM Developer API Token
 * @property string $category meeting type: Zonal, Admin (All), Local, Other
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereAccountStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereAccountUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ZoomAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        "account_name"
    ];

    protected $hidden = [
        "slug",
        "account_status",
        "account_username",
        "api_token"
    ];

    const ACCESS_TYPES =[
        'admin' => 'Admin',
        'local' => 'Local',
        'zonal' => 'Zonal',
        'other' => 'Other'
    ];

}
