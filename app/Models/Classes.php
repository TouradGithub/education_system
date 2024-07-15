<?php

namespace App\Models;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $hidden = ['created_at','updated_at'];
    protected $table = 'classes';
    public $translatable = ['name'];
    protected $fillable=['name','grade_id','arrangement','notes'];


    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function sections()
    {
        return $this->hasMany(ClassRoom::class, 'class_id')->where('school_id',getSchool()->id);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
