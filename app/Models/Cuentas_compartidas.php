<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentas_compartidas extends Model
{
    protected $table = 'cuentas_compartidas';
    protected $fillable = ['cuenta_id', 'usuario_a_compartir_id'];
}
