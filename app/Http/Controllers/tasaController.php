<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use App\Models\Tasa;
use Illuminate\Http\Request;

class tasaController extends Controller
{
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
        $monedas = Moneda::where('usuario_id', $usuario)->get();
        $tasa = \DB::select("select t.id,concat( m.nombre_corto,' ',m.simbolo) as local,t.monto_local,concat(mo.nombre_corto,' ',mo.simbolo)as extranjera,t.monto_equivalente, t.created_at from
        tasa as t
        join moneda as m
        on t.moneda_local = m.id
        join moneda as mo
        on t.moneda_equivalente = mo.id
        and m.usuario_id =" . $usuario);
        if (count($tasa) != 0) {
            return view('cruds.tasas', ['tasas' => $tasa, 'monedas' => $monedas]);
        } else {
            return view('cruds.tasas', ['monedas' => $monedas]);
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

        if ($request->moneda_local == $request->moneda_equivalente) {
            session()->flash('igual', 'Por favor seleccione monedas diferentes');
            session()->flash('iguales', 'No puede hacer un traslado en la misma cuenta');
            return redirect()->route('tasa');
        } else {
            $dataTasa = [
                "moneda_local" => $request->moneda_local,
                "monto_local" => $request->monto_local,
                "moneda_equivalente" => $request->moneda_equivalente,
                "monto_equivalente" => $request->monto_equivalente
            ];
            Tasa::create($dataTasa);
            return redirect()->route('tasa');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tasa = Tasa::find($id);
        return redirect()->route("tasa")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("editarTasaModal", $tasa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tasa = Tasa::findOrFail($request->id);
        $tasa->moneda_local = $request->moneda_local;
        $tasa->monto_local =  $request->monto_local;
        $tasa->moneda_equivalente = $request->moneda_equivalente;
        $tasa->monto_equivalente = $request->monto_equivalente;
        $tasa->save();
        return redirect()->route('tasa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasa = Tasa::find($id);
        $tasa->delete();
        return redirect()->route('tasa');
    }
}
