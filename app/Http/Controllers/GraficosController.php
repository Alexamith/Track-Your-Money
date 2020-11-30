<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    public function __construct()
    {
        // $this->FunctionName();
    }
   public function FunctionName()
   {
       # code...
         $usuario = 11;
         $fecha1 = '28/11/2020';
         $fecha2 = '01/12/2020';
        //  dd($fecha1);
        // echo date("Y-m-d", strtotime("2020-11-29"))."\n"; 
        $cuentas = \DB::select("select sum(t.monto) as gastos
        from transaccion as t
        join categoria as c
        on t.categoria = c.id
        join cuenta cu
        on t.cuenta = cu.id
        and cu.usuario_id =".$usuario."
        and c.tipo = 1
        and t.created_at between '".$fecha1."' and '".$fecha2."'
        union
        select sum(t.monto) as ingresos
        from transaccion as t
        join categoria as c
        on t.categoria = c.id
        join cuenta cu
        on t.cuenta = cu.id
        and cu.usuario_id =".$usuario."
        and c.tipo = 2
        and t.created_at between '".$fecha1."' and '".$fecha2."'");
        dd($cuentas);
   }
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

    
        if ($tipo == 'entre_2_fechas') {
            $fecha1 = $request->fecha_incio;
            $fecha2 = $request->fecha_fin;
            $cuentas = \DB::select("select sum(t.monto) as gastos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 1
            and t.created_at between '".$fecha1."' and '".$fecha2."'
            union
            select sum(t.monto) as ingresos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 2
            and t.created_at between '".$fecha1."' and '".$fecha2."'");
            return \Response::json($cuentas);
        }


    }
}
