@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('federation.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('settings.federation_add') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
        <x-table route="{{ route('federation.json') }}" pagination="ajax">
            <x-slot name="columns">
                <th data-field="id" data-width="5" data-sortable="true">
                    {{ __('table.id') }}
                </th>
                <th data-field="logo" data-formatter="setImage">
                    {{ __('table.logo') }}
                </th>
                <th data-field="name" data-sortable="true" data-width="25" data-align="left">
                    {{ __('table.title') }}
                </th>
                <th data-field="document_number" data-sortable="true">
                    {{ __('table.document_number') }}
                </th>
                <th data-field="branch_number" data-sortable="true">
                    {{ __('table.branch_number') }}
                </th>
                <th data-field="is_special" data-formatter="setText" data-sortable="true">
                    {{ __('table.is_special') }}
                </th>
                <th data-field="website"  data-sortable="true">
                    Site
                </th>
                <th data-field="id" data-formatter="setNotes" data-sortable="true">
                    Not
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
