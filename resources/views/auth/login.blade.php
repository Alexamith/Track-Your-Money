@extends('layouts.app')

@section('content')
<br><br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5" >
                <div class="card-header" style="background-color:  #2874a6; color: white;">
                    <h3 class="text-center font-weight-light my-4">Inicio de sesión Track <i class="fas fa-dollar-sign"></i></h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Correo</label>
                            <input class="form-control py-4 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" type="email" placeholder="Enter email address" required autocomplete="email" autofocus />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control py-4 @error('password') is-invalid @enderror" type="password" id="password" name="password" placeholder="Enter password" required autocomplete="current-password" />
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
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('password.request'))
                            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                            @endif
                            <button type="submit" class="btn" style="background-color: #2874a6; color:white;">Entrar</button>

                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="register.html">Necesitas una cuenta?</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection