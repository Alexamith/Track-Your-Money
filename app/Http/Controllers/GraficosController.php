<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    // public function traslados($cuentaD, $cuentaC, $monto)
    // {
    //     $cuentaDebito = Cuenta::findOrFail($cuentaD);
    //     $cuentaCredito = Cuenta::findOrFail($cuentaC);
    //     $moneda_id = \DB::select("select moneda from cuenta where id =" . $cuentaD);
    //     $moneda_id = $moneda_id[0]->moneda;
    //     $moneda2_id = \DB::select("select moneda from cuenta where id =" . $cuentaC);
    //     $moneda2_id = $moneda2_id[0]->moneda;
    //     if ($moneda_id != $moneda2_id) {
    //         $tasa_cambio =  \DB::select("select monto_equivalente from tasa where moneda_local =" . $moneda_id . " and moneda_equivalente =" . $moneda2_id);
    //         $tasa_cambio =  $tasa_cambio[0]->monto_equivalente;
    //         $cuentaDebito->saldo_inicial =  $cuentaDebito->saldo_inicial - $monto;
    //         $monto = $monto * (float)$tasa_cambio;
    //         $cuentaCredito->saldo_inicial =  $cuentaCredito->saldo_inicial + $monto;
    //     } else {
    //         $cuentaDebito->saldo_inicial =  $cuentaDebito->saldo_inicial - $monto;
    //         $cuentaCredito->saldo_inicial =  $cuentaCredito->saldo_inicial + $monto;
    //     }
    //     $cuentaDebito->save();
    //     $cuentaCredito->save();
    // }
    public function convertir($usuario)
    {
        $moneda_local = \DB::select("select id from moneda where usuario_id =" . $usuario . " and nacional ='1'");
        $moneda_local = $moneda_local[0]->id;
        $monedas_en_las_cuentas = \DB::select("select * from cuenta where usuario_id =" . $usuario . " order by saldo_inicial");

        foreach ($monedas_en_las_cuentas as $key) {

            if ($key->moneda != $moneda_local) {
                $buscar_tasa_de_conversion = \DB::select("select monto_equivalente from tasa where moneda_local =" . $key->moneda . " and moneda_equivalente =" . $moneda_local);
                $buscar_tasa_de_conversion = $buscar_tasa_de_conversion[0]->monto_equivalente;
                $key->saldo_inicial =  (float)$key->saldo_inicial * (float)$buscar_tasa_de_conversion;
            }
        }
        return $monedas_en_las_cuentas;
    }

    public function Cuentas_actuales_con_sus_respectivos_saldos(Request $request)
    {
        $this->traslados(18, 19, 300);
        $usuario = \Auth::user()->id;
        $tipo = $request->tipo;
        if ($tipo == 'cuentas') {
            $cuentas = $this->convertir($usuario);
            return \Response::json($cuentas);
        }
        if ($tipo == 'ingresos') {
            $cuentas = \DB::select("select c.categoria_padre, c.presupuesto from categoria as c where usuario_id =" . $usuario . " and c.tipo = 2 order by c.presupuesto");
            return \Response::json($cuentas);
        }
        if ($tipo == 'gastos') {
            $cuentas = \DB::select("select c.categoria_padre, c.presupuesto from categoria as c where usuario_id =" . $usuario . " and c.tipo = 1 order by c.presupuesto");
            return \Response::json($cuentas);
        }
    }
}
