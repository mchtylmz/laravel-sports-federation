@extends('layouts.app')

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-lg-6 p-5 text-center">
            <img style="max-width: 640px" src="{{ asset(settings()->home_logo) }}" onerror="this.src='{{ asset('uploads/no-img.png') }}'" class="w-100">
        </div>
    </div>

@endsection
