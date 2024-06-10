@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">

        <x-block title="{{ __('settings.general') }}">
            <form class="js-validation-form" action="{{ route('profile.password') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
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
                <div class="row mb-4">
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
                        <i class="fa fa-save mx-2 fa-faw"></i> Update
                    </button>
                </div>
            </form>
        </x-block>

    </div>
    <!-- END Page Content -->
@endsection
