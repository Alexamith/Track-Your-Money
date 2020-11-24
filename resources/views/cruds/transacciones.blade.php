@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Administración de transacciones <i class="fas fa-cash-register"></i></h1>
    <div class="card mb-4">
        <div class="card-body" style="background-color:  #2874a6 ; color: white;">
            <strong>{{ Auth::user()->name }}</strong>
            @if(isset($monedas) and empty($monedas))
            <i class="fas fa-sad-cry"></i> al no tener monedas registradas, no puedes tener cuentas
            <a href="#" class="btn btn-outline-*" style="border-color: white;" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-plus-square" style="color: white;"></i></a>
            @else
            @if (empty($cuentas))
            al parecer no tienes ninguna cuenta registrada.
            <a href="#" class="btn btn-outline-*" style="border-color: white;" data-toggle="modal" data-target="#modal_crear_cuenta"><i class="fas fa-plus-square" style="color: white;"></i></a>
            @else
            la siguiente tabla almacena las cuentas que has registrado con su respectiva moneda.
            @endif
            @endif
        </div>
    </div>
    @isset($transacciones)
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            <strong>Mis Transacciones</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Cuenta</th>
                            <th>Moneda</th>
                            <th>Tasa de cambio</th>
                            <th>Monto</th>
                            <th>Detalle</th>
                            <th>Fecha de creación</th>
                            <th><a href="#" class="btn btn-outline-*" style="border-color: #2874a6;" data-toggle="modal" data-target="#modal_crear_cuenta"><i class="fas fa-plus-square" style="color: #2874a6 ;"></i></a></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tipo</th>
                            <th>Cuenta</th>
                            <th>Moneda</th>
                            <th>Tasa de cambio</th>
                            <th>Monto</th>
                            <th>Detalle</th>
                            <th>Fecha de creación</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($transacciones ?? '' as $transaccion)
                        <tr>

                            <td>{{$transaccion->tipo}}</td>
                            <td>{{$transaccion->nombre}}</td>
                            <td>{{$transaccion->moneda}}</td>
                            <td>{{$transaccion->tasa}}</td>
                            <td>{{$transaccion->monto}}</td>
                            <td>{{$transaccion->detalle}}</td>
                            <td>{{$transaccion->created_at}}</td>
                            <td>
                                <a href="" id="" class="btn btn-outline-*" style="border-color: #2874a6 ;">
                                    <i class="fas fa-edit" style="color: #2874a6 ;"></i>
                                </a>
                                <a href="" class="btn btn-outline-*" style="border-color: #ff0000 ;">
                                    <i class="fas fa-trash-alt" style="color: #ff0000 ;"></i>
                                </a>
                            </td>
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