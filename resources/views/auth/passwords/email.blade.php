@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        @if (session('status'))
            <div class="flash-message">
                <p class="alert alert-success">
                    {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </p>
            </div>
        @endif

        <div class="col-12">
            <h2 class="mb-5 text-center">
                <strong>
                    {{ __('Reset Password') }}
                </strong>
            </h2>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-center text-md-left">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>

                @if (Route::has('login'))
                    <a class="btn btn-link mt-3" href="{{ route('login') }}">
                        {{ __('Back to Login Page') }}
                    </a>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
