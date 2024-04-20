<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
class Acadimy extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at','updated_at'];
    protected $table = 'info_acadimy';
    protected $fillable = [
        'name', 'description','image','adress','email'
    ];

}
