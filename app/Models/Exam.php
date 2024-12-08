<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function scopeInExam($query)
    {
        return $query->where('session_year', getYearNow()->id)
                     ->where('school_id', getSchool()->id);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
}
