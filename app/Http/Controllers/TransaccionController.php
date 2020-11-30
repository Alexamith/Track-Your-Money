<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\traslado;
use Illuminate\Http\Request;

class TransaccionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = \Auth::user()->id;
        $transacciones = $this->obtener_transacciones($usuario);
        $tipos = $this->obtener_tipos_de_transaccion();
        $categorias = $this->obtener_categorias($usuario);
        $cuentas = $this->obtener_cuentas($usuario);

        if (count($transacciones) != 0) {
            foreach ($transacciones as $value) {
                if ($value->tipo == 'Gastos') {
                    $value->monto =  $value->monto - ($value->monto * 2);
                }
                $value->monto = number_format($value->monto, 2);
            }
            return view('cruds.transacciones', ['transacciones' => $transacciones, 'tipos' => $tipos, 'categorias' => $categorias, 'cuentas' => $cuentas]);
        } else {
            return view('cruds.transacciones', ['tipos' => $tipos, 'categorias' => $categorias, 'cuentas' => $cuentas]);
        }
    }

    public function obtener_categorias($usuario)
    {
        $categorias = \DB::select("select c.id,c.categoria_padre, tp.tipo, c.descripcion,c.presupuesto
        from categoria as c
        join tipo_categoria as tp
        on c.tipo = tp.id
        and usuario_id =" . $usuario);
        return $categorias;
    }
    public function obtener_cuentas($usuario)
    {
        $cuentas = \DB::select("select * from cuenta where usuario_id =" . $usuario);
        return $cuentas;
    }
    public function obtener_tipos_de_transaccion()
    {
        $tipos = \DB::select("select * from tipo_transaccion");
        return $tipos;
    }

    public function obtener_transacciones($usuario)
    {
        $sql = "select t.id,tc.tipo as tipo, c.nombre_corto as nombre, concat(m.nombre_corto,' ',m.simbolo) as Moneda,
        m.tasa, t.monto, t.detalle, t.created_at
        from transaccion as t
        join cuenta as c
        on t.cuenta = c.id
        join categoria as ca
        on t.categoria = ca.id
        join tipo_categoria as tc
        on ca.tipo = tc.id
        join moneda as m
        on c.moneda = m.id
        and c.usuario_id =" . $usuario;
        $transacciones = \DB::select($sql);
        return $transacciones;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tralado =  $request->traslado;
        $dataTransaccion = [
            "categoria" => $request->categoria,
            "cuenta" => $request->cuenta,
            "monto" => $request->monto,
            "detalle" => $request->detalle,

        ];
        $tipocategoria = \DB::select("select tp.id from categoria as c
        join tipo_categoria as tp
        on c.tipo = tp.id
        and c.id =" . $request->categoria);

        if ($tralado == true) {
            if ($tipocategoria[0]->id == 3) {
                if ($request->cuenta == $request->cuentaCredito) {
                    session()->flash('iguales', 'No puede hacer un traslado en la misma cuenta');
                    return redirect()->route('transaccion');
                } else {
                    Transaccion::create($dataTransaccion);
                    $max = \DB::select("SELECT MAX(id) as id FROM transaccion;");

                    $dataTraslado = [
                        "cuenta_debito" =>  $request->cuenta,
                        "monto_debitado" => $request->monto,
                        "cuenta_credito" => $request->cuentaCredito,
                        "monto_acreditado" => $request->monto,
                        "transaccion" => $max[0]->id
                    ];
                    $this->traslados($request->cuenta, $request->cuentaCredito, $request->monto);
                    traslado::create($dataTraslado);
                }
            } else {
                session()->flash('sintipotraslado', 'Para realizar traslados tienes que tener una categoria de traslados');
                return redirect()->route('transaccion');
            }
        } else {
            Transaccion::create($dataTransaccion);
            $this->actualizar_saldo_cuenta($tipocategoria[0]->id, $request->cuenta, $request->monto, 0);
        }

        return redirect()->route('transaccion');
    }
    public function traslados($cuentaD, $cuentaC, $monto)
    {
        $cuentaDebito = Cuenta::findOrFail($cuentaD);
        $cuentaCredito = Cuenta::findOrFail($cuentaC);
        $moneda_id = \DB::select("select moneda from cuenta where id =" . $cuentaD);
        $moneda_id = $moneda_id[0]->moneda;
        $moneda2_id = \DB::select("select moneda from cuenta where id =" . $cuentaC);
        $moneda2_id = $moneda2_id[0]->moneda;
        if ($moneda_id != $moneda2_id) {
            $tasa_cambio =  \DB::select("select monto_equivalente from tasa where moneda_local =" . $moneda_id . " and moneda_equivalente =" . $moneda2_id);
            $tasa_cambio =  $tasa_cambio[0]->monto_equivalente;
            $cuentaDebito->saldo_inicial =  $cuentaDebito->saldo_inicial - $monto;
            $monto = $monto * (float)$tasa_cambio;
            $cuentaCredito->saldo_inicial =  $cuentaCredito->saldo_inicial + $monto;
        } else {
            $cuentaDebito->saldo_inicial =  $cuentaDebito->saldo_inicial - $monto;
            $cuentaCredito->saldo_inicial =  $cuentaCredito->saldo_inicial + $monto;
        }
        $cuentaDebito->save();
        $cuentaCredito->save();
    }
    public function actualizar_saldo_cuenta($tipo, $cuenta, $monto, $id_transaccion)
    {
        $cuenta = Cuenta::findOrFail($cuenta);

        if ($tipo == 1) {
            $cuenta->saldo_inicial =  $cuenta->saldo_inicial - $monto;
        } else if ($tipo == 2) {
            $cuenta->saldo_inicial =  $cuenta->saldo_inicial + $monto;
        } else if ($tipo == 3) {
            $monto_antiguo = \DB::select("select monto_debitado, cuenta_debito, cuenta_credito from traslado where transaccion =" . $id_transaccion);

            if ($monto_antiguo[0]->monto_debitado != $monto) {
                $cuentadebito = Cuenta::findOrFail($monto_antiguo[0]->cuenta_debito);
                $cuentacredito = Cuenta::findOrFail($monto_antiguo[0]->cuenta_credito);
                $moneda_id = $cuentadebito->moneda;
                $moneda2_id = $cuentacredito->moneda;
                if ($moneda_id != $moneda2_id) {
                    $tasa_cambio =  \DB::select("select monto_equivalente from tasa where moneda_local =" . $moneda_id . " and moneda_equivalente =" . $moneda2_id);
                    
                    $tasa_cambio =  $tasa_cambio[0]->monto_equivalente;
                    $cuentadebito->saldo_inicial = $cuentadebito->saldo_inicial + $monto_antiguo[0]->monto_debitado;
                    $cuentadebito->saldo_inicial = $cuentadebito->saldo_inicial - $monto;

                    $monto = $monto * (float)$tasa_cambio;
                    $cuentacredito->saldo_inicial = $cuentacredito->saldo_inicial - $monto;
                } else {
                    $cuentadebito->saldo_inicial = $cuentadebito->saldo_inicial + $monto_antiguo[0]->monto_debitado;

                    $cuentacredito->saldo_inicial = $cuentacredito->saldo_inicial - $monto_antiguo[0]->monto_debitado;
                }
                $cuentadebito->save();
                $cuentacredito->save();
            }
        }
        $cuenta->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function show(Transaccion $transaccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaccion = \DB::select("select c.categoria_padre,t.id as idt,c.id,t.monto,t.cuenta,tc.id as tiponombre,c.descripcion, c.presupuesto, c.created_at, c.updated_at,c.usuario_id from 
        transaccion as t
        join categoria as c
        on t.categoria = c.id
        join tipo_categoria as tc
        on c.tipo = tc.id
        and t.id =" . $id);
        // $transaccion = Transaccion::find($id);
        return redirect()->route("transaccion")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("transaccion", $transaccion[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $tralado =  $request->traslado;
        $tipocategoria = \DB::select("select tp.id from categoria as c
        join tipo_categoria as tp
        on c.tipo = tp.id
        and c.id =" . $request->categoria);
        $transaccion = Transaccion::findOrFail($request->id);
        if ($tralado == true) {
            if ($tipocategoria[0]->id == 3) {
                if ($request->cuenta == $request->cuentaCredito) {
                    session()->flash('iguales', 'No puede hacer un traslado en la misma cuenta');
                    return redirect()->route('transaccion');
                }
                $this->actualizar_saldo_cuenta($tipocategoria[0]->id, $request->cuenta, $request->monto, $request->id);

                $transaccion->monto = $request->monto;
                $transaccion->detalle = $request->detalle;
                $transaccion->save();
                return redirect()->route('transaccion');
            } else {
                session()->flash('sintipotraslado', 'Para realizar traslados tienes que tener una categoria de traslados');
                return redirect()->route('transaccion');
            }
        } else {
            $cuenta = Cuenta::findOrFail($transaccion->cuenta);
            if ($request->monto != $transaccion->monto) {
                $cuenta->saldo_inicial = $cuenta->saldo_inicial - $transaccion->monto;

                $cuenta->saldo_inicial = $cuenta->saldo_inicial + $request->monto;
                $cuenta->save();
                $transaccion->monto =  $request->monto;;
            } else {
                $transaccion->monto = $transaccion->monto;
            }
            $transaccion->detalle = $request->detalle;
            $transaccion->save();
            return redirect()->route('transaccion');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaccion = Transaccion::find($id);
        $transaccion->delete();
        return redirect()->route('transaccion');
    }
}
