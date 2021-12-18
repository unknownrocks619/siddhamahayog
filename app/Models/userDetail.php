<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class userDetail extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'pet_name',
        'date_of_birth_nepali',
        'date_of_birth_eng',
        'gender',
        'phone_number',
        'country',
        'city',
        'user_type',
        'user_room_allotment',
        'education_level',
        'profession',
        'skills',
        'marritial_status',
        'married_to_id',
        'profile_id',
        'user_role',
        'draft',
        'address',
        'place_of_birth',
        'emergency_contact',
        'relation_with_emergency_contact',
        'emeregency_contact_name'
    ];

    public function userlogin(){
        
        return $this->hasOne(userLogin::class,"user_detail_id");
    }
     
    public function scopeMale($query) {
        return $query->where('gender','male');
    }

    public function scopeFemale($query) {
        return $query->where('gender','female');
    }

    public function full_name() {

        $full_name = $this->first_name;
        if ($this->middle_name) {
            $full_name .= " ";
            $full_name .= $this->middle_name;
        }
        $full_name .= " ";
        $full_name .= $this->last_name;
        return $full_name;
    }
    
    public function address()
    {
        return $this->country . ", " . $this->city;
    }

    public function parent()
    {
        return $this->belongsTo(static::class,'married_to_id');
    }

    public function children(){
        return $this->hasOne(static::class,'married_to_id');
    }

    public function userreference()
    {
        return $this->hasOne(userReference::class,"user_detail_id");
    }

    public function userverification()
    {
        return $this->hasOne(UserVerification::class,'user_detail_id');
    }

    public function donation(){
        return $this->hasOne(Donation::class,'user_detail_id');
    }

    public function night(){
        return $this->hasOne(Night::class,'user_detail_id');
    }

    public function user_medias(){
        return $this->hasMany(userMedia::class,'user_detail_id');
    }

    public function user_profile(){
        return $this->hasOne(userMedia::class,'user_detail_id')
                    ->where('active',true);
    }

    public function user_sewa(){
        return $this->hasMany(UserSewaBridge::class,'user_id')->where('user_involvement','sewa_interested');
    }

    public function user_assigned_sewa(){
        return $this->hasMany(UserSewaBridge::class,'user_id')->where('user_involvement','sewa_involved');
    }

    public function sibir_records(){
        return $this->hasMany(UserSibirRecord::class);
    }

    public function sibir_preference(){
        return $this->hasOne(UserSadhanaCenter::class,'user_detail_id')
                    ->where('pending',true);
    }

    public function user_mental_status(){
        return $this->hasOne(SadhakMentalQueries::class)->latest();
    }

    public function user_health_data(){
        return $this->hasMany(SadhakMentalQueries::class);
    }

    public function country_name(){
        return $this->hasOne(Countries::class,"id","country");
    }

    public function city_name() {
        return $this->hasOne(City::class,"id",'city');
    }
}
