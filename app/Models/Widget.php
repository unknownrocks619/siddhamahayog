<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

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
