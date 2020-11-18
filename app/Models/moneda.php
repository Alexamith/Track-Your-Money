<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'moneda';
    protected $fillable = ['nombre_corto', 'simbolo','descripcion','tasa','usuario_id'];
}
