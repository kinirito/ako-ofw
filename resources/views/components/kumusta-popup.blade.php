@if (!(Auth::user()->is_admin || Auth::user()->is_status_answered))
    <div class="modal fade" id="kumustaModal" tabindex="-1" role="dialog" aria-labelledby="kumustaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <h2 class="mb-1">
                        <strong>
                            {{ __('KUMUSTA! KABAYAN') }}
                        </strong>
                    </h2>
                    <span class="d-block">
                        {{ __('Ano ang kalagayan mo ngayon?') }}
                    </span>
                    <form method="POST" action="{{ route('mabuti.status') }}">
                        @csrf
                        
                        <div class="form-group row my-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-secondary mx-1 my-1">
                                    {{ __('Mabuti') }}
                                </button>
                                <a href="{{ route('saklolo') }}" class="btn btn-primary mx-1 my-1">
                                    {{ __('Hindi Mabuti') }}
                                </a>
                            </div>
                        </div>
                    </form>
                    <span class="text-danger text-left d-block">
                        <strong>
                            {{ __('PAALALA:') }}
                        </strong>
                        {{ __(' Ang OFW na nakarehistro lamang ang pwedeng magpadala ng tugon. Hindi maaaring sumagot ang volunteers para sa isang distressed OFW') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endif