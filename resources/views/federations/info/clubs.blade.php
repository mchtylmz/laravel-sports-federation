@extends('layouts.app')
@section('content')

    <div class="row">
        @foreach($clubs as $club)
            <div class="col-lg-3">
                <div class="ms-2 me-auto bg-white p-3 border">
                    <h4 class="mb-1">{{ $club->name }}</h4>
                    Yetkili: {{ $club->user_name }} {{ $club->user_phone }}
                </div>
            </div>
        @endforeach
    </div>

@endsection
