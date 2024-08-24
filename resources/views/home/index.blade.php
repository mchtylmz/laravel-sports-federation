@extends('layouts.app')

@section('content')

    <div class="row align-items-center justify-content-center">
        <div class="col-lg-6 p-3 text-center">
            <img style="height: 400px; width: 100%; object-fit: contain"
                 src="{{ asset(settings()->home_logo) }}"
                 onerror="this.src='{{ asset('uploads/no-img.png') }}'"
                 class="w-100">
        </div>
        <div class="col-lg-8">
            <div class="row justify-content-between align-items-start mt-1">
                @if($phone = settings()->phone)
                    <div class="col-lg-4 d-flex align-items-start mb-3">
                        <i class="fa fa-phone fa-fw me-2 mt-2"></i>
                        <h4 class="mb-0 text-start">
                            <small class="text-muted">Telefon </small> <br> {{ $phone }}
                        </h4>
                    </div>
                @endif
                @if($email = settings()->email)
                    <div class="col-lg-4 d-flex align-items-start mb-3">
                        <i class="fa fa-at fa-fw me-2 mt-2"></i>
                        <h4 class="mb-0 text-start">
                            <small class="text-muted">Email Adresi </small> <br> {{ $email }}
                        </h4>
                    </div>
                @endif
                @if($address = settings()->address)
                    <div class="col-lg-4 d-flex align-items-start mb-3">
                        <i class="fa fa-map fa-fw me-2 mt-2"></i>
                        <h4 class="mb-0 text-start">
                            <small class="text-muted">Adres </small> <br> {{ $address }}
                        </h4>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
