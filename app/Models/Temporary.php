<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'agent_value',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'customer_phone', 'customer_phone')->latest();
    }
}
// 