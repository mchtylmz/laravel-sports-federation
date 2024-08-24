@extends('layouts.app')
@section('content')

    @if(hasRole('superadmin') && !userPermit(['mudur']))
        <div class="text-end mb-3">
            <a type="button" class="btn btn-info" href="{{ route('club.show') }}">
                <i class="fa fa-fw fa-plus"></i> {{ __('clubs.create') }}
            </a>
        </div>
    @endif

    <x-block title="{{ $title }}">
        @if(hasRole('superadmin'))
            <form class="js-filter-table">
                <div class="row align-items-end justify-content-between">
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" for="federation_id">{{ __('table.federation') }}</label>
                        <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="{{ __('table.federation') }}...." data-size="5" data-live-search="true">
                            <option value="">{{ __('table.all') }}</option>
                            @foreach(federations() as $federation)
                                <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 mb-3">
                        <button type="submit" class="btn btn-alt-success w-100 js-filter-submit">
                            <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                        </button>
                    </div>
                </div>
            </form>
            <hr>
        @endif

        <x-table route="{{ route('club.json') }}" pagination="ajax">
            <x-slot name="columns">
                <th data-field="id" data-width="5">
                    {{ __('table.id') }}
                </th>
                <th data-field="federation_names" data-formatter="setHtml" data-width="15">
                    {{ __('table.federation') }}
                </th>
                <th data-field="name" data-sortable="true" data-width="25" data-align="left">
                    {{ __('clubs.form.name') }}
                </th>
                <th data-field="location" data-sortable="true">
                    {{ __('table.location') }}
                </th>
                <th data-field="region" data-sortable="true">
                    {{ __('table.region') }}
                </th>
                <th data-field="user_info" data-formatter="setHtml">
                    {{ __('clubs.form.user') }}
                </th>
                <th data-field="tombala" data-sortable="true">
                    Tombala
                </th>
                <th data-field="status" data-formatter="setHtml" data-sortable="true">
                    {{ __('table.status') }}
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
