<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SliderSetting
 *
 * @property int $id
 * @property string $slider_title
 * @property string $layout
 * @property string|null $hooks
 * @property int $active get currently active settings.
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereHooks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereLayout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereSliderTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SliderSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SliderSetting extends Model
{
    use HasFactory;
}
