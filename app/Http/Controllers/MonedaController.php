<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class MonedaController extends Controller
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
        $monedas = Moneda::where('usuario_id', $usuario)->get();
        if (count($monedas) != 0) {
            return view('cruds.monedas', ['monedas' => $monedas]);
        } else {
            return view('cruds.monedas');
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
        $dataMoneda = [
            "nombre_corto" => $request->name,
            "simbolo" => $request->simbolo,
            "descripcion" => $request->descripcion,
            "tasa" => $request->tasa_cambio,
            "usuario_id" => \Auth::user()->id,
            "nacional" => $request->nacional
        ];
        Moneda::create($dataMoneda);
        return redirect()->route('moneda');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function show(Moneda $moneda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $moneda = Moneda::find($id);
        return redirect()->route("moneda")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("tipo", $moneda);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($this->buscar_moneda_local() == 1 and $request->nacional == true) {
            return redirect()->route("moneda")
            ->with("mensaje", 'faafafqwwq')
            ->with("local",'Ya cuenta con una moneda local');
            
        }else {
            $Moneda = Moneda::findOrFail($request->id);
            $Moneda->nombre_corto = $request->name;
            $Moneda->simbolo =  $request->simbolo;
            $Moneda->descripcion = $request->descripcion;
            $Moneda->tasa = $request->tasa_cambio;
            $Moneda->nacional = $request->nacional;
            $Moneda->save();
            return redirect('/monedas');
            
            
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $moneda = Moneda::find($id);
        $moneda->delete();
        return redirect('/monedas');
    }
    public function buscar_moneda_local()
    {
        $usuario = \Auth::user()->id;
        $monedas = \DB::select("select * from moneda where usuario_id =".$usuario);
        if (!empty($monedas)) {
            foreach ($monedas as $key) {
                if ($key->nacional == 1) {
                    return true;
                }
            }
        }
        return false;
    }
}
