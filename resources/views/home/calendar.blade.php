@extends('layouts.app')

@section('content')

    <div class="block border p-0">
        <ul class="nav nav-tabs nav-tabs-alt align-items-center border bg-light-subtle" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-5 home-calendar" id="btabs-calendar-tab" data-bs-toggle="tab" data-bs-target="#btabs-calendar" role="tab" aria-controls="btabs-calendar" aria-selected="false" tabindex="-1">
                    Etkinlikler Takvim
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-5 home-calendar" id="btabs-list-tab" data-bs-toggle="tab" data-bs-target="#btabs-list" role="tab" aria-controls="btabs-list" aria-selected="true">
                    Etkinlikler Liste
                </button>
            </li>
        </ul>
        <div class="block-content tab-content overflow-hidden">
            <!-- -->
            <div class="tab-pane active show pb-3" id="btabs-calendar" role="tabpanel" aria-labelledby="btabs-calendar" tabindex="0">
                <form class="js-filter-event mb-3">
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
                        @if(hasRole('superadmin', 'calendar', 'admin'))
                            <div class="col-lg-2 mb-1">
                                <label class="form-label" for="type">Etkinlik Tipi</label>
                                <select class="selectpicker form-control" id="type" name="type" data-placeholder="Tümü" data-size="5" data-live-search="true">
                                    <option value="">Tümü</option>
                                    @foreach(eventTypeCases() as $type)
                                        <option value="{{ $type->name }}">{{ $type->title() }}</option>
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
                <div id="js-calendar" data-route="{{ route('event.calendar') }}"></div>
            </div>
            <!-- -->

            <!-- -->
            <div class="tab-pane pb-3" id="btabs-list" role="tabpanel" aria-labelledby="btabs-list" tabindex="0">
                <form class="js-filter-event mb-3">
                    <div class="row align-items-end justify-content-start">
                        <div class="col-lg-3 mb-1 form-group">
                            <label class="form-label" for="date">Etkinlik Tarihi</label>
                            <input type="text" class="daterangepicker form-control" style="position: unset !important;" placeholder="GG-AA-YYYY" autocomplete="off" id="date" name="date">
                        </div>

                        <div class="col-lg-2 mb-1">
                            <button type="submit" class="btn btn-alt-success w-100 js-filter-event-submit">
                                <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                            </button>
                        </div>
                    </div>
                </form>

                <x-table route="{{ route('event.json') }}?action=lite"
                         export-pdf="{{ route('event.export.pdf') }}"
                         export-excel="{{ route('event.export.excel') }}">
                    <x-slot name="columns">
                        <th data-field="title" data-sortable="true" data-width="25" data-align="left">
                            {{ __('table.title') }}
                        </th>
                        <th data-field="location" data-sortable="true">
                            {{ __('table.location') }}
                        </th>
                        <th data-field="startStr" data-sortable="true">
                            {{ __('table.start_date') }}
                        </th>
                        <th data-field="endStr" data-sortable="true">
                            {{ __('table.end_date') }}
                        </th>
                        @if(hasRole('admin'))
                            <th data-field="is_national" data-sortable="true" data-formatter="setText">
                                {{ __('table.is_national') }}
                            </th>
                        @endif
                        <th data-field="status" data-sortable="true">
                            {{ __('table.status') }}
                        </th>
                        <th data-field="id" data-formatter="setActions">
                            {{ __('table.actions') }}
                        </th>
                    </x-slot>
                </x-table>
            </div>
            <!-- -->

        </div>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_calendar.min.js') }}?v={{ config('app.version') }}"></script>
@endpush
