<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];


    public function clasroom()
    {
        return $this->belongsTo(Classes::class, 'class_section_id');
    }
    public function section()
    {
        return $this->belongsTo(ClassRoom::class,'class_section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function scopeInSubjectTeacher($query)
    {
        return $query->where('school_id', getSchool()->id);
    }
}
