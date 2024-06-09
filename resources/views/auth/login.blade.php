@extends('layouts.auth')

@section('content')
    <!-- Sign In Section -->
    <div class="bg-body-extra-light">
        <div class="content content-full">
            <div class="row g-0 justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4 py-4 px-4 px-lg-5">
                    <!-- Header -->
                    <div class="text-center mb-3">
                        <p class="mb-2">
                            <img src="{!! asset(settings()->site_logo ?? 'uploads/logo.png') !!}" class="login-logo" alt="Logo">
                        </p>
                    </div>
                    <!-- END Header -->

                    <form class="js-validation-signin" action="{{ route('auth') }}" method="POST">
                        @csrf
                        <div class="py-3">
                            <div class="mb-4">
                                <input type="text" class="form-control form-control-lg form-control-alt" id="username" name="username" placeholder="{{ __('auth.login.username') }}" autocomplete="off" required>
                            </div>
                            <div class="mb-4">
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
                </div>
            </div>
        </div>
    </div>
    <!-- END Sign In Section -->
@endsection
