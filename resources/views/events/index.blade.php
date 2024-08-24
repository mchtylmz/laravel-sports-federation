@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('event.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('events.create') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
        <form class="js-filter-table mb-3">
            <div class="row align-items-end justify-content-start">
                <input type="hidden" name="type" value="event">
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
                <div class="col-lg-3 mb-1">
                    <label class="form-label" for="date">Etkinlik Tarihi</label>
                    <input type="text" class="daterangepicker form-control mt-0" style="position: unset !important;" placeholder="GG-AA-YYYY" autocomplete="off" id="date" name="date">
                </div>

                <div class="col-lg-2 mb-1">
                    <button type="submit" class="btn btn-alt-success w-100 js-filter-event-submit">
                        <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                    </button>
                </div>
            </div>
        </form>

        <x-table route="{{ route('event.json') }}"
                 export-pdf="{{ route('event.export.pdf') }}"
                 export-excel="{{ route('event.export.excel') }}">
            <x-slot name="columns">
                <th data-field="title" data-sortable="true" data-width="25" data-align="left">
                    {{ __('table.title') }}
                </th>
                <th data-field="location" data-sortable="true">
                    {{ __('table.location') }}
                </th>
                <th data-field="start_date" data-sortable="true">
                    {{ __('table.start_date') }}
                </th>
                <th data-field="end_date" data-sortable="true">
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
    </x-block>
@endsection
