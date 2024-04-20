<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $hidden = ['created_at','updated_at'];
    public function school()
    {
        return $this->belongsTo(Schools::class,'school_id');
    }

    public function sectionTeachers()
    {
        return $this->hasMany(SubjectTeacher::class, 'teacher_id')->with('section')->with('subject');
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id')
            ->orWhere('receiver_id', $this->id);
            // ->whereNotDeleted();
    }

    public function unreadMessagesCount()
    {
        $userId = Auth::guard('teacher')->id();

        // Count unread messages for the current user across all conversations
        return Message::where('receiver_id', $userId)
                      ->where('read_at', null)
                      ->count();
    }

    public function unreadMessages()
    {
        $userId = Auth::guard('teacher')->id();

        // Count unread messages for the current user across all conversations
        return Message::where('receiver_id', $userId)
                      ->where('read_at', null)
                      ->get();
    }


}
