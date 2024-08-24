@extends('layouts.app')
@section('content')
    <x-block title="{{ $title }}">

        <form class="js-validation-form" action="{{ route('federation.save', $federation->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="logo">Federasyon Logo</label>
                <input type="file" class="dropify" id="logo" name="logo"
                       data-show-remove="false"
                       data-show-errors="true"
                       data-allowed-file-extensions="jpg png jpeg"
                       data-max-file-size="3M"
                       @if(!empty($federation->logo)) data-default-file="{{ asset($federation->logo) }}" @endif
                />
            </div>

            <div class="mb-3">
                <label class="form-label" for="name">Federasyon Adı</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Federasyon Adı.." value="{{ $federation->name ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="document_number">Federasyon Dosya No</label>
                <input type="text" class="form-control" id="document_number" name="document_number" placeholder="Federasyon Dosya No.." value="{{ $federation->document_number ?? '' }}">
            </div>

            <div class="mb-3 d-none">
                <label class="form-label" for="branch_number">Branş Dosya No Liste</label>
                <input type="text" class="form-control" id="branch_number" name="branch_number" placeholder="Branş Dosya No Liste.." value="{{ $federation->branch_number ?? '' }}">
            </div>

            <div class="mb-3">
                <label class="form-label" for="is_special">Özerk Durumu</label>
                <select class="selectpicker form-control" id="is_special" name="is_special" required>
                    <option value="0" @selected($federation->is_special == 0)>Özerk Değil, Hayır</option>
                    <option value="1" @selected($federation->is_special == 1)>Özerk, Evet</option>
                </select>
            </div>

            <div class="mb-3 d-none">
                <label class="form-label" for="website">Website Linki</label>
                <input type="text" class="form-control" id="website" name="website" placeholder="Website Linki.." value="{{ $federation->website ?? '' }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Bilgi Bankası Kişi Tipleri</label>
                <div class="people_types">
                    @foreach(\App\Enums\PeopleType::titles() as $key => $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="type_{{ $key }}" value="{{ $key }}" name="people_types[]" multiple @checked(in_array($key, $federation->people_types_json ?? []))>
                            <label class="form-check-label" for="type_{{ $key }}">{{ $value }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
