@extends('layouts.auth')
@section('title', 'Sign Up')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        @foreach (['danger', 'warning', 'success', 'info'] as $message)
            <div class="flash-message">
                @if (Session::has('alert-' . $message))
                    <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            </div>
        @endforeach

        <div class="col-12">
            <h2 class="text-center mb-5">
                <strong>
                    {{ __('Create New Account') }}
                </strong>
            </h2>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                @csrf

                <div class="form-group row">
                    <label for="avatar" class="col-md-4 col-form-label">{{ __('Profile Picture:') }}</label>

                    <div class="col-md-6 custom-upload-image">
                        <img id="avatarDisplay" class="circle-image" src="{{ asset('images/avatars/default_avatar.jpg') }}"/>
                        <input id="avatar" type="file" accept="image/*" class="form-control @error('avatar') is-invalid @enderror" name="avatar">

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
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

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
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

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
                        <input id="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ old('middle_name') }}" placeholder="(OPTIONAL)" autocomplete="middle_name" autofocus>

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
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

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
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label">{{ __('Password:') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label">{{ __('Confirm Password:') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="birthdate" class="col-md-4 col-form-label">{{ __('Birth Date:') }}</label>

                    <div class="col-md-6">
                        <input id="birthdate" type="text" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}" data-provide="datepicker" data-date-format="yyyy-mm-dd" onkeydown="return false" required autocomplete="birthdate" autofocus>

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
                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact">

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
                        <input id="facebook" type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" value="{{ old('facebook') }}" placeholder="(OPTIONAL)" autocomplete="facebook">

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
                        <input id="agency" type="text" class="form-control @error('agency') is-invalid @enderror" name="agency" value="{{ old('agency') }}" required autocomplete="agency">

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
                        <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ old('occupation') }}" required autocomplete="occupation">

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
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

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
                            <option value="">{{ __('-- Select a Country--') }}</option>
                            @foreach ($countries as $country)
                                @if (old('country_id') == $country->id)
                                    <option value="{{ $country->id }}" selected>{{ $country->country }}</option>
                                @else
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                @endif
                            @endforeach
                        </select>

                        @error('country_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-1">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#termsModal" data-backdrop="static" data-keyboard="false">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-12">
                        @if (Route::has('login'))
                            <a class="btn btn-link" href="{{ route('login') }}">
                                {{ __('I already have account') }}
                            </a>
                        @endif
                    </div>
                </div>

                <button type="submit" class="d-none" id="registerButton">
                    {{ __('Submit') }}
                </button>

                <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-body">
                                <img src="{{ asset('images/assets/akoofw_banner.jpg') }}" alt="Ako OFW" class="w-100 mb-4">
                                <h2>
                                    <strong>
                                        {{ __('Sign Up Terms & Conditions') }}
                                    </strong>
                                </h2>
                                <p class="text-left my-4">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('By signing up on this online registration form, I hereby certify that the information herein are true and correct according to the best of my knowledge.') }}
                                    <br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('I hereby agree and consent that Advocates and Keepers Organization of OFW (AKOOFW) Inc. may collect, use, disclose and process information set out in this form.') }}
                                    <br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('I hereby agree and consent AKO OFW Inc  to participate and  apply a petition for  partylist system representation.') }}
                                    <br/>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ __('I hereby pledge to support to the lawful activities of AKOOFW Inc. and will obey it’s By- laws and recognize the duly constituted authorities therein. Further declare that I will do no falsehood that will cause harm to the organization as a whole. Any misrepresentation and violation hereof will be ground for revocation of my membership.') }}
                                </p>
                                <div>
                                    <button type="button" class="btn btn-primary mr-1" id="termsAcceptButton">
                                        {{ __('Accept') }}
                                    </button>
                                    <button type="button" class="btn btn-secondary ml-1" data-dismiss="modal">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
