@extends('layouts.app')
@section('content')

    <div class="row align-items-start mb-3">
        @foreach($clubs as $club)
            <div class="col-lg-4 mb-3">
                <div class="ms-2 me-auto bg-white p-3 border">
                    <h4 class="mb-1">{{ $club->name }}</h4>
                    Yetkili: {{ $club->user_name }} {{ $club->user_phone }}
                    <br> <strong class="status {{ $club->status->value }}">{{ __('table.' . $club->status->value) }}</strong>
                </div>
            </div>
        @endforeach
    </div>

@endsection
