<?php

namespace App\Models;

use App\Models\Classes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'classrooms';

    protected $hidden = ['created_at','updated_at'];
    public $translatable = ['name'];
    protected $fillable = ['name','grade_id','class_id','school_id','notes'];

    public function classe()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'section_id')->where('school_id',getSchool()->id);
    }


    public function timeTable()
    {
        return $this->hasMany(Timetable::class, 'section_id')->with('subject_teacher');
    }
    public function lessons()
    {
        return $this->hasMany(lesson::class, 'section_id')->with('file');
    }
    public function subject()
    {
        return $this->hasMany(SubjectTeacher::class, 'class_section_id')->with('subject');
    }
    public function student_promotions()
    {
        return $this->hasMany(Promotion::class, 'from_section');
    }

    public function fees_class() {
        return $this->hasOne(FeesClass::class, 'class_section_id', 'id');
    }


    public function setNameAttribute($value)
    {
        $this->setTranslations('name', [
            $this->getLocale() => $value
        ]);
    }
}
