<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAnnoucement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description','image','model','model_id','session_year','school_id'
    ];
   
}
