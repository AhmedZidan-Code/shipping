<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeSetting extends Model
{
    use HasFactory;

    protected $table = 'administrative_settings';
    protected $guarded = [];
}
