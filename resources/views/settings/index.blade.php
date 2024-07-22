@extends('layouts.app')
@section('content')
    <x-block title="{{ __('settings.general') }}">
        <form class="js-validation-form" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="site_favicon">Site Favicon</label>
                        <input type="file" class="dropify" id="site_favicon" name="images[site_favicon]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset($site_favicon) }}"
                        />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="site_logo">Site Logo</label>
                        <input type="file" class="dropify" id="site_logo" name="images[site_logo]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset($site_logo) }}"
                        />
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="site_title">Site Başlığı</label>
                <input type="text" class="form-control" id="site_title" name="settings[site_title]" placeholder="Başlığı.." value="{{ $site_title }}" required>
            </div>


            <div class="mb-3">
                <label class="form-label" for="header_under_text">Kayan Yazı</label>
                <textarea rows="6" class="form-control" id="header_under_text" name="settings[header_under_text]" placeholder="Kayan Yazı.." required>{{ $header_under_text }}</textarea>
            </div>


            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>
    </x-block>
@endsection
