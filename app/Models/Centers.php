<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Centers
 *
 * @property int $id
 * @property string $center_name
 * @property string|null $center_location
 * @property string|null $center_contact_person
 * @property string|null $center_email_address
 * @property int $active
 * @property string $default_currency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdminUser> $staffs
 * @property-read int|null $staffs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Centers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Centers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Centers query()
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereCenterContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereCenterEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereCenterLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereCenterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereDefaultCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centers whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Centers extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_name',
        'center_location',
        'center_contact_person',
        'center_email_address',
        'active',
        'default_currency'
    ];

    public function staffs(){
        return $this->hasMany(AdminUser::class ,'center_id');
    }

}
