<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $fillable = ['creator_id', 'name', 'type', 'capacity', 'andreas', 'price', 'status'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function localOffers()
    {
        return $this->hasMany(LocalOffer::class);
    }
}
