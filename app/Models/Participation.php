<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = ['joinedAt', 'user_id', 'sharePrice', 'leftAt', 'local_offer_id'];

    protected $casts = [
        'joinedAt' => 'datetime',
        'leftAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function localOffer()
    {
        return $this->belongsTo(LocalOffer::class);
    }
}
