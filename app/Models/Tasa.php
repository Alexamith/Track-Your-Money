<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasa extends Model
{
    protected $table = 'tasa';
    protected $fillable = ['moneda_local', 'monto_local',
    'moneda_equivalente','monto_equivalente'];
}

