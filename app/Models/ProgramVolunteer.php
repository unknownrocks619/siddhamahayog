<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramVolunteer
 *
 * @property int $id
 * @property int $program_id
 * @property int|null $member_id
 * @property int $volunteer_group_id
 * @property string $full_name
 * @property string|null $gotra
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $country
 * @property string|null $full_address
 * @property string|null $education
 * @property string|null $gender
 * @property string|null $profession
 * @property int|null $involved_in_program
 * @property int|null $was_involved_in_volunteer
 * @property int|null $confirm_presence
 * @property int|null $accept_terms_and_conditions
 * @property int|null $accepted_as_volunteer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramVolunteerAvailableDates> $availableDates
 * @property-read int|null $available_dates_count
 * @property-read \App\Models\Member|null $member
 * @property-read \App\Models\Program|null $program
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereAcceptTermsAndConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereAcceptedAsVolunteer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereConfirmPresence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereGotra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereInvolvedInProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereVolunteerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer whereWasInvolvedInVolunteer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteer withoutTrashed()
 * @mixin \Eloquent
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
