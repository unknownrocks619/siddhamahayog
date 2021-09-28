<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Center extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Table name
     */
    protected $table = "branches";

    protected $fillable = [
        'name',
        'location',
        'lat',
        'lng',
        'geo_location',
        'iframe_location',
        'contact_person',
        'person_phone',
        'landline',
        'created_by_user'
    ];

    protected $hidden = [
        
        'created_by_user'
    ];

    public function userverification(){
        return $this->hasOne(UserVerification::class,"center_id");
    }

    public function userreference(){
        return $this->hasMany(userReference::class,"center_id");
    }
}
