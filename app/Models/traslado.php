<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class traslado extends Model
{
    protected $table = 'traslado';
    protected $fillable = ['cuenta_debito','monto_debitado','cuenta_credito','monto_acreditado'];
}
