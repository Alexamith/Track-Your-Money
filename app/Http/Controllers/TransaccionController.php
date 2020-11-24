<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
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
        $tipos = \DB::select("select * from tipo_transaccion");
        if (count($transacciones) != 0) {
            foreach ($transacciones as $value) {
                if ($value->tipo_transaccion == 1) {
                    $value->monto =  $value->monto - ($value->monto * 2);
                }
                $value->monto = number_format($value->monto, 2);            
            }
            return view('cruds.transacciones', ['transacciones' => $transacciones, 'tipos' => $tipos]);
        } else {
            return view('cruds.transacciones', ['tipos' => $tipos]);
        }
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
        //
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
    public function edit(Transaccion $transaccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaccion $transaccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaccion  $transaccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaccion $transaccion)
    {
        //
    }
}
