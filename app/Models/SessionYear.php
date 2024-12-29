<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
class SessionYear extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at','deleted_at'];
    public function students()
    {
        return $this->hasMany(Student::class, 'academic_year');
    }
}
