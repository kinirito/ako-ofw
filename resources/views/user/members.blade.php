@extends('layouts.user')
@section('title', 'Members List')
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
                {{ __('MEMBERS LIST') }}
            </strong>
        </h3>
        <form method="GET" action="{{ route('members') }}" class="row no-gutters">
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
                    <input type="radio" id="DESCRadio" name="sorting" value="DESC" class="custom-control-input" checked>
                    <label class="custom-control-label" for="DESCRadio">{{ __('Descending') }}</label>
                </div>
                <div class="custom-control custom-radio ml-1 mr-md-1">
                    <input type="radio" id="ASCRadio" name="sorting" value="ASC" class="custom-control-input d-block" {{ $request->sorting == 'ASC' ? 'checked' : '' }}>
                    <label class="custom-control-label" for="ASCRadio">{{ __('Ascending') }}</label>
                </div>
            </div>
            <div class="col-md-auto form-search row no-gutters">
                <button class="btn btn-secondary mb-2 ml-md-1" type="submit">{{ __('Search') }}</button>
            </div>
        </form>
        <form method="POST" action="{{ route('kumustahin.lahat') }}">
            @csrf

            <button class="btn btn-primary mb-4 mt-2" type="submit">{{ __('Kumustahin Lahat') }}</button>
        </form>
        <ul class="list-group">
            @foreach ($users as $user)
                <li class="list-group-item p-0">
                    <div class="row no-gutters member-group p-3">
                        @csrf
                        <div class="col-sm-auto mb-3 mb-sm-0 d-sm-none text-center">
                            <img src="{{ asset('/images/avatars/' . $user->avatar) }}" class="align-self-center">
                        </div>
                        <div class="col-sm row no-gutters justify-content-start">
                            <div class="col-12 align-self-center">
                                <h4 class="col-12 mb-0 p-0">
                                    <strong>
                                        @if ($user->middle_name != null || $user->middle_name != "")
                                            {{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}
                                        @else
                                            {{ $user->first_name . ' ' . $user->last_name }}
                                        @endif
                                    </strong>
                                </h4>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>
                                            {{ $user->username }}
                                        </strong>
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Birthdate: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $user->birthdate }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Contact Number: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $user->contact }}
                                    </span>
                                </div>
                                @if ($user->facebook != null)
                                    <div class="mb-0">
                                        <span class="d-inline-block">
                                            <strong>{{ __('Facebook URL: ') }}</strong>
                                        </span>
                                        <span class="d-inline-block">
                                            {{ $user->facebook }}
                                        </span>
                                    </div>
                                @endif
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Agency: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $user->agency }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Occupation: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $user->occupation }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Address (Abroad): ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $user->address }}
                                    </span>
                                </div>
                                <div class="mb-0">
                                    <span class="d-inline-block">
                                        <strong>{{ __('Country: ') }}</strong>
                                    </span>
                                    <span class="d-inline-block">
                                        {{ $user->country }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('kumustahin') }}" class="mt-2">
                                    @csrf
                                    
                                    <button type="submit" name="user_id" value="{{ $user->id }}" class="btn btn-secondary">
                                        {{ __('KUMUSTAHIN') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-auto col pl-3 row no-gutters justify-content-start">
                            <img src="{{ asset('/images/avatars/' . $user->avatar) }}" class="align-self-center d-none d-sm-block my-0">
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        <span>
            {{ $users->links() }}
        </span>
    </div>
</div>
@endsection
