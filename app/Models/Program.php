<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected string $foreignKey = "program_id";

    protected $auditable = [
        'program_name' => 'Program Name'
    ];
    protected  $fillable = [
        'program_duration',
        'program_access',
        'admission_fee',
        'monthly_fee',
        'program_start_date',
        'program_end_date',
        'promote',
        'description',
        'overdue_allowed',
        'batch',
        'zoom',
        'slug',
        'program_name',
        'program_type'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'zoom',
        'admission_fee',
        'monthly_fee',
        'program_access',
    ];

    protected $alias = [
        'id' => "Program ID"
    ];

    public const PROGRAM_TYPES = [
        'open' => 'Open',
        'paid'  => 'Paid',
        'live'  => 'Live',
        'registered_user' => "Registered User",
        'club'  => 'Club',
        'sadhana'   => 'Sadhana',
        'event' => 'Event'
    ];

    public const PROGRAM_STATUS = [
        'active'    =>  'Active',
        'pending'   => 'Pending',
        'inactive'  => 'Inactive'
    ];

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, $this->foreignKey);
    }

    public function program_active_student()
    {
        return $this->hasOne(ProgramStudent::class, $this->foreignKey)->where('student_id', user()->getKey())->where('active', true)->first();
    }

    /**
     * Active Batch Group
     */
    public function active_batch()
    {
        return $this->hasOne(ProgramBatch::class, $this->foreignKey)->where('active', true)->latest();
    }

    /**
     * List all available batches for a program
     */
    public function batches()
    {
        return $this->hasMany(ProgramBatch::class, $this->foreignKey);
    }

    /**
     * List all  videos for a program.
     */
    public function program_videos()
    {
        return $this->hasMany(ProgramChapterLession::class, $this->foreignKey);
    }

    /**
     * List all video courses for a program.
     */
    public function videoCourses()
    {
        return $this->hasMany(ProgramCourse::class, $this->foreignKey);
    }

    /**
     * List all course / syllabus
     */
    public function courses()
    {
        return $this->hasMany(ProgramCourseResources::class, $this->foreignKey);
    }

    /**
     * List current rule for fee structure.
     */
    public function active_fees()
    {
        return $this->hasOne(ProgramCourseFee::class, $this->foreignKey)->latest();
    }

    /**
     * List over all fee of the student.
     */
    public function student_fee()
    {
        return $this->hasOne(ProgramStudentFee::class, $this->foreignKey);
    }

    /**
     * Active Section for a program.
     */
    public function active_sections()
    {
        return $this->hasOne(ProgramSection::class, $this->foreignKey)->where('default', true);
    }

    /**
     * List all available sections
     */
    public function sections()
    {
        return $this->hasMany(ProgramSection::class, $this->foreignKey);
    }

    /**
     * User last watched videos.
     */
    public function last_video_history()
    {
        return $this->hasOne(LessionWatchHistory::class, $this->foreignKey)->where('student_id', auth()->id())->latest();
    }

    /**
     * Retrieve admission fee for the student.
     */
    public function student_admission_fee()
    {
        return $this->hasOne(ProgramStudentFeeDetail::class, $this->foreignKey)->where('student_id', auth()->id())->where('amount_category', 'admission_fee')->where('verified', true);
    }


    /**
     * Retrieve admission fee for the student.
     */
    public function admission_fee()
    {
        return $this->hasOne(ProgramStudentFeeDetail::class, $this->foreignKey)->where('student_id', auth()->id())->where('amount_category', 'admission_fee')->latest();
    }


    public function liveProgram()
    {
        return $this->hasMany(Live::class, "program_id")->where('live', true);
    }

    public function allLivePrograms()
    {
        return $this->hasMany(Live::class, "program_id")->where('live', true);
    }
}
