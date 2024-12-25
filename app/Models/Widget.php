<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Widget
 *
 * @property int $id
 * @property string $widget_name
 * @property string|null $widget_title
 * @property string $slug
 * @property string|null $widget_featured_images
 * @property string|null $widget_description
 * @property string $widget_type Available options: Slider, Accordian, Banner Text, FAQ, Button, PDF Reader, Carousel Slider, Video, Quote,Column wih Icon, Column, Banner Video, Banner Video Checkmark, Image
 * @property string|null $widgets
 * @property string|null $widget_setting
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Page> $page
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WebsiteEvents> $events
 * @property-read int|null $events_count
 * @property-read int|null $page_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $post
 * @property-read int|null $post_count
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget query()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgetDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgetFeaturedImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgetSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgetTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Widget whereWidgets($value)
 * @mixin \Eloquent
 */
class Widget extends Model
{
    use HasFactory;

    protected $casts = [
        "fields" => "object",
        "settings" => "object",
        "layouts" => "object"
    ];

    public function lession()
    {
        return $this->morphedByMany(Lession::class, "widgetable");
    }

    public function page()
    {
        return $this->morphedByMany(Page::class, "widgetable");
    }

    public function post()
    {
        return $this->morphedByMany(Post::class, "widgetable");
    }

    public function events()
    {
        return $this->morphedByMany(WebsiteEvents::class, "widgetable");
    }
}
