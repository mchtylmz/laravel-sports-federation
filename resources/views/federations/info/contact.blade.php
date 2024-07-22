@extends('layouts.app')
@section('content')

    <x-block title="{{ $title }}">
        <form class="js-validation-form" action="{{ route('federation.info.contact.save', $federation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="fullname">Ad Soyad</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Ad Soyadd..." value="{{ $federation->getMeta('fullname') }}" required>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="phone">Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Telefon..." value="{{ $federation->getMeta('phone') }}">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email..." value="{{ $federation->getMeta('email') }}">
                    </div>
                </div>
            </div>

            <div class="my-3 text-center submit">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>
    </x-block>

@endsection
