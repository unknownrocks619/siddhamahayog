<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\WebsiteEvents
 *
 * @property int $id
 * @property string|null $program
 * @property string $event_title
 * @property string|null $slug
 * @property string|null $event_type online, offline, live
 * @property string|null $full_description
 * @property string|null $short_description
 * @property string|null $featured_image
 * @property string|null $page_image
 * @property string|null $event_start_date
 * @property string|null $event_start_time
 * @property string|null $event_end_date
 * @property string|null $event_end_time
 * @property string|null $event_contact_person
 * @property string|null $event_contact_phone
 * @property string|null $full_address
 * @property string|null $google_map_link
 * @property string $status available options: upcoming,Ongoing,completed, pending
 * @property int|null $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Program|null $event_program
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Widget> $widget
 * @property-read int|null $widget_count
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents query()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereFullDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereGoogleMapLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents wherePageImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WebsiteEvents withoutTrashed()
 * @mixin \Eloquent
 */
class WebsiteEvents extends Model
{
    use HasFactory, SoftDeletes;

    public function getEventStartDate()
    {
        return \Carbon\Carbon::parse($this->event_start_date . " " . $this->event_start_time);
    }

    public function getEventEndDate()
    {
        return \Carbon\Carbon::parse($this->event_end_date . " " . $this->event_end_time);
    }

    public function event_program()
    {
        return $this->belongsTo(Program::class, "program");
    }

    public function widget()
    {
        return $this->morphToMany(Widget::class, "widgetable");
    }
}
