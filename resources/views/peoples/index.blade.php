@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('people.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('peoples.add') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
        <x-table route="{{ route('people.json') }}" pagination="ajax">
            <x-slot name="columns">
                <th data-field="license_no" data-width="5" data-sortable="true" data-align="left">
                    {{ __('peoples.license_no') }}
                </th>
                <th data-field="type" data-formatter="setText" data-width="5">
                    {{ __('peoples.type') }}
                </th>
                <th data-field="photo" data-formatter="setImage" data-width="10">
                    {{ __('table.photo') }}
                </th>
                <th data-field="nationality" data-sortable="true" data-align="left">
                    {{ __('peoples.nationality') }}
                </th>
                <th data-field="fullname" data-sortable="true" data-width="15" data-align="left">
                    {{ __('table.name') }}
                </th>
                <th data-field="phone" data-sortable="true">
                    {{ __('table.phone') }}
                </th>
                <th data-field="email" data-sortable="true">
                    {{ __('table.email') }}
                </th>
                <th data-field="gender" data-sortable="true">
                    {{ __('table.gender') }}
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
