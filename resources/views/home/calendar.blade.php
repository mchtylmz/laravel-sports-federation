@extends('layouts.app')

@section('content')

    <div class="row">

        @if($noteCount = user()->federation()?->notes()->where('is_read', 0)->count())
            <div class="alert alert-warning">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-9">
                        <i class="fa fa-note-sticky fa-fw mx-2"></i>
                        <strong>{{ $noteCount }} okunmamış notunuz var!</strong>
                    </div>
                    <div class="col-lg-3">
                        <a type="button" class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled w-100" href="">
                            <i class="fa fa-fw fa-eye mx-2"></i> Görüntüle
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-12 py-3 bg-white mb-3">
            <div id="js-calendar" data-route="{{ route('event.calendar') }}"></div>
        </div>

    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_calendar.min.js') }}"></script>
@endpush
