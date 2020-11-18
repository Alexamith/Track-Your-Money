@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Administración de monedas <i class="fas fa-coins"></i></h1>

    <div class="card mb-4">
        <div class="card-body" style="background-color:  #2874a6 ; color: white;">
        <strong>{{ Auth::user()->name }}</strong>
        @if(!isset($monedas))
        <i class="fas fa-sad-cry"></i> al parecer no tienes ninguna moneda registrada.
        <a href="#" class="btn btn-outline-*" style="border-color: white;" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-square" style="color: white;"></i></a>
        @else
         la siguiente tabla almacena las monedas que has registrado a nombre de tu cuenta.
        @endif
        </div>
    </div>
    
    @isset($monedas)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            <strong>Mis Monedas</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Simbolo</th>
                            <th>Descripción</th>
                            <th>Tasa</th>
                            <th>Fecha de creación</th>
                            <th><a href="#" class="btn btn-outline-*" style="border-color: #2874a6;" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-square" style="color: #2874a6 ;"></i></a></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Simbolo</th>
                            <th>Descripción</th>
                            <th>Tasa</th>
                            <th>Fecha de creación</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($monedas ?? '' as $moneda)
                        <tr>

                            <td>{{$moneda->nombre_corto}}</td>
                            <td>{{$moneda->simbolo}}</td>
                            <td>{{$moneda->descripcion}}</td>
                            <td>{{$moneda->tasa}}</td>
                            <td>{{$moneda->created_at}}</td>
                            <td>
                                <a href="" class="btn btn-outline-*" style="border-color: #2874a6 ;">
                                    <i class="fas fa-edit" style="color: #2874a6 ;"></i>
                                </a>
                                <a href="{{ url('deleteCoins/'.$moneda->id) }}" type="summit" class="btn btn-outline-*" style="border-color: #2874a6 ;">
                                    <i class="fas fa-trash-alt" style="color: #2874a6 ;"></i>
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