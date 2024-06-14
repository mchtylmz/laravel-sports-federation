@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-lg-6">
            <div id="js-calendar"></div>
        </div>

        <div class="col-md-3 col-lg-3 col-xl-3">
            <!-- Add Event Form -->q
            <form class="js-form-add-event push">
                <div class="input-group">
                    <input type="text" class="js-add-event form-control" placeholder="Add Event..">
                    <span class="input-group-text">
                        <i class="fa fa-fw fa-plus-circle"></i>
                      </span>
                </div>
            </form>
            <!-- END Add Event Form -->

            <!-- Event List -->
            <ul id="js-events" class="list list-events">

                <li>
                    <div class="js-event p-2 fs-sm fw-medium rounded bg-warning-light text-warning">Skype Meeting</div>
                </li>
            </ul>
            <div class="text-center">
                <p class="fs-sm text-muted">
                    <i class="fa fa-arrows-alt"></i> Drag and drop events on the calendar
                </p>
            </div>
            <!-- END Event List -->
        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_calendar.min.js') }}"></script>
@endpush
