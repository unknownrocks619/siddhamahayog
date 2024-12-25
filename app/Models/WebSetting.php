<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WebSetting
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string|null $description
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Database\Factories\WebSettingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebSetting whereValue($value)
 * @mixin \Eloquent
 */
class WebSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'description',
        'created_at',
        'deleted_at',
        'updated_at',
        'remarks'
    ];
}
