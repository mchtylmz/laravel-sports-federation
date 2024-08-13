@extends('layouts.app')

@section('content')

    <div class="block border p-0">
        <ul class="nav nav-tabs nav-tabs-alt align-items-center border-bottom bg-light-subtle" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-5" id="btabs-calendar-tab" data-bs-toggle="tab" data-bs-target="#btabs-calendar" role="tab" aria-controls="btabs-calendar" aria-selected="false" tabindex="-1">
                    Etkinlikler Takvim
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-5" id="btabs-list-tab" data-bs-toggle="tab" data-bs-target="#btabs-list" role="tab" aria-controls="btabs-list" aria-selected="true">
                    Etkinlikler Liste
                </button>
            </li>
        </ul>
        <div class="block-content tab-content overflow-hidden">
            <!-- -->
            <div class="tab-pane active show" id="btabs-calendar" role="tabpanel" aria-labelledby="btabs-calendar" tabindex="0">
                <form class="js-filter-event">
                    <div class="row align-items-end justify-content-start">
                        @if(hasRole('superadmin', 'calendar') && permitIf(role(), ['mudur', 'tescil']))
                            <div class="col-lg-2 mb-1">
                                <label class="form-label" for="federation_id">Federasyon / Branş</label>
                                <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="Tüm Federasyonlar / Branşlar" data-size="5" data-live-search="true">
                                    <option value="">Tüm Federasyonlar / Branşlar</option>
                                    @foreach(federations() as $federation)
                                        <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-lg-2 mb-1">
                            <label class="form-label" for="status">Durum</label>
                            <select class="selectpicker form-control" id="status" name="status" data-placeholder="Tüm Durumlar" data-size="5" data-live-search="true">
                                <option value="">Tüm Durumlar</option>
                                @foreach(eventStatuses() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 mb-1">
                            <label class="form-label" for="location">Tesis/Yer</label>
                            <select class="selectpicker form-control" id="location" name="location" data-placeholder="Tüm Tesisler" data-size="5" data-live-search="true">
                                <option value="">Tüm Tesisler</option>
                                @foreach(eventPlaces() as $place)
                                    <option value="{{ $place }}">{{ $place }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 mb-1">
                            <button type="submit" class="btn btn-alt-success w-100 js-filter-event-submit">
                                <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div id="js-calendar" data-route="{{ route('event.calendar') }}"></div>
                <br>
            </div>
            <!-- -->

            <!-- -->
            <div class="tab-pane" id="btabs-list" role="tabpanel" aria-labelledby="btabs-list" tabindex="0">
tablo
            </div>
            <!-- -->

        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_calendar.min.js') }}?v={{ config('app.version') }}"></script>
@endpush
