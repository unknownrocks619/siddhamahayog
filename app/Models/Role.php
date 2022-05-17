<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    /**
     * 1 => ADMIN
     * 2 => CENTERS
     * 3 => SADHAKS
     * 4 => TEACHERS
     * 5 => ADMIN_TEACHER
     * 6 => MARKETING
     */
}
