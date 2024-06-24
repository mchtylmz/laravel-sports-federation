@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-lg-12 py-3 bg-white mb-3">
            <div id="js-calendar" data-route="{{ route('event.calendar') }}"></div>
        </div>

    </div>

    @include('components.offcanvas')
@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_calendar.min.js') }}"></script>
@endpush
