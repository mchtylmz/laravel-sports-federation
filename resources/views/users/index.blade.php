@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-3 offset-0 offset-sm-9 order-1 order-sm-2 text-end mb-3">
            <a type="button" class="btn btn-info w-100" href="{{ route('user.show', $userType) }}">
                <i class="fa fa-fw fa-plus"></i> {{ __('users.add_'.$userType) }}
            </a>
        </div>
    </div>

    <x-block title="{{ $title }}">
        <form class="js-filter-table">
            <div class="row align-items-end justify-content-start">
                @if($userType == 'admin')
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" for="federation">{{ __('table.federation') }}</label>
                        <select class="selectpicker form-control" id="federation" name="federation" data-placeholder="{{ __('table.federation') }}...." data-size="5" data-live-search="true">
                            @foreach(federations() as $federation)
                                <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if($userType == 'manager')
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" for="location">{{ __('table.location') }}</label>
                        <select class="selectpicker form-control" id="location" name="location" data-placeholder="{{ __('table.location') }}...." data-size="5" data-live-search="true">
                            @foreach(places() as $places)
                                <option value="{{ $places }}">{{ $places }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="last_login">{{ __('table.last_login') }}</label>
                    <input type="text" class="js-flatpickr form-control" id="last_login" name="last_login" data-locale="tr" placeholder="YYYY-AA-GG" data-mode="range" readonly="readonly">
                </div>
                <div class="col-lg-2 mb-3">
                    <button type="submit" class="btn btn-alt-success w-100 js-filter-submit">
                        <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                    </button>
                </div>
            </div>
        </form>
        <hr>

        <x-table route="{{ route('user.json', $userType) }}" pagination="ajax">
            <x-slot name="columns">
                <th data-field="id" data-width="5">
                    {{ __('table.id') }}
                </th>
                @if($userType == 'admin')
                    <th data-field="federation_name" data-width="20" data-align="left">
                        {{ __('table.federation') }}
                    </th>
                @endif
                @if($userType == 'manager')
                    <th data-field="identity_number" data-width="15" data-align="left">
                        {{ __('table.identity_number') }}
                    </th>
                @endif
                <th data-field="username" data-sortable="true" data-width="15" data-align="left">
                    {{ __('table.username') }}
                </th>
                <th data-field="name" data-sortable="true" data-width="20" data-align="left">
                    {{ __('table.name') }}
                </th>
                <th data-field="email" data-sortable="true" data-width="10" data-align="left">
                    {{ __('table.email') }}
                </th>
                <th data-field="last_login" data-sortable="true" data-width="10" data-align="left">
                    {{ __('table.last_login') }}
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
