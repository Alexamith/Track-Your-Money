<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    public function Cuentas_actuales_con_sus_respectivos_saldos(Request $request)
    {

        $usuario = \Auth::user()->id;
        $cuentas = \DB::select("select * from moneda where usuario_id =".$usuario."and nacional ='1'");
        $tipo = $request->tipo;
        if ($tipo == 'cuentas') {
            $cuentas = \DB::select("select * from cuenta where usuario_id =" . $usuario . " order by saldo_inicial");
            return \Response::json($cuentas);
        }
        if ($tipo == 'ingresos') {
            $cuentas = \DB::select("select c.categoria_padre, c.presupuesto from categoria as c where usuario_id =".$usuario." and c.tipo = 2 order by c.presupuesto");
            return \Response::json($cuentas);
        }
        if ($tipo == 'gastos') {
            $cuentas = \DB::select("select c.categoria_padre, c.presupuesto from categoria as c where usuario_id =".$usuario." and c.tipo = 1 order by c.presupuesto");
            return \Response::json($cuentas);
        }
    }
}
