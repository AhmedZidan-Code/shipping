<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'trader_id',
        'govern_id',
        'value',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }

    public function govern()
    {
        return $this->belongsTo(Area::class, 'govern_id');
    }
}
