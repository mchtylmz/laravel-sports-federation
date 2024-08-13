@extends('layouts.app')
@section('content')
    <x-block title="{{ $title }}">

        <form class="js-validation-form" action="{{ route('punishment.save', $punishment->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="people_id">Kişi Seç</label>
                <select class="selectpicker form-control" id="people_id" name="people_id" data-placeholder="Kişi Seç...." data-size="5" data-live-search="true" required>
                    @if($peoples = peoples()))
                        @foreach($peoples as $people)
                            <option value="{{ $people->id }}" @selected($punishment->people_id == $people->id)>{{ $people->fullname }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="reason">Ceza sebebi</label>
                <input type="text" class="form-control" id="reason" name="reason" placeholder="Ceza sebebi.." value="{{ $punishment->reason ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Aldığı Ceza</label>
                <textarea id="description" class="form-control" name="description" placeholder="Aldığı Ceza..." rows="3">{{ $punishment->description ?? '' }}</textarea>
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
