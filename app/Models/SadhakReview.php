<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SadhakReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_detail_id',
        'center_id',
        'user_sadhak_registration_id',
        'user_sadhana_registration_preference_id',
        'total_rating',
        'reviews',
        'suggestion',
        'review_document'
    ];
}
