@extends('layouts.user')
@section('title', 'Kumusta! Kabayan')
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
        <h3>
            <strong>
                {{ __('KUMUSTA! KABAYAN') }}
            </strong>
        </h3>
        <form method="GET">
            <div class="row no-gutters form-search">
                <div class="col-md form-search form-group row no-gutters mb-0">
                    <input id="search" type="text" class="w-100 form-control @error('search') is-invalid @enderror  mb-2 mr-md-1" name="search" value="{{ $request->search }}" autocomplete="search" autofocus>
                    @error('search')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-auto form-search row no-gutters mx-md-4 mb-2 justify-content-center justify-content-md-start">
                    <div class="custom-control custom-radio ml-md-1 mr-1">
                        <input type="radio" id="allStatus" name="status" value="All" class="custom-control-input" checked>
                        <label class="custom-control-label" for="allStatus">{{ __('All') }}</label>
                    </div>
                    <div class="custom-control custom-radio mx-1">
                        <input type="radio" id="mabutiStatus" name="status" value="Mabuti" class="custom-control-input" {{ old('status', $request->status) == 'Mabuti' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="mabutiStatus">{{ __('Mabuti') }}</label>
                    </div>
                    <div class="custom-control custom-radio ml-1 mr-md-1">
                        <input type="radio" id="hindiMabutiStatus" name="status" value="Hindi Mabuti" class="custom-control-input" {{ old('status', $request->status) == 'Hindi Mabuti' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="hindiMabutiStatus">{{ __('Hindi Mabuti') }}</label>
                    </div>
                </div>
            </div>
            <div class="row no-gutters form-search form-group mb-2">
                <div class="col-md mb-2 mb-md-0 mr-md-1 row no-gutters date-range">
                    <label for="date_from" class="col-md-auto pr-5 mb-1 mb-md-0">{{ __('Date Span: ') }}</label>
                    <input id="dateFrom" type="text" class="col date-from form-control @error('date_from') is-invalid @enderror" name="date_from" value="{{ old('date_from', $request->date_from != null ? $request->date_from : '') }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="dateFrom">
                    <div class="col-auto date-separator">{{ __('to') }}</div>
                    <input id="dateTo" type="text" class="col date-to form-control @error('date_to') is-invalid @enderror" name="date_to" value="{{ old('date_to', $request->date_to != null ? $request->date_to : '') }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="dateTo">
                </div>
                <div class="col-md-auto row no-gutters">
                    <button class="btn btn-secondary ml-md-1" type="submit" formaction="{{ route('kumusta') }}">{{ __('Search') }}</button>
                </div>
            </div>
            <button class="btn btn-primary mb-4 mt-2" type="submit" formaction="{{ route('statuses.report') }}">{{ __('Generate Report') }}</button>
        </form>
        <ul class="list-group">
            @foreach ($statuses as $status)
                <li class="list-group-item p-0">
                    <div class="row no-gutters status-group p-3 {{ $status->is_okay ? '' : 'not-okay' }}">
                        <div class="col-sm-auto mb-3 mb-sm-0 mr-0 mr-sm-3">
                            <img src="{{ asset('/images/avatars/' . $status->avatar) }}">
                        </div>
                        <div class="col-sm row no-gutters justify-content-start">
                            <div class="col-12 align-self-center">
                                <h4 class="col-12 mb-0 p-0">
                                    <strong>
                                        @if ($status->middle_name != null || $status->middle_name != "")
                                            {{ $status->first_name . ' ' . $status->middle_name . ' ' . $status->last_name }}
                                        @else
                                            {{ $status->first_name . ' ' . $status->last_name }}
                                        @endif
                                    </strong>
                                </h4>
                                <div class="mb-0">
                                    <span class="d-inline-block font-italic">
                                        <strong>
                                            {{ $status->is_okay ? 'Mabuti' : 'Hindi Mabuti' }}
                                        </strong>

                                    </span>
                                </div>
                                <div class="mb-1">
                                    <span class="d-inline-block">
                                        {{ date('F j, Y', strtotime($status->updated_at)) }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Contact Number: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $status->contact }}
                                    </span>
                                </div>
                                @if ($status->facebook != null)
                                    <div class="mb-0">
                                        <span class="d-inline-block">
                                            <strong>{{ __('Facebook URL: ') }}</strong>
                                        </span>
                                        <span class="d-inline-block">
                                            {{ $status->facebook }}
                                        </span>
                                    </div>
                                @endif
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Agency: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $status->agency }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Occupation: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $status->occupation }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Address (Abroad): ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $status->address }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Country: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $status->country }}
                                    </span>
                                </div>
                                <div class="mb-0 row no-gutters justify-content-end">
                                    @if ($status->reason != null || $status->reason != "")
                                    <div class="col-sm">
                                        <div class="mb-0">
                                            <span class="d-inline-block">
                                                <strong>{{ $status->reason }}</strong>
                                            </span>
                                        </div>
                                        @if ($status->scenario != null || $status->scenario != "")
                                            <div class="mb-0">
                                                <span class="d-inline-block">
                                                    {{ $status->scenario }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                    <form method="POST" action="{{ route('kumustahin') }}" class="col-sm-auto row no-gutters justify-content-start">
                                        @csrf
                                        
                                        <button type="submit" name="user_id" value="{{ $status->user_id }}" class="col-auto align-self-bottom btn btn-secondary mt-2">
                                            {{ __('KUMUSTAHIN') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <span>
            {{ $statuses->links() }}
        </span>
    </div>
</div>
@endsection
