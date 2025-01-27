<?php

namespace App\Models;
use App\Models\Classes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    use HasTranslations;
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


    public function timeTable()
    {
        return $this->hasMany(Timetable::class, 'section_id')->with('subject_teacher');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'section_id')->with('file');
    }
    public function subject()
    {
        return $this->hasMany(SubjectTeacher::class, 'class_section_id')->with('subject');
    }

    public function fees_class() {
        return $this->hasOne(FeesClass::class, 'class_section_id');
    }


    public function setNameAttribute($value)
    {
        $this->setTranslations('name', [
            $this->getLocale() => $value
        ]);
    }
}
