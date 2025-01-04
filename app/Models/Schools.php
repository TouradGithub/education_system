<?php

namespace App\Models;
use App\Models\AcademyManegment;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class Schools extends Model
{
    use SoftDeletes;

    protected $table = 'info_schools';

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $fillable = [
        'name', 'description','image','adress','email','type','grade_id','academy_id'
    ];

    public function setting()
    {
        return $this->hasOne(Settings::class, 'school_id');
    }

    public function academy()
    {
        return $this->belongsTo(Acadimy::class, 'academy_id');

    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');

    }

    public function sections(){
        return $this->hasMany(ClassRoom::class ,'school_id');
    }

    public function students() {
        return $this->hasOne(Student::class, 'school_id', 'id');
    }

    // public function parent() {
    //     return $this->hasOne(Parents::class, 'user_id', 'id');
    // }

    // public function teacher() {
    //     return $this->hasOne(Teacher::class, 'user_id', 'id');
    // }

    //Getter Attributes
    public function getImageAttribute($value) {
        return url(Storage::url($value));
    }
}
