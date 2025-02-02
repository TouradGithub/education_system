<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Student extends Model
{
    protected $hidden = ['created_at','deleted_at','updated_at'];
    protected $fillable = [
        'first_name',
        'last_name',
        'grade_id',
        'class_id',
        'section_id', // Added for mass assignment
        'acadimic_id',
        'school_id',
        'gender',
        'image',
        'academic_year',
        'date_birth',
        'roll_number',
        'blood_group',
        'parent_id',
        'current_address',
        'permanent_address',
        'qr_code',
        'cratedby',
        'status',
    ];


    use  HasFactory, Notifiable;
     public function studentAccount()
    {
        return $this->hasOne(StudentAcount::class, 'student_acount_id');
    }
    public function scopeInStudent($query)
    {
        return $query->where('academic_year', getYearNow()->id)
                     ->where('school_id', getSchool()->id);
    }
    public function section()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class)->with('subject');
    }
    public function attendance(){
        return $this->hasMany(Attendance::class)->where('session_year',getYearNow()->id);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class)->with('subject');
    }
    public function parent()
    {
        return $this->belongsTo(MyParent::class, 'parent_id');
    }

    public function fees_paid() {
        return $this->hasMany(FeesPaid::class, 'student_id')->with('section');
    }
    public function sessionyear() {
        return $this->belongsTo(SessionYear::class,'academic_year');
    }

}
