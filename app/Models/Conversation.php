<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
class Conversation extends Model
{
    use HasFactory;
    protected $fillable=[
        'receiver_id',
        'sender_id',
        'school_id',
        'session_year',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }



    public function scopeInConversation($query)
    {
        return $query->where('session_year', getYearNow()->id)
                     ->where('school_id', getSchool()->id);
    }


    public function getReceiver()
    {
        return Teacher::find($this->receiver_id);
    }
    public function getSender()
    {

            return Teacher::find($this->sender_id);
    }

    public  function isLastMessageReadByUser() {


        $user=Auth::guard('teacher')->user();
        $lastMessage= $this->messages()->latest()->first();


        if($lastMessage){
            return   $lastMessage->body;
        }
        // if($lastMessage && $lastMessage->read_at !=null && $lastMessage->sender_id == $user->id){
        //     return   $lastMessage->body;
        // }
        // return false;
    }




//    public  function unreadMessagesCount() : int {


//     return $unreadMessages= Message::where('conversation_id','=',$this->id)
//                                 ->where('receiver_id',Auth::guard('teacher')->id())
//                                 ->whereNull('read_at')->count();

//     }
}
