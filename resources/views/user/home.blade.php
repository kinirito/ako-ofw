@extends('layouts.user')
@section('title', 'Home')
@section('content')
@foreach (['danger', 'warning', 'success', 'info'] as $message)
    <div class="flash-message">
        @if (Session::has('alert-' . $message))
            <p class="alert alert-{{ $message }}">{{ Session::get('alert-' . $message) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    </div>
@endforeach


<div class="row justify-content-start home">
    @if ($streaming->is_broadcast)
        <div class="col-md">
            <h3 class="mb-4">
                <strong>
                    {{ __('LIVE STREAMING TODAY') }}
                </strong>
            </h3>
            {!! $streaming->embed_code !!}
        </div>
    @endif
    <div class="col-xl-auto">
        <h3 class="mb-4">
            <strong>
                {{ __('FACEBOOK UPDATES') }}
            </strong>
        </h3>
        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fweb.facebook.com%2FAKOOFWinc&tabs=timeline&width=300&height=400&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId" width="300" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
    </div>
</div>

@foreach ($greetings as $greeting)
    <div class="modal fade" id="greetingModal" tabindex="-1" role="dialog" aria-labelledby="greetingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="d-sm-none">
                        <button type="button" class="close mb-3" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <img src="{{ asset('images/greetings/' . $greeting->greeting) }}" class="w-100">
                </div>
            </div>
        </div>
    </div>
@endforeach

<x-kumusta-popup />

@endsection
