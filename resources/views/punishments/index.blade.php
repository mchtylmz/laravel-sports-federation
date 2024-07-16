@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('punishment.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('punishments.add') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
        <x-table route="{{ route('punishment.json') }}" pagination="ajax">
            <x-slot name="columns">
                <th data-field="id" data-width="5" data-sortable="true">
                    {{ __('table.id') }}
                </th>
                <th data-field="photo" data-formatter="setImage" data-width="10">
                    {{ __('table.photo') }}
                </th>
                <th data-field="fullname" data-sortable="true" data-width="15" data-align="left">
                    {{ __('table.name') }}
                </th>
                <th data-field="reason" data-sortable="true">
                    {{ __('table.reason') }}
                </th>
                <th data-field="description" data-sortable="true">
                    {{ __('table.description') }}
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
