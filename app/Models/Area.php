<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;
    protected $guarded=[];

    public function country(){
        return $this->belongsTo(Area::class,'from_id');
    }
}
