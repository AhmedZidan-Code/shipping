<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'govern_id',
        'value',
    ];

    public function agent()
    {
        return $this->belongsTo(Delivery::class, 'agent_id');
    }

    public function govern()
    {
        return $this->belongsTo(Area::class, 'govern_id');
    }
}
