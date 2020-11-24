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
                if ($value->tipo_transaccion == 1) {
                    $value->monto =  $value->monto - ($value->monto * 2);
                }
                $value->monto = number_format($value->monto, 2);            
            }
            return view('cruds.transacciones', ['transacciones' => $transacciones, 'tipos' => $tipos, 'categorias'=>$categorias, 'cuentas'=>$cuentas]);
        } else {
            return view('cruds.transacciones', ['tipos' => $tipos, 'categorias'=>$categorias, 'cuentas'=>$cuentas]);
        }
    }
    
    public function obtener_categorias($usuario)
    {
        $categorias = \DB::select("select c.id,c.categoria_padre, tp.tipo, c.descripcion,c.presupuesto
        from categoria as c
        join tipo_categoria as tp
        on c.tipo = tp.id
        and usuario_id =".$usuario);
        return $categorias;
    }
    public function obtener_cuentas($usuario)
    {
        $cuentas = \DB::select("select * from cuenta where usuario_id =".$usuario);
        return $cuentas;
    }
    public function obtener_tipos_de_transaccion()
    {
        $tipos = \DB::select("select * from tipo_transaccion");
        return $tipos;
    }

    public function obtener_transacciones($usuario)
    {
        $sql = "select t.id,t.tipo as tipo_transaccion, tp.tipo, c.nombre_corto as nombre, concat(m.nombre_corto,' ',m.simbolo) as Moneda, m.tasa, t.monto, t.detalle, t.created_at
        from transaccion as t
        join tipo_transaccion as tp
        on t.tipo = tp.id
        join cuenta as c
        on t.cuenta = c.id
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
        $dataTransaccion = [
            "tipo" => $request->tipo,
            "cuenta" => $request->cuenta,
            "monto" => $request->monto,
            "detalle" => $request->detalle,
            "categoria" => $request->categoria
        ];
        if ($request->tipo == 3) {
            if ($request->cuenta == $request->cuentaCredito) {
                session()->flash('iguales', 'No puede hacer un traslado en la misma cuenta');
            }else{
   
                $dataTraslado = [
                    "cuenta_debito" =>  $request->cuenta,
                    "monto_debitado" => $request->monto,
                    "cuenta_credito" => $request->cuentaCredito,
                    "monto_acreditado" => $request->monto
                ];
                $this->traslados($request->cuenta,$request->cuentaCredito,$request->monto);
                traslado::create($dataTraslado);
            }
        }else{
            
            $this->actualizar_saldo_cuenta($request->tipo,$request->cuenta,$request->monto);
        }
        Transaccion::create($dataTransaccion);
        return redirect()->route('transaccion');
    }
    public function traslados($cuentaD,$cuentaC, $monto)
    {
        $cuentaDebito = Cuenta::findOrFail($cuentaD);
        $cuentaCredito = Cuenta::findOrFail($cuentaC);
        $cuentaDebito->saldo_inicial =  $cuentaDebito->saldo_inicial - $monto;
        $cuentaCredito->saldo_inicial =  $cuentaCredito->saldo_inicial + $monto;
        $cuentaDebito->save();
        $cuentaCredito->save();
    }
    public function actualizar_saldo_cuenta($tipo, $cuenta, $monto)
    {
        $cuenta = Cuenta::findOrFail($cuenta);

        if ($tipo == 1) {
            $cuenta->saldo_inicial =  $cuenta->saldo_inicial - $monto;
        }
        else if($tipo == 2){
            $cuenta->saldo_inicial =  $cuenta->saldo_inicial + $monto;
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
        $transaccion = Transaccion::find($id);
        return redirect()->route("transaccion")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("transaccion", $transaccion);
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
        $transaccion = Transaccion::findOrFail($request->id);
        $transaccion->tipo = $request->tipo;
        $transaccion->cuenta =  $request->cuenta;
        $transaccion->monto = $request->monto;
        $transaccion->detalle = $request->detalle;
        $transaccion->categoria = $request->categoria;
        $transaccion->save();
        return redirect()->route('transaccion');

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
