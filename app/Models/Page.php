<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
