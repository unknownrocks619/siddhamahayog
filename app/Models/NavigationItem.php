<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\NavigationItem
 *
 * @property int $id
 * @property string $id_position
 * @property int|null $parent_id
 * @property string|null $icon
 * @property string $name
 * @property int|null $order
 * @property array $permission
 * @property string|null $route
 * @property array|null $route_params
 * @property string|null $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, NavigationItem> $child
 * @property-read int|null $child_count
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereIdPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereRouteParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationItem withoutTrashed()
 * @mixin \Eloquent
 */
class NavigationItem extends Model
{
    use HasFactory,SoftDeletes;

    protected  $fillable = [
        'id_position',
        'icon',
        'name',
        'order',
        'permission',
        'route',
        'path',
        'parent_id',
        'route_params'
    ];

    protected  $casts = ['permission' => 'array' , 'route_params' => 'array'];

    protected $with = ['child'];
    public function child() {
        return $this->hasMany(NavigationItem::class,'parent_id','id')
                    ->with(['child'])
                    ->orderBy('order','ASC');
    }
}
