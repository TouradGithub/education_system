<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Announcement extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $hidden = ["deleted_at", "updated_at"];

    public function table() {
        return $this->morphTo()->withTrashed();
    }

    public function file() {
        return $this->morphMany(File::class, 'modal');
    }
}
