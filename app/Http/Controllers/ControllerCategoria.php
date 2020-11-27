<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class ControllerCategoria extends Controller
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
        $sql = "select c.id,c.categoria_padre, tc.tipo, c.descripcion, c.presupuesto, c.created_at
        from categoria as c
        join tipo_categoria as tc
        on c.tipo = tc.id
        and usuario_id =".$usuario;
        $categorias = \DB::select($sql);
        $tipos = \DB::select("select * from tipo_categoria");

        if (count($categorias) != 0) {
            foreach ($categorias as $value) {
                $value->presupuesto = number_format($value->presupuesto,2);
            }
            return view('cruds.categoria', ['categorias' => $categorias,'tipos' => $tipos]);
        } else {
            return view('cruds.categoria',['tipos' => $tipos]);
        }
    }
    public function subcategoria()
    {
        $usuario = \Auth::user()->id;
        $sql = "select sc.id as subcategoriaid,c.id as categoria,c.categoria_padre as pertenece,tp.tipo,sc.nombre,sc.detalle, sc.presupuesto, sc.created_at
        from subcategoria as sc
        join categoria as c
        on sc.categoria_id = c.id
        join tipo_categoria as tp
        on c.tipo = tp.id
        and c.usuario_id =".$usuario;
        $subcategorias = \DB::select($sql);
        $categorias = \DB::select("select * from categoria where usuario_id=".$usuario);

        if (count($categorias) != 0) {
            if (count($subcategorias) != 0) {
                foreach ($subcategorias as $value) {
                    $value->presupuesto = number_format($value->presupuesto,2);
                }
                return view('cruds.subcategoria', ['subcategorias' => $subcategorias,'cate' => $categorias]);
            }else{
                return view('cruds.subcategoria',['sinsubcategorias' => 'al parecer no tienes subcategorías registradas ','cate' => $categorias]);
            }   
            
        } else {
            return view('cruds.subcategoria',['sincategorias' => 'lo sentimos, al no tener categorias no puedes tener subcategorías']);
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
        $dataCategoria = [
            "categoria_padre" => $request->name,
            "tipo" => $request->tipo,
            "descripcion" => $request->descripcion,
            "presupuesto" => $request->presupuesto,
            "usuario_id" => \Auth::user()->id
        ];
        Categoria::create($dataCategoria);
        return redirect()->route('categoria');
    }
    public function storeSub(Request $request)
    {
        $dataSubCategoria = [
            "categoria_id" => $request->categoria,
            "detalle" => $request->descripcion,
            "nombre" => $request->name,
            "presupuesto" => $request->presupuesto
        ];
        Subcategoria::create($dataSubCategoria);
        return redirect()->route('subcategoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id);
        return redirect()->route("categoria")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("categoria", $categoria);
    }
    public function editSub($id)
    {
        $subcategoria = \DB::select("select * from subcategoria where id =".$id);
   
        return redirect()->route("subcategoria")
            ->with("mensaje", 'dasdadasdasdas')
            ->with("subcategoriaEdit", $subcategoria[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $Categoria = Categoria::findOrFail($request->id);
        $Categoria->categoria_padre = $request->name;
        $Categoria->tipo = $request->tipo;
        $Categoria->descripcion = $request->descripcion;
        $Categoria->presupuesto = $request->presupuesto;
        $Categoria->save();
        return redirect()->route('categoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();
        return redirect()->route('categoria');
    }
    public function destroySub($id)
    {
        $subcategoria = Subcategoria::find($id);
        $subcategoria->delete();
        return redirect()->route('subcategoria');
    }
}
