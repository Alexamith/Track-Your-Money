<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    public function Cuentas_actuales_con_sus_respectivos_saldos (Request $request)
    {
        $tipo = $request->tipo;
        $usuario = \Auth::user()->id;
        $cuentas = \DB::select("select * from cuenta where usuario_id =".$usuario." order by saldo_inicial");
        return \Response::json($cuentas);
    }
}
