@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area mr-1"></i>
                    Principales ingresos
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Cuentas actuales con sus respectivos saldos
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Principales gastos
                </div>
                <div class="card-body"><canvas id="myAreaGastos" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Gástos e ingresos en el último año
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-center" id="nadaAnio">No hay datos para mostrar</h4>
                        </div>
                    </div>
                    <canvas id="PieChartUltimoAnio" width="100%" height="40"></canvas>

                </div>

            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Transacciones por fecha
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="date" value="2020-11-28" id="id_2_fechas_btn1">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="date" value="2020-12-01" id="id_2_fechas_btn2">
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary" id="dos_fechas">Buscar</button>

                        </div>

                    </div>

                </div>
                <div class="card-body"><canvas id="PieChart" width="100%" height="40"></canvas></div>

            </div>
        </div>

        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-4">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Último mes
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-center" id="nada">No hay datos para mostrar</h4>
                        </div>
                    </div>
                    <canvas id="PieChartUltimoMes" width="100%" height="40"></canvas>

                </div>

            </div>
        </div>
    </div>
    @endsection