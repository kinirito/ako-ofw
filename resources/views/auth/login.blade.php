@extends('layouts.auth')
@section('title', 'Login')
@section('content')
<div class="container h-100 login">
    <div class="row m-0 h-100 w-100 justify-content-center">
        @foreach (['danger', 'warning', 'success', 'info'] as $message)
            <div class="flash-message">
                @if (Session::has('alert-' . $message))
                    <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            </div>
        @endforeach
        
        <div class="row align-self-center">
            <div class="col-md-7 text-center text-md-right">
                <img src="{{ asset('/images/assets/akoofw.png') }}" class="logo mb-5 mb-md-0">
            </div>
            <div class="col-md-5 text-center text-md-left">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row mb-2">
                        <div class="col-12">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="{{ __('USERNAME') }}" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-12">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('PASSWORD') }}" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-4 mb-md-2">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="custom-control-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-1">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Log in') }}
                            </button>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-12">
                            @if (Route::has('register'))
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Create new account') }}
                                </a>
                            @endif
                        </div>
                        <div class="col-12">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
