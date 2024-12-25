<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WebsiteSlider
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteSlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteSlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteSlider query()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteSlider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WebsiteSlider extends Model
{
    use HasFactory;
}
