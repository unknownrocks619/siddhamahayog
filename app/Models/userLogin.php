<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class userLogin extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;


    // protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_detail_id',
        'user_type',
        'email',
        'verified',
        'verification_link',
        'account_status',
        'created_by_user',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function userdetail()
    {
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }

    public function userRoles(){
        return $this->belongsTo(Role::class,"role_id");
    }
}

