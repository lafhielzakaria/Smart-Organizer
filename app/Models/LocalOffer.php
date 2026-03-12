<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalOffer extends Model
{
    protected $fillable = ['startTime', 'endTime', 'pricePerPerson', 'maxParticipants', 'status', 'local_id'];

    protected $casts = [
        'startTime' => 'datetime',
        'endTime' => 'datetime',
    ];

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function chatRoom()
    {
        return $this->hasOne(ChatRoom::class);
    }

    public function viewsAnalytics()
    {
        return $this->hasMany(ViewsAnalytics::class);
    }
}
