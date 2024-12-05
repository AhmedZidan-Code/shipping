<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraderPayments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'paid_id');
    }

    public function scopeCollectibleTraders()
    {
        return $this->trader()->where('is_collectible', true);
    }
}
