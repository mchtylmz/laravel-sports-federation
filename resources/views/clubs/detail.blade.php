@extends('layouts.app')
@section('content')
    <x-block title="{{ $title }}">

        <form class="js-validation-form" action="{{ route('club.save', $club->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">{{ __('clubs.form.name') }}</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('clubs.form.name') }}.." value="{{ $club->name ?? '' }}" required>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="user_name">{{ __('clubs.form.user_name') }}</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="{{ __('clubs.form.user_name') }}.." value="{{ $club->user_name ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="user_phone">{{ __('clubs.form.user_phone') }}</label>
                        <input type="tel" class="form-control" id="user_phone" name="user_phone" placeholder="{{ __('clubs.form.user_phone') }}.." value="{{ $club->user_phone ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="user_email">{{ __('clubs.form.user_email') }}</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="{{ __('clubs.form.user_email') }}.." value="{{ $club->user_email ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="location">{{ __('clubs.form.location') }}</label>
                        <textarea id="location" class="form-control" name="location" placeholder="{{ __('clubs.form.location') }}..." rows="3">{{ $club->location ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="region">{{ __('clubs.form.region') }}</label>
                        <input type="text" class="form-control" id="region" name="region" placeholder="{{ __('clubs.form.region') }}.." value="{{ $club->region ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="status">{{ __('table.status') }}</label>
                <div class="space-x-2">
                    @php $status = $club->status?->value ?? 'active'; @endphp
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="radio" value="active" id="active" name="status" @checked($status == 'active')>
                        <label class="form-check-label" for="active">{{ __('table.active') }}</label>
                    </div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="radio" value="passive" id="passive" name="status" @checked($status == 'passive')>
                        <label class="form-check-label" for="passive">{{ __('table.passive') }}</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                @php $clubFederations = explode(',', ($club->federation_id ?? ''))@endphp
                <label class="form-label" for="federation_id">{{ __('table.federation') }} / Branş</label>
                <select class="selectpicker form-control" id="federation_id" name="federation_id[]" data-placeholder="{{ __('table.federation') }}...." data-size="10" data-live-search="true" multiple required>
                    @foreach(federations() as $federation)
                        <option value="{{ $federation->id }}" @selected(in_array($federation->id, $clubFederations))>{{ $federation->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
