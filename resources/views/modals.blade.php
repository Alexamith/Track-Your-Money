<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('registra_moneda') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Crear Moneda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="small mb-1" for="inputFirstName">Nombre</label>
                                <input class="form-control py-4" id="name" name="name" type="text" placeholder="Nombre" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Descripción</label>
                            <input class="form-control py-4 @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}" required autocomplete="descripcion" id="descripcion" name="descripcion" type="descripcion" aria-describedby="descripcionHelp" placeholder="Descripcion" />
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Simbolo</label>
                                    <input class="form-control py-4 @error('simbolo') is-invalid @enderror" id="simbolo" name="simbolo" type="simbolo" placeholder="Simbolo" required autocomplete="new-simbolo" />
                                    @error('simbolo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputConfirmPassword">Tasa de cambio</label>
                                    <input class="form-control py-4" id="tasa_cambio" name="tasa_cambio" type="text" required autocomplete="new-tasa_cambio" placeholder="610.15" />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn" style="background-color:  #2874a6; color: white;">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session("mensaje") && session("tipo"))
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('update') }}">
                @csrf
                <input type="hidden" id="id" name="id" value="{{session('tipo')->id}}" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Editar Moneda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="small mb-1" for="inputFirstName">Nombre</label>
                                <input class="form-control py-4" id="name" name="name" value="{{session('tipo')->nombre_corto}}" type="text" placeholder="Nombre" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Descripción</label>
                            <input class="form-control py-4 @error('descripcion') is-invalid @enderror" value="{{session('tipo')->descripcion}}" required autocomplete="descripcion" id="descripcion" name="descripcion" type="descripcion" aria-describedby="descripcionHelp" placeholder="Descripcion" />
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Simbolo</label>
                                    <input class="form-control py-4 @error('simbolo') is-invalid @enderror" id="simbolo" name="simbolo" value="{{session('tipo')->simbolo}}" type="text" placeholder="Simbolo" required autocomplete="new-simbolo" />
                                    @error('simbolo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputConfirmPassword">Tasa de cambio</label>
                                    <input class="form-control py-4" id="tasa_cambio" name="tasa_cambio" type="text" value="{{session('tipo')->tasa}}" required autocomplete="new-tasa_cambio" placeholder="610.15" />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn" style="background-color:  #2874a6; color: white;">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    
</script>
@endif