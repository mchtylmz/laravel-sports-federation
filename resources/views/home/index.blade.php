@extends('layouts.app')

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-lg-6 p-5">
            <img src="{{ asset($site_logo) }}" onerror="this.src='{{ asset('uploads/no-img.png') }}'" class="w-100">
        </div>
    </div>

@endsection
