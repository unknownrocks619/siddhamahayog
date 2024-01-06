<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    use HasFactory;

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
