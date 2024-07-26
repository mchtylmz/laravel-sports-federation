@extends('layouts.auth')

@section('content')
    <!-- Sign In Section -->
    <div class="bg-body-extra-light">
        <div class="login-card py-4 px-5" style="background-color: rgba(89,109,124)">
            <h2 class="fw-medium px-0 px-sm-5 mb-0 text-white">{!! settings()->login_title ?? '' !!}</h2>
        </div>
        <div class="content content-full">
            <div class="row g-0 justify-content-center">
                <div class="col-12 col-md-5 col-lg-5 col-xl-5 py-3 px-3 px-lg-3 text-start">
                    <img src="{!! asset(settings()->login_logo3) !!}" alt="logo" class="w-100 p-3" style="max-height: 500px; object-fit: contain">
                </div>
                <div class="col-12 col-md-4 col-lg-4 col-xl-4 py-3 px-3 px-lg-3 text-center">
                    <!-- Header -->
                    <h1 class="px-sm-2 fw-medium text-center mb-3 pb-3" style="color: rgba(89,109,124)">
                        {!! settings()->login_subtitle ?? '' !!}
                    </h1>
                    <!-- END Header -->

                    <form class="js-validation-signin my-3 pb-3" action="{{ route('auth') }}" method="POST">
                        @csrf
                        <div class="py-3">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-lg form-control-alt" id="username" name="username" placeholder="{{ __('auth.login.username') }}" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password" placeholder="{{ __('auth.login.password') }}" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-6 col-xxl-5">
                                <button type="submit" class="btn w-100 btn-alt-primary mb-3">
                                    <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> {{ __('auth.login.submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- END Sign In Form -->

                    <div class="d-flex justify-content-around gap-2 mt-3 pt-3">
                        <!-- Header -->
                        <div class="text-center mb-2">
                            <p class="mb-1">
                                <img src="{!! asset(settings()->login_logo1) !!}" class="login-logo" alt="Logo" style="max-width: 112px">
                            </p>
                        </div>
                        <!-- END Header -->
                        <!-- Header -->
                        <div class="text-center mb-2">
                            <p class="mb-1">
                                <img src="{!! asset(settings()->login_logo2) !!}" class="login-logo" alt="Logo" style="max-width: 112px">
                            </p>
                        </div>
                        <!-- END Header -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END Sign In Section -->
@endsection
