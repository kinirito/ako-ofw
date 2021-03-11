@extends('layouts.user')
@section('title', 'Saklolo!')
@section('content')
@foreach (['danger', 'warning', 'success', 'info'] as $message)
    <div class="flash-message">
        @if (Session::has('alert-' . $message))
            <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    </div>
@endforeach
<div class="row justify-content-center">
    <div class="col-12">
        <h3 class="mb-4">
            <strong>
                {{ __('SAKLOLO!') }}
            </strong>
        </h3>
        <form method="POST" action="{{ route('hindi.mabuti.status') }}">
            @csrf

            <div class="form-group row">
                <div class="col">
                    <select id="reason_id" class="form-control @error('reason_id') is-invalid @enderror" name="reason_id" required>
                        <option value="">-- Pumili ng Dahilan--</option>
                        @foreach ($reasons as $reason)
                            @if (old('reason_id') == $reason->id)
                                <option value="{{ $reason->id }}" selected>{{ $reason->reason }}</option>
                            @else
                                <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('reason_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <span class="pb-2 d-block">
                <strong>
                    {{ __('Isalaysay ang buong problema:') }}
                </strong>
            </span>
            <div class="form-group row">
                <div class="col">
                    <textarea id="scenario" class="form-control @error('scenario') is-invalid @enderror" name="scenario" maxlength="255" autocomplete="scenario">{{ old('scenario') }}</textarea>

                    @error('scenario')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Send') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
