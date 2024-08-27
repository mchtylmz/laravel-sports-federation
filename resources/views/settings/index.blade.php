@extends('layouts.app')
@section('content')
    <x-block title="{{ __('settings.general') }}">
        <form class="js-validation-form" action="{{ route('settings.save') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="site_favicon">Site Favicon</label>
                        <input type="file" class="dropify" id="site_favicon" name="images[site_favicon]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset($site_favicon) }}"
                        />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="site_logo">Site Logo</label>
                        <input type="file" class="dropify" id="site_logo" name="images[site_logo]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset($site_logo) }}"
                        />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="home_logo">Anasyafa Logo</label>
                        <input type="file" class="dropify" id="home_logo" name="images[home_logo]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset(settings()->home_logo) }}"
                        />
                    </div>
                </div>

            </div>

            <div class="mb-3">
                <label class="form-label" for="site_title">Site Başlığı</label>
                <input type="text" class="form-control" id="site_title" name="settings[site_title]" placeholder="Başlığı.." value="{{ $site_title }}" required>
            </div>


           <div class="row align-items-start">
               <div class="col-lg-6">
                   <div class="mb-3">
                       <label class="form-label" for="phone">Telefon Numarası</label>
                       <input type="text" class="form-control" id="phone" name="settings[phone]" placeholder="Telefon.." value="{{ settings()->phone ?? '' }}">
                   </div>
                   <div class="mb-3">
                       <label class="form-label" for="email">Email Adresi</label>
                       <input type="text" class="form-control" id="email" name="settings[email]" placeholder="Email.." value="{{ settings()->email ?? '' }}">
                   </div>
               </div>
               <div class="col-lg-6">
                   <div class="mb-3">
                       <label class="form-label" for="address">Adres</label>
                       <textarea rows="4" class="form-control" id="address" name="settings[address]" placeholder="Adres..">{{ settings()->address }}</textarea>
                   </div>
               </div>
           </div>

            <div class="mb-3">
                <label class="form-label" for="header_under_text">Kayan Yazı</label>
                <textarea rows="6" class="form-control" id="header_under_text" name="settings[header_under_text]" placeholder="Kayan Yazı..">{{ $header_under_text }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="term_content">Kayıt Ol Onaylama Yazısı</label>
                <textarea rows="6" class="form-control" id="term_content" name="settings[term_content]" placeholder="Onaylama Yazı..">{{ settings()->term_content ?? '' }}</textarea>
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label" for="register_title">Kayıt Ol Ana Başlık</label>
                <input type="text" class="form-control" id="register_title" name="settings[register_title]" placeholder="Başlığı.." value="{{ settings()->register_title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="login_title">Giriş Yap Ana Başlık</label>
                <input type="text" class="form-control" id="login_title" name="settings[login_title]" placeholder="Başlığı.." value="{{ settings()->login_title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="login_subtitle">Giriş Yap Alt Başlık</label>
                <input type="text" class="form-control" id="login_subtitle" name="settings[login_subtitle]" placeholder="Başlığı.." value="{{ settings()->login_subtitle }}" required>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="login_logo1">Giriş Yap Form Alt Logo 1</label>
                        <input type="file" class="dropify" id="login_logo1" name="images[login_logo1]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset(settings()->login_logo1) }}"
                        />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="login_logo2">Giriş Yap Form Alt Logo 2</label>
                        <input type="file" class="dropify" id="login_logo2" name="images[login_logo2]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset(settings()->login_logo2) }}"
                        />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="login_logo3">Giriş Yap Sol Resim</label>
                        <input type="file" class="dropify" id="login_logo3" name="images[login_logo3]"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="3M"
                               data-default-file="{{ asset(settings()->login_logo3) }}"
                        />
                    </div>
                </div>
            </div>


            <div class="mb-4 text-center">

                @if(userPermit(['mudur']))
                    <button type="button" class="btn btn-alt-primary px-4" disabled>
                        <i class="fa fa-close mx-2 fa-faw"></i> {{ __('table.save') }}
                    </button>
                @else
                    <button type="submit" class="btn btn-alt-primary px-4">
                        <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                    </button>
                @endif
            </div>
        </form>
    </x-block>
@endsection
