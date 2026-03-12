<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = ['local_offer_id'];

    public function localOffer()
    {
        return $this->belongsTo(LocalOffer::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
