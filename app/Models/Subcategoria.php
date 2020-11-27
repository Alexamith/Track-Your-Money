<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $table = 'subcategoria';
    protected $fillable = ['categoria_id','detalle','nombre','presupuesto'];
}
