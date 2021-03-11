@extends('layouts.user')
@section('title', 'Facebook Live Streaming Settings')
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
                {{ __('Facebook Live Streaming Settings') }}
            </strong>
        </h3>
        <form method="POST" action="{{ route('update.streaming') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row mb-2">
                <label for="embed_code" class="col-md-4 col-form-label">{{ __('Embed Code:') }}</label>

                <div class="col-md-6">
                    <textarea id="embed_code" class="form-control @error('embed_code') is-invalid @enderror" name="embed_code" autofocus>{{ $streaming->embed_code }}</textarea>

                    @error('embed_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-4">
                <div class="col-12">
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" name="is_broadcast" id="is_broadcast" {{ $streaming->is_broadcast ? 'checked' : '' }}>

                        <label class="custom-control-label" for="is_broadcast">
                            {{ __('Broadcast Stream Now:') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary mr-1">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection