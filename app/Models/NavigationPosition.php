<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NavigationPosition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nav_position','permission'];

    protected $casts=['permission' => 'array'];

    protected $with = [
        'navigationItems'
    ];

    public function navigationItems() {
        return $this->hasMany(NavigationItem::class,'id_position')
                    ->whereNull('parent_id')
                    ->orderBy('order','ASC');
    }
}
