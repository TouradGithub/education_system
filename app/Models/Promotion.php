<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_id',
        'from_section',
        'to_section',
        'academic_year',
        'academic_year_new',
        'decision',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }

    public function fromSection()
    {
        return $this->belongsTo(ClassRoom::class, 'from_section');
    }

    public function toSection()
    {
        return $this->belongsTo(ClassRoom::class, 'to_section');
    }

    public function school()
    {
        return $this->belongsTo(Schools::class,'school_id');
    }

    public function fromSessionyear() {
        return $this->belongsTo(SessionYear::class,'academic_year');
    }

    public function toSessionyear() {
        return $this->belongsTo(SessionYear::class,'academic_year_new');
    }
}
