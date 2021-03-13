@extends('layouts.user')
@section('title', 'Welcome Greetings')
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
                {{ __('WELCOME GREETINGS') }}
            </strong>
        </h3>
        <form method="GET" action="{{ route('greetings') }}">    
            <div class="form-group form-search row no-gutters">
                <div class="col-md mb-2 mb-md-0 mr-md-1 row no-gutters date-range">
                    <label for="date_from" class="col-md-auto pr-5 mb-1 mb-md-0">{{ __('Date Span: ') }}</label>
                    <input id="dateFrom" type="text" class="col date-from form-control @error('date_from') is-invalid @enderror" name="date_from" value="{{ old('date_from', $request->date_from != null ? $request->date_from : '') }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="dateFrom">
                    <div class="col-auto date-separator">{{ __('to') }}</div>
                    <input id="dateTo" type="text" class="col date-to form-control @error('date_to') is-invalid @enderror" name="date_to" value="{{ old('date_to', $request->date_to != null ? $request->date_to : '') }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="dateTo">
                </div>
                <button class="btn btn-secondary col-md-auto ml-md-1" type="submit">{{ __('Search') }}</button>
            </div>
        </form>

        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addGreetingModal" data-backdrop="static" data-keyboard="false">
                {{ __('Add Greeting') }}
            </button>
        </div>
        <div class="modal fade" id="addGreetingModal" tabindex="-1" role="dialog" aria-labelledby="addGreetingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('add.greeting') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="addGreeting" class="col-md-4 col-form-label">{{ __('Greeting Image:') }}</label>

                                <div class="col-md-6 custom-upload-image">
                                    <img id="addGreetingDisplay" src="{{ asset('images/greetings/default_greeting.png') }}"/>
                                    <input id="addGreeting" type="file" accept="image/*" class="form-control @error('add_greeting') is-invalid @enderror" name="add_greeting" required autofocus>

                                    <span class="click-here">
                                        *Click the image above to upload logo*
                                    </span>

                                    @error('add_greeting')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="addDisplayDate" class="col-md-4 col-form-label">{{ __('Date of Greeting:') }}</label>

                                <div class="col-md-6">
                                    <input id="addDisplayDate" type="text" class="form-control @error('add_display_date') is-invalid @enderror" name="add_display_date" value="{{ old('add_display_date', $request->add_display_date != null ? $request->add_display_date : '') }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="addDisplayDate" autofocus>

                                    @error('add_display_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row no-gutters">
                                <div class="col-sm-auto">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-sm-1">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                                <div class="col-sm-auto">
                                    <button type="button" class="btn btn-secondary mt-1 mt-sm-0 ml-sm-1" data-dismiss="modal">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-group">
            @foreach ($greetings as $greeting)
                <li class="list-group-item p-0">
                    <form method="POST" action="{{ route('edit.greeting') }}" enctype="multipart/form-data" id="editGreetingForm{{ $greeting->id }}">@csrf</form>
                    <form method="POST" action="{{ route('delete.greeting') }}" id="deleteGreetingForm{{ $greeting->id }}">@csrf</form>
                    <div class="row no-gutters greeting-group p-3">
                        @csrf

                        <div class="col-sm-auto greeting-image mb-2 mb-sm-0 pr-0 pr-sm-3">
                            <img src="{{ asset('images/greetings/' . $greeting->greeting) }}"/>
                            <input class="greeting-input" type="file" accept="image/*" class="form-control" name="greeting" form="editGreetingForm{{ $greeting->id }}" autofocus>
                        </div>

                        <div class="col-sm row no-gutters">
                            <div class="col-md align-self-center row no-gutters greeting-details">
                                <input id="displayDate" type="text" class="col-md form-control greeting-date mr-sm-1" name="display_date" value="{{ $greeting->display_date != null ? $greeting->display_date : '' }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" form="editGreetingForm{{ $greeting->id }}" required autocomplete="displayDate" autofocus>
                                <div class="col-md-auto greeting-buttons ml-md-1">
                                    <button type="submit" name="greeting_id" value="{{ $greeting->id }}" class="btn btn-secondary mr-1 my-1" form="editGreetingForm{{ $greeting->id }}">
                                        {{ __('Edit') }}
                                    </button>
                                    <button type="submit" name="greeting_id" value="{{ $greeting->id }}" class="btn btn-primary ml-1 my-1" form="deleteGreetingForm{{ $greeting->id }}" >
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <span>
            {{ $greetings->links() }}
        </span>
    </div>
</div>

<x-kumusta-popup />

@endsection
