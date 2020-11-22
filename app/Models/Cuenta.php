<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuenta';
    protected $fillable = ['moneda','nombre_corto','descripcion','saldo_inicial','usuario_id'];
}
