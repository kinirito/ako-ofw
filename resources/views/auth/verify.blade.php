@extends('layouts.auth')
@section('title', 'Verify Your Account')
@section('content')
<div class="container">
    <div class="row justify-content-center">

        @if (session('resent'))
            <div class="flash-message">
                <p class="alert alert-success">
                    {{ __('A fresh verification link has been sent to your email address.') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </p>
            </div>
        @endif

        <div class="col-12">
            <h2 class="text-center mb-5"><h2>
                <strong>
                    {{ __('Verify Your Email Address') }}
                </strong>
            </h2>
            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
</div>
@endsection
