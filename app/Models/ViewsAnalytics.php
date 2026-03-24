<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewsAnalytics extends Model
{
    protected $fillable = ['viewTime', 'local_offer_id'];

    public function localOffer()
    {
        return $this->belongsTo(LocalOffer::class);
    }
}
