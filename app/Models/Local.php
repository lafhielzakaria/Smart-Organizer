<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $fillable = ['creator_id', 'name', 'type', 'capacity', 'city', 'andreas', 'price', 'status'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function localOffers()
    {
        return $this->hasMany(LocalOffer::class);
    }

    public function getTotalViewTimeAttribute()
    {
        return $this->localOffers()->withSum('viewsAnalytics', 'viewTime')->get()->sum('views_analytics_sum_viewTime');
    }
}
