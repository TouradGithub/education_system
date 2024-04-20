<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $hidden = ['created_at','updated_at'];
    public function classRoom()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
