<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centers extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_name',
        'center_location',
        'center_contact_person',
        'center_email_address',
        'active',
        'default_currency'
    ];

    public function staffs(){
        return $this->hasMany(AdminUser::class ,'center_id');
    }

}
