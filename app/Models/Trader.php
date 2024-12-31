<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Trader extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $guarded=[];

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'trader_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(TraderPayments::class, 'trader_id', 'id');
    }
}
