@extends('layouts.user')
@section('title', 'Discounts')
@section('content')
@foreach (['danger', 'warning', 'success', 'info'] as $message)
    <div class="flash-message">
        @if (Session::has('alert-' . $message))
            <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    </div>
@endforeach

@if ($errors->has('logo') || $errors->has('brand') || $errors->has('description'))
    <div class="flash-message">
    @error('logo')
        <p class="alert alert-danger">{{ $message }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @enderror
    @error('brand')
        <p class="alert alert-danger">{{ $message }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @enderror
    @error('description')
        <p class="alert alert-danger">{{ $message }}<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @enderror
    </div>
@endif
<div class="row justify-content-start">
    <div class="col-12">
        <h3 class="mb-4">
            <strong>
                {{ __('DISCOUNTS') }}
            </strong>
        </h3>
        <form method="GET" action="{{ route('discounts') }}">    
            <div class="form-group form-search row no-gutters">
                <input id="search" type="text" class="col-md form-control @error('search') is-invalid @enderror mb-2 mb-md-0 mr-md-1" name="search" value="{{ old('search', $request->search) }}" autocomplete="search" autofocus>
                @error('search')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button class="btn btn-secondary col-md-auto ml-md-1" type="submit">{{ __('Search') }}</button>
            </div>
        </form>
        @if (Auth::user()->is_admin)
            <div class="mb-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDiscountModal" data-backdrop="static" data-keyboard="false">
                    {{ __('Add Discount') }}
                </button>
            </div>
            <div class="modal fade" id="addDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add.discount') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row no-gutters">
                                    <label for="addLogo" class="col-md-4 col-form-label">{{ __('Logo:') }}</label>

                                    <div class="col-md-6 custom-upload-image">
                                        <img id="addLogoDisplay" src="{{ asset('images/discounts/default_discount.jpg') }}"/>
                                        <input id="addLogo" type="file" accept="image/*" class="form-control @error('add_logo') is-invalid @enderror" name="add_logo" autofocus>

                                        <span class="click-here">
                                            *Click the image above to upload logo*
                                        </span>

                                        @error('add_logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row no-gutters">
                                    <label for="addBrand" class="col-md-4 col-form-label">{{ __('Brand:') }}</label>

                                    <div class="col-md-6">
                                        <input id="addBrand" type="text" class="form-control @error('add_brand') is-invalid @enderror" value="{{ old('add_brand', $request->add_brand != null ? $request->add_brand : '') }}" name="add_brand" required autocomplete="addBrand">

                                        @error('add_brand')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row no-gutters">
                                    <label for="addDescription" class="col-md-4 col-form-label">{{ __('Description:') }}</label>

                                    <div class="col-md-6">
                                        <textarea id="addDescription" type="text" class="form-control @error('add_description') is-invalid @enderror" name="add_description" required>{{ old('add_description', $request->add_description != null ? $request->add_description : '') }}</textarea>

                                        @error('add_description')
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
        @endif

        <div class="row justify-content-start">
            @foreach ($discounts as $discount)
                <div class="col-12 col-lg-6 mb-4">
                    @if (Auth::user()->is_admin)
                        <form method="POST" action="{{ route('edit.discount') }}" enctype="multipart/form-data" id="editDiscountForm{{ $discount->id }}">@csrf</form>
                        <form method="POST" action="{{ route('delete.discount') }}" id="deleteDiscountForm{{ $discount->id }}">@csrf</form>
                        <div class="discount-group row no-gutters">
                            <div class="discount-logo col-sm-auto">
                                <img src="{{ asset('images/discounts/' . $discount->logo) }}"/>
                                <input class="logo-input" type="file" accept="image/*" class="form-control" name="logo" form="editDiscountForm{{ $discount->id }}">
                            </div>
                            <div class="discount-details col row no-gutters justify-content-center">
                                <div class="col align-self-center">
                                    <input type="text" name="brand" value="{{ $discount->brand }}" class="discount-brand" form="editDiscountForm{{ $discount->id }}" required>
                                    <input type="text" name="description" value="{{ $discount->description }}" class="discount-description" form="editDiscountForm{{ $discount->id }}" required>    
                                </div>
                            </div>
                            <div class="discount-buttons col-sm-auto row no-gutters">
                                <button type="submit" name="discount_id" value="{{ $discount->id }}" form="editDiscountForm{{ $discount->id }}" class="edit col col-sm-12"><i class="icon-edit"></i></button>
                                <button type="submit" name="discount_id" value="{{ $discount->id }}" form="deleteDiscountForm{{ $discount->id }}" class="delete col col-sm-12"><i class="icon-delete"></i></button>
                            </div>
                        </div>
                    @else
                        <div class="discount-group row no-gutters">
                            @csrf

                            <div class="discount-logo col-sm-auto">
                                <img id="logoDisplay" src="{{ asset('images/discounts/' . $discount->logo) }}"/>
                            </div>
                            <div class="discount-details col row no-gutters justify-content-center">
                                <div class="col align-self-center">
                                    <h4 class="discount-brand">
                                        <strong>
                                            {{ $discount->brand }}
                                        </strong>
                                    </h4>
                                    <span class="discount-description">
                                        {{ $discount->description }}
                                    </span>    
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        <span>
            {{ $discounts->links() }}
        </span>
    </div>
</div>

<x-kumusta-popup />

@if ($errors->has('add_logo') || $errors->has('add_brand') || $errors->has('add_description'))
    <script type="application/javascript">
        setTimeout(function () {
            $(document).ready(function() {
                $('#addDiscountModal').modal('show');
            });
        }, 1);
    </script>
@endif

@endsection
