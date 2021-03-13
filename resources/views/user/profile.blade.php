@extends('layouts.user')
@section('title', 'Profile')
@section('content')
<div class="row justify-content-start">
    <div class="col-12">

        @foreach (['danger', 'warning', 'success', 'info'] as $message)
            <div class="flash-message">
                @if (Session::has('alert-' . $message))
                    <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            </div>
        @endforeach
        <h3 class="mb-4">
            <strong>
                {{ __('PROFILE') }}
            </strong>
        </h3>
        <form method="POST" action="{{ route('update.profile') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label for="avatar" class="col-md-4 col-form-label">{{ __('Profile Picture:') }}</label>

                <div class="col-md-6 custom-upload-image">
                    <img id="avatarDisplay" class="circle-image" src="{{ asset('images/avatars/' . Auth::user()->avatar) }}"/>
                    <input id="avatar" type="file" accept="image/*" class="form-control @error('avatar') is-invalid @enderror" name="avatar" autofocus>

                    <span class="click-here">
                        {{ __('*Click the circle above to upload image*') }}
                    </span>

                    @error('avatar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-md-4 col-form-label">{{ __('Last Name:') }}</label>

                <div class="col-md-6">
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" required autocomplete="last_name" autofocus>

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="first_name" class="col-md-4 col-form-label">{{ __('First Name:') }}</label>

                <div class="col-md-6">
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required autocomplete="first_name" autofocus>

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="middle_name" class="col-md-4 col-form-label">{{ __('Middle Name:') }}</label>

                <div class="col-md-6">
                    <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name', Auth::user()->middle_name) }}" placeholder="(OPTIONAL)" autocomplete="middle_name" autofocus>

                    @error('middle_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label">{{ __('Username:') }}</label>

                <div class="col-md-6">
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', Auth::user()->username) }}" required autocomplete="username" autofocus>

                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label">{{ __('E-Mail Address:') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email" disabled>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="birthdate" class="col-md-4 col-form-label">{{ __('Birth Date:') }}</label>

                <div class="col-md-6">
                    <input id="birthdate" type="text" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate', Auth::user()->birthdate) }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="birthdate" autofocus>

                    @error('birthdate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="contact" class="col-md-4 col-form-label">{{ __('Contact Number:') }}</label>

                <div class="col-md-6">
                    <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact', Auth::user()->contact) }}" required autocomplete="contact">

                    @error('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="facebook" class="col-md-4 col-form-label">{{ __('Facebook URL:') }}</label>

                <div class="col-md-6">
                    <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{ old('facebook', Auth::user()->facebook) }}" placeholder="(OPTIONAL)" autocomplete="facebook">

                    @error('facebook')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="agency" class="col-md-4 col-form-label">{{ __('Agency:') }}</label>

                <div class="col-md-6">
                    <input id="agency" type="text" class="form-control @error('agency') is-invalid @enderror" name="agency" value="{{ old('agency', Auth::user()->agency) }}" required autocomplete="agency">

                    @error('agency')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="occupation" class="col-md-4 col-form-label">{{ __('Occupation:') }}</label>

                <div class="col-md-6">
                    <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ old('occupation', Auth::user()->occupation) }}" required autocomplete="occupation">

                    @error('occupation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label">{{ __('Address (Abroad):') }}</label>

                <div class="col-md-6">
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', Auth::user()->address) }}" required autocomplete="address">

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="country_id" class="col-md-4 col-form-label">{{ __('Country:') }}</label>

                <div class="col-md-6">
                    <select id="country_id" class="form-control @error('country_id') is-invalid @enderror" name="country_id" required>
                        <option value="">-- Select a Country--</option>
                        @foreach ($countries as $country)
                            @if (old('country_id', null) != null)
                                @if (old('country_id') == $country->id)
                                    <option value="{{ $country->id }}" selected>{{ $country->country }}</option>
                                @else
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                @endif
                            @else
                                @if (Auth::user()->country_id == $country->id)
                                    <option value="{{ $country->id }}" selected>{{ $country->country }}</option>
                                @else
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>

                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row no-gutters mb-0">
                <div class="col-sm-auto">
                    <button type="submit" class="btn btn-primary mr-0 mr-sm-1 mb-1 mb-sm-0">
                        {{ __('Save') }}
                    </button>
                </div>
                <div class="col-sm-auto">
                    <button type="button" class="btn btn-secondary ml-0 ml-sm-1 mt-1 mt-sm-0" data-toggle="modal" data-target="#changePasswordModal" data-backdrop="static" data-keyboard="false">
                        {{ __('Change Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="POST" action="{{ route('change.password') }}">
                    @csrf
                    
                    <div class="form-group row">
                        <label for="current-password" class="col-md-4 col-form-label">{{ __('Current Password:') }}</label>

                        <div class="col-md-6">
                            <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">

                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new-password" class="col-md-4 col-form-label">{{ __('New Password:') }}</label>

                        <div class="col-md-6">
                            <input id="new-password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">

                            @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="new-password-confirm" class="col-md-4 col-form-label">{{ __('Confirm New Password:') }}</label>

                        <div class="col-md-6">
                            <input id="new-password-confirm" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row no-gutters mb-0">
                        <div class="col-sm-auto">
                            <button type="submit" class="btn btn-primary mr-0 mr-sm-1 mb-1 mb-sm-0">
                                {{ __('Submit') }}
                            </button>
                        </div class="col-sm-auto">
                        <div>
                            <button type="button" class="btn btn-secondary ml-0 ml-sm-1 mt-1 mt-sm-0" data-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<x-kumusta-popup />

@if ($errors->has('current_password') || $errors->has('new_password'))
    <script type="application/javascript">
        setTimeout(function () {
            $(document).ready(function() {
                $('#changePasswordModal').modal('show');
            });
        }, 1);
    </script>
@endif

@endsection
