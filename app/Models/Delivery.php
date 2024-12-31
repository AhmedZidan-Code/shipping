<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $guarded=[];

    public function orders()
    {
        return $this->hasMany(Order::class,'delivery_id');
    }
}
