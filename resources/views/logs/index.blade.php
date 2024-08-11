@extends('layouts.app')
@section('content')

    <x-block title="{{ $title }}">
        <form class="js-filter-table">
            <div class="row align-items-end justify-content-start">
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="user_id">Kullanıcı</label>
                    <select class="selectpicker form-control" id="user_id" name="user_id" data-placeholder="Tüm Kullanıcılar" data-size="5" data-live-search="true">
                        <option value="">Tüm Kullanıcılar</option>
                        @foreach(users() as $user)
                            <option value="{{ $user->id }}">({{ $user->username }}) {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="log_type">İşlem</label>
                    <select class="selectpicker form-control" id="log_type" name="log_type" data-placeholder="Tüm İşlemler" data-size="5" data-live-search="true">
                        <option value="">Tüm İşlemler</option>
                        <option value="login">Login / Giriş</option>
                        <option value="logout">Logout / Çıkış</option>
                        <option value="create">Oluşturma / Ekleme</option>
                        <option value="edit">Düzenleme</option>
                        <option value="delete">Silme</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="table_name">Log Sınıfı</label>
                    <select class="selectpicker form-control" id="table_name" name="table_name" data-placeholder="Tüm Sınıflar" data-size="5" data-live-search="true">
                        <option value="">Tüm Sınıflar</option>
                        @foreach(trans('log.table') as $key => $value)
                            @if(!str_contains($value, '-'))
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="start_date">Başlangıç Tarihi</label>
                    <input type="text" class="js-flatpickr form-control" id="start_date" name="start_date" data-locale="tr" placeholder="YYYY-AA-GG" data-mode="range" readonly="readonly">
                </div>
                <div class="col-lg-2 mb-3">
                    <label class="form-label" for="end_date">Bitiş Tarihi</label>
                    <input type="text" class="js-flatpickr form-control" id="end_date" name="end_date" data-locale="tr" placeholder="YYYY-AA-GG" data-mode="range" readonly="readonly">
                </div>
                <div class="col-lg-2 mb-3">
                    <button type="submit" class="btn btn-alt-success w-100 js-filter-submit">
                        <i class="fa fa-fw fa-filter"></i> {{ __('table.filter') }}
                    </button>
                </div>
            </div>
        </form>
        <hr>

        <x-table route="{{ route('log.json') }}">
            <x-slot name="columns">
                <th data-field="username" data-sortable="true" data-width="15" data-align="left">
                    {{ __('table.username') }}
                </th>
                <th data-field="name" data-sortable="true" data-width="20" data-align="left">
                    {{ __('table.name') }}
                </th>
                <th data-field="table_name" data-sortable="true" data-width="10" data-align="left">
                    Log Sınıfı
                </th>
                <th data-field="log_type" data-sortable="true" data-width="10" data-align="left">
                    İşlem
                </th>
                <th data-field="log_date" data-sortable="true" data-width="10" data-align="left">
                    Tarih
                </th>
                <th data-field="ip" data-sortable="true" data-width="10" data-align="left">
                    IP
                </th>
                <th data-field="id" data-formatter="setActions">
                    {{ __('table.actions') }}
                </th>
            </x-slot>
        </x-table>
    </x-block>

@endsection
