<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transaccion';
    protected $fillable = ['categoria_padre','tipo','descripcion','presupuesto','usuario_id'];
}
