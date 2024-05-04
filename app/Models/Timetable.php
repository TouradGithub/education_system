<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];

    // public function subject_teacher() {
    //     return $this->belongsTo(SubjectTeacher::class)->with('subject')->with('teacher');
    // }
    public function scopeInTimetable($query)
    {
        return $query->where('session_year', getYearNow()->id)
                     ->where('school_id', getSchool()->id);
                     
    }

    public function subject_teacher()
    {
        return $this->belongsTo(SubjectTeacher::class, 'subject_teacher_id')->with('subject')->with('teacher');
    }

    public function section()
    {
        return $this->belongsTo(ClassRoom::class,'section_id')->with('classe');
    }

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class, 'subject_teacher_id', 'subject_teachers.teacher_id');
    // }
}
