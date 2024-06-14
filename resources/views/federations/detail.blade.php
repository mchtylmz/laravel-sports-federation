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

            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
