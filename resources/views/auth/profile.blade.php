@extends('layouts.app')
@section('content')
    <div class="row">

        <div class="col-lg-6">
            <x-block title="{{ __('auth.profile.title') }}">
                <form class="js-validation-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.login.username') }}</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->username }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">{{ __('auth.profile.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('auth.profile.name') }}.." value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">{{ __('auth.profile.email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email.." value="{{ auth()->user()->email }}">
                    </div>
                    <div class="mb-4 text-end">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                        </button>
                    </div>
                </form>
            </x-block>
        </div>

        <div class="col-lg-6">
            <x-block title="{{ __('auth.changePassword.title') }}">
                <form class="js-validation-form" action="{{ route('profile.password') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label" for="password">
                                {{ __('auth.changePassword.newPassword') }}
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" placeholder="*******" name="password" autocomplete="off" required>
                                <button type="button" class="btn btn-dark" data-toggle="password">
                                    <i class="fa fa-eye mx-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label" for="password_confirmation">
                                {{ __('auth.changePassword.confirmPassword') }}
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" placeholder="*******" name="password_confirmation" autocomplete="off"  required>
                                <button type="button" class="btn btn-dark" data-toggle="password">
                                    <i class="fa fa-eye mx-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 text-end">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-save mx-2 fa-faw"></i>  {{ __('table.save') }}
                        </button>
                    </div>
                </form>
            </x-block>
        </div>
    </div>
@endsection
