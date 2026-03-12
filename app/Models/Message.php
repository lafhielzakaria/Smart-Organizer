<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content', 'sender_id', 'chat_room_id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }
}
