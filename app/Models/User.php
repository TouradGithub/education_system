<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Schools;
use App\Models\Acadimy;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        "phone",
        "role",
        'model',
        'model_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        "deleted_at",
        "created_at",
        "updated_at"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function student() {
    //     return $this->hasOne(Students::class, 'user_id', 'id');
    // }

    // public function parent() {
    //     return $this->hasOne(Parents::class, 'user_id', 'id');
    // }

    // public function teacher() {
    //     return $this->hasOne(Teacher::class, 'user_id', 'id');
    // }
    public function school()
    {
        if ($this->mode == 'App\\Models\\Schools') {
            return $this->belongsTo(Schools::class, 'model_id');
        }
        return  $this->belongsTo(Schools::class, 'model_id')->first();
    }

    public function academy()
    {
        if ($this->mode == 'App\\Models\\Acadimy') {
            return $this->belongsTo(Acadimy::class, 'model_id');
        }
        return $this->belongsTo(Acadimy::class, 'model_id')->first();
    }

    //Getter Attributes
    public function getImageAttribute($value) {
        return url(Storage::url($value));
    }
}
