<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVerification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_detail_id',
        'verification_type',
        'document_file_detail',
        'parent_id',
        'parent_name',
        'parent_phone',
        'verified',
        'created_by_user'
    ];

    public function userdetail(){
        return $this->belongsTo(userDetail::class);
    }

    public function center() {
        return $this->belongsTo(Center::class);
    }
}


