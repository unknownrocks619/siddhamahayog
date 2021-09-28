<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSewa extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'slug',
        'sewa_name',
        'description',
        'created_by_user'
    ];

    protected $hidden = [
        'created_by_user'
    ];

    public function usersewabridge()
    {
        return $this->hasMany(UserSewaBridge::class,'user_sewas_id');
    }
}
