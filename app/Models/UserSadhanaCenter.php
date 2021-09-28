<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSadhanaCenter extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "user_sadhana_registration_preference";

    protected $fillable = [
        'user_detail_id',
        'center_id',
        'reference_type',
        'confirmed',
        'cancelled',
        'pending',
        'verified',
        'completed',
        'status_updated_by'
    ];

    public function users(){
        return $this->belongsTo(userDetail::class);
    }
    
}
