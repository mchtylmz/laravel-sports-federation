@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('punishment.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('punishments.add') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
        <form class="js-filter-table">
            <div class="row align-items-end justify-content-start">
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="federation_id">Federasyon / Branş</label>
                    <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="Tüm Federasyonlar / Branşlar" data-size="5" data-live-search="true">
                        <option value="">Tüm Federasyonlar / Branşlar</option>
                        @foreach(federations() as $federation)
                            <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="type">Kişi Tpi</label>
                    <select class="selectpicker form-control" id="type" name="type" data-placeholder="Kişi Tpi Seçiniz...." data-size="5" data-live-search="true">
                        @if(permitIf(role(), ['mudur']))
                            <option value="">{{ __('table.all') }}</option>
                            @foreach(\App\Enums\PeopleType::titles() as $key => $title)
                                <option value="{{ $key }}">{{ $title }}</option>
                            @endforeach
                        @else
                            <option value="{{ \App\Enums\PeopleType::racer }}">{{ \App\Enums\PeopleType::racer->title() }}</option>
                        @endif
                    </select>
                </div>

                <div class="col-lg-3 mb-3">
                    <button type="submit" class="btn btn-alt-success w-100 js-filter-submit">
                        <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                    </button>
                </div>
            </div>
        </form>
        <hr>
        <x-table route="{{ route('punishment.json') }}" pagination="ajax">
            <x-slot name="columns">
                <th data-field="federation_name" data-width="10">
                    Federasyon/Branş
                </th>
                <th data-field="type" data-formatter="setText" data-width="10">
                    {{ __('peoples.type') }}
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
