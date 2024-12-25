<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property string $menu_name
 * @property string $slug
 * @property string|null $description
 * @property string $menu_type
 * @property string|null $parent_menu
 * @property string $sort_by
 * @property string $menu_position
 * @property int $active
 * @property string $display_type Available optiosn: draft, protected, private
 * @property string|null $meta_title
 * @property string|null $menu_featured_image
 * @property string|null $meta_description
 * @property string|null $meta_image
 * @property string|null $meta_keyword
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Page> $pages
 * @property-read int|null $pages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDisplayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMetaKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereParentMenu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereSortBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu withoutTrashed()
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use HasFactory, SoftDeletes;

    public function pages()
    {
        return $this->morphedByMany(Page::class, "menuable");
    }
}
