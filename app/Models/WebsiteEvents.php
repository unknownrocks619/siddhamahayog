<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

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
