<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class ProgramVolunteer extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'program_id',
        'member_id',
        'volunteer_group_id',
        'full_name',
        'gotra',
        'email',
        'phone_number',
        'country',
        'full_address',
        'education',
        'gender',
        'profession',
        'involved_in_program',
        'was_involved_in_volunteer',
        'confirm_presence',
        'accept_terms_and_conditions',
        'accepted_as_volunteer',
    ];

    protected  $with = [
        'availableDates',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member() {
        return $this->belongsTo(Member::class,'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program() {
        return $this->belongsTo(Program::class,'program_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availableDates() {
        return $this->hasMany(ProgramVolunteerAvailableDates::class,'program_volunteer_id');
    }
}
