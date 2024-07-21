@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <a type="button" class="btn btn-info" href="{{ route('people.show') }}">
            <i class="fa fa-fw fa-plus"></i> {{ __('peoples.add') }}
        </a>
    </div>

    <x-block title="{{ $title }}">
        <form class="js-filter-table">
            <div class="row align-items-end justify-content-start">
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="type">Kişi Tpi</label>
                    <select class="selectpicker form-control" id="type" name="type" data-placeholder="Kişi Tpi Seçiniz...." data-size="5" data-live-search="true">
                        <option value="">{{ __('table.all') }}</option>
                        @foreach(\App\Enums\PeopleType::titles() as $key => $title)
                            <option value="{{ $key }}">{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="license_no">Lisans No</label>
                    <input type="text" class="form-control" id="license_no" name="license_no" placeholder="XXX..">
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="club_id">Kulüp</label>
                    <select class="selectpicker form-control" id="club_id" name="club_id" data-placeholder="Kulüp Seçiniz...." data-size="5" data-live-search="true">
                        <option value="">{{ __('table.all') }}</option>
                        @foreach(clubs() as $club)
                            <option value="{{ $club->id }}">{{ $club->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="gender">Cinsiyet</label>
                    <select class="selectpicker form-control" id="gender" name="gender" data-placeholder="Cinsiyet Seçiniz...." data-size="5" data-live-search="true">
                        <option value="">{{ __('table.all') }}</option>
                        @foreach(\App\Enums\Gender::titles() as $key => $title)
                            <option value="{{ $key }}">{{ $title }}</option>
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

        <x-table route="{{ route('people.json') }}">
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
                <th data-field="gender" data-formatter="setText" data-sortable="true">
                    {{ __('table.gender') }}
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
