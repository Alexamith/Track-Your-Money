@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Administración de transacciones <i class="fas fa-cash-register"></i></h1>
    <div class="card mb-4">
        <div class="card-body" style="background-color:  #2874a6 ; color: white;">
            <strong>{{ Auth::user()->name }}</strong>
            @if(isset($cuentas) and empty($cuentas))
            <i class="fas fa-sad-cry"></i> al no tener cuentas registradas, no puedes hacer transacciones
            @elseif(Session::has('iguales'))
           {{Session::get('iguales')}}
            @else
                @if(isset($transacciones))
                    la siguiente tabla almacena las transacciones que has registrado con su respectiva fecha de creación.
                @else
                <i class="fas fa-sad-cry"></i> parece que no tienes transacciones registradas
                <a href="#" class="btn btn-outline-*" style="border-color: white;" data-toggle="modal" data-target="#modal_crear_transaccion"><i class="fas fa-plus-square" style="color: white;"></i></a>
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
                            <th>Monto transacción</th>
                            <th>Detalle</th>
                            <th>Fecha</th>
                            <th><a href="#" class="btn btn-outline-*" style="border-color: #2874a6;" data-toggle="modal" data-target="#modal_crear_transaccion"><i class="fas fa-plus-square" style="color: #2874a6 ;"></i></a></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tipo</th>
                            <th>Cuenta</th>
                            <th>Moneda</th>
                            <th>Tasa de cambio</th>
                            <th>Monto transacción</th>
                            <th>Detalle</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($transacciones ?? '' as $transaccion)
                        <tr>

                            <td>{{$transaccion->tipo}}</td>
                            <td>{{$transaccion->nombre}}</td>
                            <td>{{$transaccion->moneda }}</td>
                            <td>{{$transaccion->tasa}}</td>
                            @if($transaccion->tipo == 'Ingresos')
                            <td>+ {{$transaccion->monto}}</td>
                            @elseif($transaccion->tipo == 'Traslados')
                            <td>-+{{$transaccion->monto}}</td>
                            @else
                            <td>{{$transaccion->monto}}</td>
                            @endif
                            
                            <td>{{$transaccion->detalle}}</td>
                            <td>{{$transaccion->created_at}}</td>
                            <td>
                                <a href="{{ url('editarTransacciones/'.$transaccion->id) }}" id="" class="btn btn-outline-*" style="border-color: #2874a6 ;">
                                    <i class="fas fa-edit" style="color: #2874a6 ;"></i>
                                </a>
                                <a href="{{ url('borrarTransaccion/'.$transaccion->id) }}" class="btn btn-outline-*" style="border-color: #ff0000 ;">
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