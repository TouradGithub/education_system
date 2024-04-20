<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $hidden = ['created_at','deleted_at','updated_at'];

    use HasFactory;
    public function scopeInStudent($query)
    {
        return $query->where('academic_year', getYearNow()->id)
                     ->where('school_id', getSchool()->id);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class)->with('subject');
    }
    public function exams()
    {
        return $this->hasMany(Exam::class)->with('subject');
    }
    public function parent()
    {
        return $this->belongsTo(MyParent::class, 'parent_id');
    }
}
