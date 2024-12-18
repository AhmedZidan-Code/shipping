<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Delivery extends Authenticatable
{
    use HasFactory;
    protected $guarded=[];

    public function orders()
    {
        return $this->hasMany(Order::class,'delivery_id');
    }
}
