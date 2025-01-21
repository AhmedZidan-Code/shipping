<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPayment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function agent()
    {
        return $this->belongsTo(Delivery::class, 'agent_id');
    }
}
