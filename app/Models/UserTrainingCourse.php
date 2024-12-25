<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTrainingCourse extends Model
{
    use HasFactory;

    protected $table = "user_training_courses";
    protected $fillable = [
        'id_user',
        'event_id',
        'course_group_name',
        'course_description',
        'course_end_date',
        'course_duration',
        'course_status',
        'training_location',
    ];

    /**
     * Get the list of enrolled user.
     */

    public function enrolledUsers()
    {
        return $this->hasManyThrough(Member::class, MemberUnderLink::class, 'teacher_training_id', 'id', 'id', 'student_id');
    }
}
