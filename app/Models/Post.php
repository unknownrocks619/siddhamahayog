<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "images" => "object",
        "videos" => "object"
    ];

    public function widgets()
    {
        return $this->morphToMany(Widget::class, "widgetable");
    }

    public function menu()
    {
        return $this->morphToMany(Menu::class, "menuable");
    }
}
