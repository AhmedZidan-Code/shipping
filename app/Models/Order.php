<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function province(){
        return $this->belongsTo(Area::class,'province_id');
    }
    public function trader(){
        return $this->belongsTo(Trader::class,'trader_id');
    }

    public function delivery(){
        return $this->belongsTo(Delivery::class,'delivery_id');
    }
    public function payment(){
        return $this->belongsTo(TraderPayments::class,'paid_id');
    }
}
