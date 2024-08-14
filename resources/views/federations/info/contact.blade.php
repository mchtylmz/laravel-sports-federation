@extends('layouts.app')
@section('content')

    <x-block title="{{ $title }}">
        <form class="js-validation-form" action="{{ route('federation.info.contact.save', $federation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="fullname">Federasyon Adı</label>
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
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="fax">Fax</label>
                        <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax..." value="{{ $federation->getMeta('fax') }}">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="website">Website</label>
                        <input type="text" class="form-control" id="website" name="website" placeholder="Website..." value="{{ $federation->getMeta('website') }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="facebook">
                            <i class="fab fa-facebook-square me-2 fa-fw"></i> Facebook
                        </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="facebook">facebook.com/</span>
                            <input type="text" class="form-control" id="facebook" name="facebook" placeholder="..." value="{{ $federation->getMeta('social_facebook') }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="x">
                            <i class="fab fa-x me-2 fa-fw"></i> X (Twitter)
                        </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="x">twitter.com/</span>
                            <input type="text" class="form-control" id="x" name="x" placeholder="..." value="{{ $federation->getMeta('social_x') }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="instagram">
                            <i class="fab fa-instagram me-2 fa-fw"></i> Instagram
                        </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="instagram">instagram.com/</span>
                            <input type="text" class="form-control" id="instagram" name="instagram" placeholder="..." value="{{ $federation->getMeta('social_instagram') }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="youtube">
                            <i class="fab fa-youtube me-2 fa-fw"></i> Youtube
                        </label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="youtube">youtube.com/</span>
                            <input type="text" class="form-control" id="youtube" name="youtube" placeholder="..." value="{{ $federation->getMeta('social_youtube') }}">
                        </div>
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
