<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Cuentas_compartidas;
use Illuminate\Http\Request;

class CuentaController extends Controller
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
        $sql ="select c.id,m.id as id_moneda,CONCAT(m.nombre_corto,' ',m.simbolo) as nombre,m.tasa,c.nombre_corto,c.descripcion,c.saldo_inicial, c.created_at
        from cuenta as c
        join moneda as m
        on c.moneda = m.id
        and m.usuario_id =".$usuario;
        $cuentas = \DB::select($sql);
        $monedas = \DB::select("select id,concat(nombre_corto,' ',simbolo) as nombre_corto from moneda where usuario_id =".$usuario);
        
        if (count($cuentas) != 0) {
            foreach ($cuentas as $key) {
                $key->saldo_inicial = number_format($key->saldo_inicial,2);
            }
            return view('cruds.cuentas', ['cuentas' => $cuentas,'monedas'=>$monedas]);
        } else {
            return view('cruds.cuentas',['monedas'=>$monedas]);
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
        $dataCuenta = [
            "moneda" => $request->moneda,
            "nombre_corto" => $request->name,
            "descripcion" => $request->descripcion,
            "saldo_inicial" => $request->saldo,
            "usuario_id" => \Auth::user()->id
        ];
        Cuenta::create($dataCuenta);
        return redirect()->route('cuenta');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Cuenta $cuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuenta = Cuenta::find($id);
        return redirect()->route("cuenta")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("cuenta", $cuenta);
    }
    public function compartir($id)
    {
        $cuenta = Cuenta::find($id);
        return redirect()->route("cuenta")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("compartir", $cuenta);
    }
    public function compartirCuenta(Request $request ){
        $registrada = \DB::select("select * from cuentas_compartidas where cuenta_id =".$request->cuenta_id." and usuario_a_compartir_id =".$request->usuario_id);
        if (empty($registrada)) {
            $dataCuentaCompartir = [
                "cuenta_id" => $request->cuenta_id,
                "usuario_a_compartir_id" => $request->usuario_id
            ];
           Cuentas_compartidas::create($dataCuentaCompartir);
            return \Response::json('La cuenta se compartió con éxito');
        }else{
            return \Response::json('Esta cuenta ya está compartida con este usuario');
        }
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $Cuenta = Cuenta::findOrFail($request->id);
        $Cuenta->moneda= $request->moneda;
        $Cuenta->nombre_corto= $request->name;
        $Cuenta->descripcion= $request->descripcion;
        $Cuenta->saldo_inicial= $request->saldo;
        $Cuenta->save();
        return redirect()->route('cuenta');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->delete();
        return redirect()->route('cuenta');
    }
}
