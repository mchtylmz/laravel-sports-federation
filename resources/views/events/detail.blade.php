@extends('layouts.app')
@section('content')
    <x-block title="{{ $title }}">

        <form class="js-validation-form" action="{{ route('event.save', $event->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="title">{{ __('events.event') }} {{ __('events.form.title') }}</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="{{ __('events.event') }} {{ __('events.form.title') }}.." value="{{ $event->title ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="content">{{ __('events.event') }} {{ __('events.form.content') }}</label>
                <textarea id="content" class="form-control" name="content" placeholder="{{ __('events.form.content') }}..." rows="3">{{ $event->content ?? '' }}</textarea>
            </div>

            @if(hasRole('admin', 'superadmin'))
                <div class="mb-3">
                    <label class="form-label" for="location">{{ __('events.event') }} {{ __('events.form.location') }}</label>
                    <textarea id="content" class="form-control" name="location" placeholder="{{ __('events.form.location') }}..." rows="2" required>{{ $event->location ?? '' }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="end_time">{{ __('events.event') }} {{ __('events.form.is_national') }}</label>
                    <div class="space-x-2">
                        <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input" type="radio" value="1" id="is_national1" name="is_national" @checked($event->is_national ?? false)>
                            <label class="form-check-label" for="is_national1">Uluslar Arası</label>
                        </div>
                        <div class="form-check form-switch form-check-inline">
                            <input class="form-check-input" type="radio" value="0" id="is_national0" name="is_national" @checked($event->is_national ?? true)>
                            <label class="form-check-label" for="is_national0">Yerel</label>
                        </div>
                    </div>
                </div>
            @elseif(hasRole('manager'))
                <div class="mb-4">
                    <label class="form-label" for="location">{{ __('events.event') }} {{ __('events.form.location') }}</label>
                    <select class="selectpicker form-control" id="location" name="location" data-placeholder="{{ __('events.form.location') }}...." data-size="5" data-live-search="true" required>
                        @if($places = json_decode(user()?->getMeta('places')))
                            @foreach($places as $place)
                                <option value="{{ $place }}" @selected($place == $event->location)>{{ $place }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-7 mb-3">
                    <label class="form-label" for="start_date">{{ __('events.event') }} {{ __('events.form.start_date') }}</label>
                    <input type="text" class="js-flatpickr form-control" id="start_date" name="start_date" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $event->start_date ?? now()->format('Y-m-d') }}" readonly="readonly" required>
                </div>
                <div class="col-lg-5 mb-3">
                    <label class="form-label" for="start_time">{{ __('events.event') }} {{ __('events.form.start_time') }}</label>
                    <input type="text" class="js-flatpickr form-control" id="start_time" name="start_time"  data-locale="tr" placeholder="SS:DD" data-enable-time="true" data-no-calendar="true" data-date-format="H:i" data-time_24hr="true" value="{{ $event->start_time ?? now()->format('H:00') }}" readonly="readonly">
                </div>

                <div class="col-lg-7 mb-3">
                    <label class="form-label" for="end_date">{{ __('events.event') }} {{ __('events.form.end_date') }}</label>
                    <input type="text" class="js-flatpickr form-control" id="end_date" name="end_date" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $event->end_date ?? now()->format('Y-m-d') }}" readonly="readonly" required>
                </div>
                <div class="col-lg-5 mb-3">
                    <label class="form-label" for="end_time">{{ __('events.event') }} {{ __('events.form.end_time') }}</label>
                    <input type="text" class="js-flatpickr form-control" id="end_time" name="end_time"  data-locale="tr" placeholder="SS:DD" data-enable-time="true" data-no-calendar="true" data-date-format="H:i" data-time_24hr="true" value="{{ $event->end_time ?? now()->format('H:i') }}" readonly="readonly">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="end_notes">{{ __('events.event') }} {{ __('events.form.end_notes') }}</label>
                <textarea id="content" class="form-control" name="end_notes" placeholder="{{ __('events.form.end_notes') }}..." rows="3">{{ $event->end_notes ?? '' }}</textarea>
            </div>

            <div class="mb-4 text-center">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
