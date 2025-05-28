<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTrack extends Model
{
    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'course',
        'school Attended',
    ];
}