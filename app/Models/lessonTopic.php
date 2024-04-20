<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lessonTopic extends Model
{
    use HasFactory;
    protected $hidden = ["deleted_at", "created_at", "updated_at"];

    public function file() {
        return $this->morphMany(File::class, 'modal');
    }

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }
}
