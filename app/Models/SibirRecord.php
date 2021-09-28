<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SibirRecord extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'sibir_title',
        'sibir_duration',
        'total_capacity',
        'start_date',
        'end_date',
        'slug',
        'active'
    ];

    protected $hidden = [
        'user_detail_id',
        'user_login_id'
    ];


    public function total_registrations() {
        return $this->hasMany(UserSadhakRegistration::class,'sibir_record_id')->where('is_active',true);
    }

    public function active_branches(){
        return $this->hasMany(SibirBranche::class,'sibir_record_id')->where('active',true);
    }

    public function branches() {
        return $this->hasMany(SibirBranche::class,'sibir_record_id');
    }

    public function delete_all_branches() {
        return $this->branches()->delete();
    }

    public function event_class() {
        return $this->hasOne(EventVideoClass::class,'event_id');
    }

    public function offline(){
        return $this->hasOne(OfflineVideo::class,'event_id');
    }
}
