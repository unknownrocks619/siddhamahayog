<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Widgetable
 *
 * @property int $id
 * @property int $widget_id
 * @property int $widgetable_id
 * @property string $widgetable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable whereWidgetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable whereWidgetableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widgetable whereWidgetableType($value)
 * @mixin \Eloquent
 */
class Widgetable extends Model
{
    use HasFactory;
}
