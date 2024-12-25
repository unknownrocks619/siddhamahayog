<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $page_name
 * @property string|null $slug
 * @property string|null $excerpt
 * @property string|null $description
 * @property string $page_type Available Options: home,policy,standard,gallery,video,contact
 * @property string $display Available Options: Public, Autheticated, Admin, Parent, Teacher, Organisation, Student Unde, Student Above
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Menu> $menus
 * @property-read int|null $menus_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Widget> $widget
 * @property-read int|null $widget_count
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page withoutTrashed()
 * @mixin \Eloquent
 */
class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function widget()
    {
        return $this->morphToMany(Widget::class, "widgetable");
    }

    public function menus()
    {
        return $this->morphToMany(Menu::class, "menuable");
    }
}
