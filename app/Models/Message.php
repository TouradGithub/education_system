<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable=[
        'body',
        'school_id',
        'session_year',
        'conversation_id',
        'sender_id' ,
        'receiver_id',
        'read_at',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function isRead():bool
    {
        return $this->read_at != null;
    }
    public function sender()
    {
        return $this->belongsTo(Teacher::class, 'sender_id');
    }

}
