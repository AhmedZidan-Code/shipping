<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Trader extends Authenticatable
{
    use HasFactory;
    protected $guarded=[];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'trader_id', 'id');
    }
}
