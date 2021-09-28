<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SadhakMentalQueries extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "sadhak_mental_quries";

    protected $fillable = [
        'user_detail_id',
        'is_visitor_alone',
        'visitors_relative_name',
        'visitors_relative_relation',
        'visitors_relative_contact',
        'is_first_visit',
        'have_physical_difficulties',
        'describe_physical_difficulties',
        'have_mental_problem',
        'describe_mental_problem',
        'have_practised_before',
        'will_help',
        'ads_source',
        'is_agreed_terms',
        'is_sadhak_linked',
        'sadhak_linked_id'
    ];
}
