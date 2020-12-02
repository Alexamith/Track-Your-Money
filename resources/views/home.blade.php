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
                <div class="card-body">Carta Informacion</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Carta de advertencia</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Carta de éxito</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Carta de riesto</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Detalles</a>
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
                <div class="card-body">
                    <div class="col-sm-12">
                        <h4 class="text-center" id="nadaFecha">No hay datos para mostrar</h4>
                    </div>
                    <canvas id="PieChart" width="100%" height="40"></canvas>
                </div>

            </div>
        </div>

        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Gastos e ingresos en el último mes
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
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Gastos e ingresos mes calendario
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" id="mesCalendarioInput">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <!-- <input type="text" class="form-control" placeholder="2020"> -->
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary" id="mesCalendarioBtn">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-center" id="nadaMesCalendario">No hay datos para mostrar</h4>
                        </div>
                    </div>
                    <canvas id="PieChartUltimoMesCalendario" width="100%" height="40"></canvas>

                </div>

            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Gastos e ingresos año calendario
                        </div>
                        <div class="col-sm-4">

                            <input type="text" class="form-control" id="anioCalendarioInput" placeholder="2020">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary" id="anioCalendarioBtn">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="text-center" id="nadaAnioCalendario">No hay datos para mostrar</h4>
                        </div>
                    </div>
                    <canvas id="PieChartUltimoAnioCalendario" width="100%" height="40"></canvas>

                </div>

            </div>
        </div>
    </div>
    @endsection