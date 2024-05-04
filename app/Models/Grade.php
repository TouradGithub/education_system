<?php

namespace App\Models;
use App\Models\Classes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['name'];
    protected $fillable=['name','notes'];


    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
    public function sections()
    {
        return $this->hasMany(ClassRoom::class, 'grade_id');
    }

    public function getArabicNameAttribute()
    {
        return $this->getTranslation('name', 'ar');
    }
}
