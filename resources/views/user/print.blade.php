@extends('layouts.user')
@section('title', 'Print Your ID')
@section('content')
@foreach (['danger', 'warning', 'success', 'info'] as $message)
    <div class="flash-message">
        @if (Session::has('alert-' . $message))
            <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    </div>
@endforeach
<div class="row justify-content-start">
    <div class="col-12">
        <h3 class="mb-4">
            <strong>
                {{ __('PRINT ID') }}
            </strong>
        </h3>
        <div class="row no-gutters container">
            <div class="col-md-10 col-lg-8" id="idLayout">
                <img src="{{ asset('/images/ID/card_' . Auth::user()->id . '.jpg') }}" class="w-100">
                <span class="d-block pb-2"></span>
                <img src="{{ asset('/images/assets/id_card_back.png') }}" class="w-100">
            </div>
        </div>
        <div class="my-5">
            <button type="button" id="printButton" class="btn btn-primary ml-auto mr-1">
                {{ __('Print') }}
            </button>
            <a href="{{ route('home') }}" class="btn btn-secondary mr-auto ml-1">
                {{ __('Proceed') }}
            </a>    
        </div>
    </div>
</div>

<x-kumustapopup />

@endsection