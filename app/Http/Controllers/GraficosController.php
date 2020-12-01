<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('America/Costa_Rica');
        $this->FunctionName();

    }
   public function FunctionName()
   {
    // $moneda_local = \DB::select("select id from moneda where usuario_id = 11 and nacional ='1'");
    // $moneda_local=$moneda_local[0]->id;
    // $suma_gastos_e_ingresos_moneda_local =\DB::select("select sum(t.monto) as saldo from transaccion as t join cuenta as c on t.cuenta = c.id join categoria as ca on t.categoria = ca.id
    // join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 1 and m.nacional = true and t.created_at between '".$fecha1."' and '".$fecha2."'
    // union select sum(t.monto) as saldo from transaccion as t join cuenta as c on t.cuenta = c.id join categoria as ca on t.categoria = ca.id 
    // join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 2 and m.nacional = true and t.created_at between '".$fecha1."' and '".$fecha2."'");
  
    // $suma_gastos_e_ingresos_moneda_local[0]->saldo = (float)$suma_gastos_e_ingresos_moneda_local[0]->saldo;
    // $suma_gastos_e_ingresos_moneda_local[1]->saldo = (float)$suma_gastos_e_ingresos_moneda_local[1]->saldo;
    // $suma_gastos_e_ingresos_moneda_extranjera = \DB::select("select sum(t.monto) as monto, m.id, ca.tipo from transaccion as t join cuenta as c
    // on t.cuenta = c.id join categoria as ca on t.categoria = ca.id join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 1 and m.nacional = false
    // and t.created_at between '".$fecha1."' and '".$fecha2."' group by  m.id,ca.tipo union select sum(t.monto) as monto, m.id,ca.tipo from transaccion as t join cuenta as c on t.cuenta = c.id join categoria as ca on t.categoria = ca.id
    // join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 2 and m.nacional = false and t.created_at between '".$fecha1."' and '".$fecha2."' group by  m.id,ca.tipo order by (monto)");
    
    // foreach ($suma_gastos_e_ingresos_moneda_extranjera as $key) {
    //     $buscar_tasa_de_conversion = \DB::select("select monto_equivalente from tasa where moneda_local =" . $key->id . " and moneda_equivalente =" . $moneda_local);
    //     $buscar_tasa_de_conversion = (double)$buscar_tasa_de_conversion[0]->monto_equivalente;
    //     $key->monto = $buscar_tasa_de_conversion * (double)$key->monto;
    //     if($key->tipo == 1){
    //         $suma_gastos_e_ingresos_moneda_local[0]->saldo = $suma_gastos_e_ingresos_moneda_local[0]->saldo +$key->monto;
    //     }else if($key->tipo == 2){
    //         $suma_gastos_e_ingresos_moneda_local[1]->saldo = $suma_gastos_e_ingresos_moneda_local[1]->saldo +$key->monto;

    //     }
        
    // }
    // dd($suma_gastos_e_ingresos_moneda_local);    
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
            // if (1==1) {
            
            $fecha1 = $request->fecha_incio;
            $fecha2 = $request->fecha_fin;
            //  $fecha1 = "20/11/2020";
            // $fecha2 = "30/11/2020";
            // $cuentas = \DB::select("select sum(t.monto) as gastos
            // from transaccion as t
            // join categoria as c
            // on t.categoria = c.id
            // join cuenta cu
            // on t.cuenta = cu.id
            // and cu.usuario_id =".$usuario."
            // and c.tipo = 1
            // and t.created_at between '".$fecha1."' and '".$fecha2."'
            // union
            // select sum(t.monto) as ingresos
            // from transaccion as t
            // join categoria as c
            // on t.categoria = c.id
            // join cuenta cu
            // on t.cuenta = cu.id
            // and cu.usuario_id =".$usuario."
            // and c.tipo = 2
            // and t.created_at between '".$fecha1."' and '".$fecha2."'");
            $moneda_local = \DB::select("select id from moneda where usuario_id = 11 and nacional ='1'");
            $moneda_local=$moneda_local[0]->id;
            $suma_gastos_e_ingresos_moneda_local =\DB::select("select sum(t.monto) as saldo from transaccion as t join cuenta as c on t.cuenta = c.id join categoria as ca on t.categoria = ca.id
            join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 1 and m.nacional = true and t.created_at between '".$fecha1."' and '".$fecha2."'
            union select sum(t.monto) as saldo from transaccion as t join cuenta as c on t.cuenta = c.id join categoria as ca on t.categoria = ca.id 
            join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 2 and m.nacional = true and t.created_at between '".$fecha1."' and '".$fecha2."'");

            
            $suma_gastos_e_ingresos_moneda_extranjera = \DB::select("select sum(t.monto) as monto, m.id, ca.tipo from transaccion as t join cuenta as c
            on t.cuenta = c.id join categoria as ca on t.categoria = ca.id join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 1 and m.nacional = false
            and t.created_at between '".$fecha1."' and '".$fecha2."' group by  m.id,ca.tipo union select sum(t.monto) as monto, m.id,ca.tipo from transaccion as t join cuenta as c on t.cuenta = c.id join categoria as ca on t.categoria = ca.id
            join moneda as m on c.moneda = m.id and c.usuario_id = 11 and ca.tipo = 2 and m.nacional = false and t.created_at between '".$fecha1."' and '".$fecha2."' group by  m.id,ca.tipo order by (monto)");
           
            // dd($suma_gastos_e_ingresos_moneda_local[0]->saldo);
            // dd($suma_gastos_e_ingresos_moneda_extranjera);
            if (empty($suma_gastos_e_ingresos_moneda_extranjera) or  $suma_gastos_e_ingresos_moneda_local ==null) {
                // dd("No hay en esas fechas");
                $suma_gastos_e_ingresos_moneda_local = [];
                return \Response::json($suma_gastos_e_ingresos_moneda_local);
            }
            
            $suma_gastos_e_ingresos_moneda_local[0]->saldo = (float)$suma_gastos_e_ingresos_moneda_local[0]->saldo;
            $suma_gastos_e_ingresos_moneda_local[1]->saldo = (float)$suma_gastos_e_ingresos_moneda_local[1]->saldo;
            foreach ($suma_gastos_e_ingresos_moneda_extranjera as $key) {
                $buscar_tasa_de_conversion = \DB::select("select monto_equivalente from tasa where moneda_local =" . $key->id . " and moneda_equivalente =" . $moneda_local);
                $buscar_tasa_de_conversion = (double)$buscar_tasa_de_conversion[0]->monto_equivalente;
                $key->monto = $buscar_tasa_de_conversion * (double)$key->monto;
                if($key->tipo == 1){
                    $suma_gastos_e_ingresos_moneda_local[0]->saldo = $suma_gastos_e_ingresos_moneda_local[0]->saldo +$key->monto;
                }else if($key->tipo == 2){
                    $suma_gastos_e_ingresos_moneda_local[1]->saldo = $suma_gastos_e_ingresos_moneda_local[1]->saldo +$key->monto;
        
                }
                
            }
            // dd($suma_gastos_e_ingresos_moneda_local);  
            return \Response::json($suma_gastos_e_ingresos_moneda_local);
        }
        if ($tipo == 'mes') {
            $mes = getdate();
            // $mes = $mes['mon']; 
            $mes =11;
            // $mes = $mes-1;
            $cuentas = \DB::select("select sum(t.monto) as gastos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 1
            and (SELECT EXTRACT(MONTH FROM t.created_at)) =".$mes."
            union
            select sum(t.monto) as ingresos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 2
            and (SELECT EXTRACT(MONTH FROM t.created_at)) = ".$mes);
            return \Response::json($cuentas);
        }
        if ($tipo == 'anio') {
            $year = getdate();
            $year = $year['year'];  
            $cuentas = \DB::select("select sum(t.monto) as gastos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 1
            and (SELECT EXTRACT(YEAR FROM t.created_at)) =".$year."
            union
            select sum(t.monto) as ingresos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 2
            and (SELECT EXTRACT(YEAR FROM t.created_at)) = ".$year);
            return \Response::json($cuentas);
        }
        if ($tipo == 'mesCalendario') {
            $mes = $request->mes;
            $cuentas = \DB::select("select sum(t.monto) as gastos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 1
            and (SELECT EXTRACT(MONTH FROM t.created_at)) =".$mes."
            union
            select sum(t.monto) as ingresos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 2
            and (SELECT EXTRACT(MONTH FROM t.created_at)) = ".$mes);
            return \Response::json($cuentas);
        }
        if ($tipo == 'anioCalendario') {
            $anio = $request->anio; 
            $cuentas = \DB::select("select sum(t.monto) as gastos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 1
            and (SELECT EXTRACT(YEAR FROM t.created_at)) =".$anio."
            union
            select sum(t.monto) as ingresos
            from transaccion as t
            join categoria as c
            on t.categoria = c.id
            join cuenta cu          
            on t.cuenta = cu.id
            and cu.usuario_id =".$usuario."
            and c.tipo = 2
            and (SELECT EXTRACT(YEAR FROM t.created_at)) = ".$anio);
            return \Response::json($cuentas);
        }
    }


    public function converir_moneda_local($usuario,$suma_gastos_e_ingresos_moneda_local,$suma_gastos_e_ingresos_moneda_extranjera)
    {
        $moneda_local = \DB::select("select id from moneda where usuario_id =" . $usuario . " and nacional ='1'");
        $moneda_local = $moneda_local[0]->id;
        // $monedas_en_las_cuentas = \DB::select("select * from cuenta where usuario_id =" . $usuario . " order by saldo_inicial");

        foreach ($suma_gastos_e_ingresos_moneda_local as $key) {

            if ($key->moneda != $moneda_local) {
                $buscar_tasa_de_conversion = \DB::select("select monto_equivalente from tasa where moneda_local =" . $key->moneda . " and moneda_equivalente =" . $moneda_local);
                $buscar_tasa_de_conversion = $buscar_tasa_de_conversion[0]->monto_equivalente;
                $key->saldo_inicial =  (float)$key->saldo_inicial * (float)$buscar_tasa_de_conversion;
            }
        }
        return $suma_gastos_e_ingresos_moneda_local;
    }
}
