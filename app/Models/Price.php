<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function trader(){
        return $this->belongsTo(Trader::class,'trader_id');
    }
    
    public function govern(){
        return $this->belongsTo(Area::class,'govern_id');
    }
}
