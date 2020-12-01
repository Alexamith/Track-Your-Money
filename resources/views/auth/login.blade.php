@extends('layouts.app')

@section('content')
<br><br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header" style="background-color:  #2874a6; color: white;">
                    <h3 class="text-center font-weight-light my-4">Inicio de sesión Track <i class="fas fa-dollar-sign"></i></h3>
                </div>
                <div class="card-body">

                    <hr>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Correo</label>
                            <input class="form-control py-4 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" type="email" placeholder="Correo" required autocomplete="email" autofocus />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control py-4 @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Contraseña" required autocomplete="current-password" />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="remember">
                                    {{ __('Recordarme') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group">

                            <button type="submit" class="btn btn-block btn-lg" style="background-color: #2874a6; color:white;">Entrar</button>

                        </div>
                    </form>
                    <!-- <p class="at-3 ab-2 text-center lead">-o-</p> -->
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{ url('/auth/redirect/google') }}" class="btn btn-block btn-lg btn-outline-danger"><i class="fab fa-google"></i></a>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ url('/auth/redirect/github') }}" class="btn btn-block btn-lg btn-outline-dark"><i class="fab fa-github"></i></a>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ url('/auth/redirect/linkedin') }}" class="btn btn-block btn-lg btn-outline-info"><i class="fab fa-linkedin"></i></a>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ url('/auth/redirect/twitter') }}" class="btn btn-block btn-lg btn-outline-info"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection