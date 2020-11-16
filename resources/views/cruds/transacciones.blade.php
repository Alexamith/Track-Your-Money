@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Administración de transacciones <i class="fas fa-cash-register"></i></h1>
    <div class="card mb-4">
        <div class="card-body" style="background-color:  #2874a6 ; color: white;">
        <strong>{{ Auth::user()->name }}</strong> los siguientes gráficos son la representación gráfica de los datos registrados en su cuenta.
        </div>
    </div>
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

                        <tr>
                            <td>Colón</td>
                            <td>₡</td>
                            <td>Es la moneda principal CR</td>
                            <td>0</td>
                            <td>2009/09/15</td>
                            <td>
                                <a href="" class="btn btn-outline-*"style="border-color: #2874a6 ;">
                                    <i class="fas fa-edit" style="color: #2874a6 ;"></i>
                                </a> 
                                <a href="{{ route('deleteCoin') }}" type="summit" class="btn btn-outline-*"style="border-color: #2874a6 ;"> 
                                    <i class="fas fa-trash-alt" style="color: #2874a6 ;"></i>
                                </a></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection