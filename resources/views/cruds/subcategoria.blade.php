@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Administración de subcategorias <i class="fas fa-chart-line"></i></h1>
    <div class="card mb-4">
        <div class="card-body" style="background-color:  #2874a6 ; color: white;">
            <strong>{{ Auth::user()->name }}</strong>
            @if(isset($sincategorias))
            <i class="fas fa-sad-cry"></i> {{ $sincategorias }}
            @elseif(isset($sinsubcategorias))
            {{$sinsubcategorias}}
            <a href="#" class="btn btn-outline-*" style="border-color: white;" data-toggle="modal" data-target="#modal_crear_sub"><i class="fas fa-plus-square" style="color: white ;"></i></a>
            @else
            la siguiente tabla almacena las subcategorías que has registrado con fecha específica de creación
            @endif
        </div>
    </div>
    @isset($subcategorias)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            <strong>Mis Subcategorías</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Pertenece a</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Presupuesto</th>
                            <th>Fecha de creación</th>
                            <th><a href="#" class="btn btn-outline-*" style="border-color: #2874a6;" data-toggle="modal" data-target="#modal_crear_sub"><i class="fas fa-plus-square" style="color: #2874a6 ;"></i></a></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Pertenece a</th>
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Presupuesto</th>
                            <th>Fecha de creación</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($subcategorias ?? '' as $categoria)
                        <tr>

                            <td>{{$categoria->pertenece}}</td>
                            <td>{{$categoria->tipo}}</td>
                            <td>{{$categoria->nombre}}</td>
                            <td>{{$categoria->detalle}}</td>
                            <td>{{$categoria->presupuesto}}</td>
                            <td>{{$categoria->created_at}}</td>
                            <td>
                                <a href="{{ url('editarCategoria/'.$categoria->subcategoriaid) }}" id="btn-edit" class="btn btn-outline-*" style="border-color: #2874a6 ;">
                                    <i class="fas fa-edit" style="color: #2874a6 ;"></i>
                                </a>
                                <a href="{{ url('borrarSubCategoria/'.$categoria->subcategoriaid) }}"  class="btn btn-outline-*" style="border-color: #ff0000 ;">
                                    <i class="fas fa-trash-alt" style="color: #ff0000 ;"></i>
                                </a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endisset
</div>
@endsection