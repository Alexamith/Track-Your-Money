@extends('layouts.app')

@section('content')
<br><br><br>
<div class="container">
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
                            <th><a href="" class="btn btn-outline-primary"><i class="fas fa-plus-square"></i></a></th>
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
                            <td>Colleen Hurst</td>
                            <td>Javascript Developer</td>
                            <td>San Francisco</td>
                            <td>39</td>
                            <td>2009/09/15</td>
                            <td><a href="" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> <a href="" class="btn btn-outline-primary"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <tr>
                            <td>Sonya Frost</td>
                            <td>Software Engineer</td>
                            <td>Edinburgh</td>
                            <td>23</td>
                            <td>2008/12/13</td>
                            <td><a href="" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> <a href="" class="btn btn-outline-primary"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <tr>
                            <td>Jena Gaines</td>
                            <td>Office Manager</td>
                            <td>London</td>
                            <td>30</td>
                            <td>2008/12/19</td>
                            <td><a href="" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a> <a href="" class="btn btn-outline-primary"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection