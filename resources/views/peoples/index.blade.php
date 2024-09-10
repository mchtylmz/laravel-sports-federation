@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        @if(hasRole('admin') || (hasRole('superadmin') && !userPermit(['mudur', 'muafiyet'])))
            <a type="button" class="btn btn-info" href="{{ route('people.show') }}">
                <i class="fa fa-fw fa-plus"></i> {{ __('peoples.add') }}
            </a>
        @endif
    </div>

    <x-block title="{{ $title }}">
        <form class="js-filter-table">
            <div class="row align-items-end justify-content-start">
                @if(hasRole('superadmin'))
                    <div class="col-lg-3 mb-3">
                        <label class="form-label" for="federation_id">Federasyon / Branş</label>
                        <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="Tüm Federasyonlar / Branşlar" data-size="5" data-live-search="true">
                            <option value="">Tüm Federasyonlar / Branşlar</option>
                            @foreach(federations() as $federation)
                                <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="type">Kişi Tpi</label>
                    <select class="selectpicker form-control" id="type" name="type" data-placeholder="Kişi Tpi Seçiniz...." data-size="5" data-live-search="true">
                        @if(permitIf(role(), ['mudur']))
                            <option value="">{{ __('table.all') }}</option>
                            @foreach(\App\Enums\PeopleType::titles() as $key => $value)
                                @if(hasRole('admin'))
                                    @if(in_array($key, user()?->federation()->people_types_json ?? []))
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endif
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        @else
                            <option value="{{ \App\Enums\PeopleType::racer }}">{{ \App\Enums\PeopleType::racer->title() }}</option>
                        @endif
                    </select>
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
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="gender">Cinsiyet</label>
                    <select class="selectpicker form-control" id="gender" name="gender" data-placeholder="Cinsiyet Seçiniz...." data-size="5" data-live-search="true">
                        <option value="">{{ __('table.all') }}</option>
                        @foreach(\App\Enums\Gender::titles() as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="racer_document">Muafiyet</label>
                    <select class="selectpicker form-control" id="racer_document" name="racer_document" data-placeholder="Muafiyet Seçiniz...." data-size="5" data-live-search="true">
                        <option value="">{{ __('table.all') }}</option>
                        <option value="Evet">Evet</option>
                        <option value="Hayır">Hayır</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="license_no">Lisans No</label>
                    <input type="text" class="form-control" id="license_no" name="license_no" placeholder="XXX..">
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="identity">Pasaport/Kimlik</label>
                    <input type="text" class="form-control" id="identity" name="identity" placeholder="XXX..">
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="racer_car_no">Araç Şasi No</label>
                    <input type="text" class="form-control" id="racer_car_no" name="racer_car_no" placeholder="XXX..">
                </div>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="birth_date">Doğum Tarihi</label>
                    <input type="text" class="daterangepicker form-control mt-0" style="position: unset !important;" placeholder="GG-AA-YYYY" autocomplete="off" id="birth_date" name="birth_date">
                </div>
                <div class="col-lg-2 mb-3">
                    <button type="submit" class="btn btn-alt-success w-100 js-filter-submit">
                        <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                    </button>
                </div>
            </div>

            <input type="hidden" name="status_type" value="{{ $status_type ?? 1 }}">
        </form>
        <hr>

        <x-table route="{{ route('people.json') }}">
            <x-slot name="columns">
                <th data-field="federation_name" data-width="10">
                    Federasyon/Branş
                </th>
                <th data-field="license_no" data-width="5" data-sortable="true" data-align="left">
                    {{ __('peoples.license_no') }}
                </th>
                <th data-field="type" data-formatter="setText" data-width="5">
                    {{ __('peoples.type') }}
                </th>
                <th data-field="photo" data-formatter="setImage" data-width="5">
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
                <!--
                <th data-field="gender" data-formatter="setText" data-sortable="true">
                    {{ __('table.gender') }}
                </th>
                -->
                @if(permitIf(role(), ['muafiyet']))
                    <th data-field="racer_document" data-sortable="true">
                        Muafiyet
                    </th>
                @endif
                <th data-field="status" data-formatter="setText" data-sortable="true">
                    {{ __('table.status') }}
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
