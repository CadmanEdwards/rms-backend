<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredDevice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'bl_equipos';

    public $timestamps = false;

}
