<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Live
 *
 * @property int $id
 * @property int $program_id
 * @property int $live
 * @property int|null $section_id
 * @property string|null $meeting_id
 * @property int $zoom_account_id
 * @property string|null $admin_start_url
 * @property string|null $join_url
 * @property string|null $ends_at
 * @property int $lock
 * @property string|null $lock_text
 * @property string $domain
 * @property int|null $started_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property object|null $merge
 * @property int|null $closed_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudentAttendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Program $program
 * @property-read \App\Models\Member|null $programCordinate
 * @property-read \App\Models\ProgramSection|null $programSection
 * @property-read \App\Models\ProgramSection|null $sections
 * @property-read \App\Models\ZoomAccount $zoomAccount
 * @method static \Illuminate\Database\Eloquent\Builder|Live newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Live newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Live onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Live query()
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereAdminStartUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereClosedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereJoinUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereLockText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereMerge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereStartedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live whereZoomAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Live withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Live withoutTrashed()
 * @mixin \Eloquent
 */
class Live extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $casts = [
        "merge" => "object"
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'admin_start_url',
        'program_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zoomAccount()
    {
        return $this->belongsTo(ZoomAccount::class, "zoom_account_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sections()
    {
        return $this->belongsTo(ProgramSection::class, "section_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programSection()
    {
        return $this->belongsTo(ProgramSection::class, 'section_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function programCordinate()
    {
        return $this->belongsTo(Member::class,'started_by');
        // return $this->guessBelongsToRelation(Member::class, "started_by");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany(ProgramStudentAttendance::class, 'meeting_id', 'meeting_id');
    }
}
