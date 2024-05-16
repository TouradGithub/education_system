<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassScraping extends Model
{
    use HasFactory;
    protected $table = 'class_scraping';
    protected $fillable = [ 'name','grade_id'];
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function subjects()
    {
        return $this->hasMany(SubjectScraping::class,'class_id');
    }
}
