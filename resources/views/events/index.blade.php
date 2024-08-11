@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('event.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('events.create') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
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
