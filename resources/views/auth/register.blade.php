@extends('layouts.auth')

@section('content')
    <!-- Sign In Section -->
    <div class="bg-body-extra-light">
        <div class="login-card py-3 px-5" style="background-color: rgba(89,109,124)">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-9">
                    <h2 class="fw-medium px-0 px-sm-5 mb-0 text-white mb-0">{!! settings()->login_title ?? '' !!}</h2>
                </div>
                <div class="col-lg-3">
                    <h2 class="fw-medium px-0 px-sm-5 mb-0 text-white mb-0">{!! settings()->register_title ?? '' !!}</h2>
                </div>
            </div>
        </div>
        <div class="content content-full pt-2">

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center gap-3 py-4 mt-4">
                    <i class="fa fa-check-double mx-2 fa-2x fa-fw"></i>
                    <strong>{{ session('success') }}</strong>
                </div>
            @else

                <div class="row g-0 justify-content-center">
                    <div class="col-12 col-md-12 col-lg-12 py-2 px-3 px-lg-3">

                        <form class="js-validation-signin my-1 py-2" action="{{ route('register.save') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-2">
                                    <label class="form-label" for="federation_id">{{ __('table.federation') }} / Branş Seçiniz</label>
                                    <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="{{ __('table.federation') }}...." data-size="10" data-live-search="true" required>
                                        @foreach(federations() as $federation)
                                            <option value="{{ $federation->id }}">{{ $federation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-2 people-type-select" style="display: none">
                                    <label class="form-label" for="type">Kişi Tipi</label>
                                    <select class="selectpicker form-control" id="type" name="type" data-placeholder="Kişi Tipi Seçiniz..." data-size="5" data-live-search="true" required>
                                    </select>
                                </div>
                            </div>

                            <div class="row people-all" style="display: none">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="photo">Fotoğraf</label>
                                    <input type="file" class="dropify" id="photo" name="photo"
                                           data-show-remove="false"
                                           data-show-errors="true"
                                           data-allowed-file-extensions="jpg png jpeg"
                                           data-max-file-size="2M"
                                    />
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="license_no">Lisans No</label>
                                        <input type="text" class="form-control" id="license_no" name="license_no" placeholder="XXXXX..." required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="name">İsim</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="İsim.." required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="surname">Soyisim</label>
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyisim.." required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="phone">Telefon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Telefon..">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="email">E-posta Adresi</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="E-posta Adresi..">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="nationality">Uyruk</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Uyruğu..">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="identity">Pasaport/Kimlik Bilgisi</label>
                                        <input type="text" class="form-control" id="identity" name="identity" placeholder="Pasaport/Kimlik  Bilgisi.." required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="birth_place">Doğum Yeri</label>
                                        <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="Doğum Yeri..">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="birth_date">Doğum Tarihi</label>
                                        <input type="text" class="js-flatpickr form-control" id="birth_date" name="birth_date" data-locale="tr" placeholder="YYYY-AA-GG" data-max-date="{{ now()->subYears(6)->format('Y-m-d') }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-lg-4 d-none">
                                    <div class="mb-3 adult18">
                                        <label class="form-label" for="adult">Veli Onay Durumu</label>
                                        <select class="selectpicker form-control" id="adult" name="adult"  data-size="5" data-live-search="true">
                                            @foreach(\App\Enums\PeopleAdult::titles() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="father_name">Baba Adı</label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Baba Adı..">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3 adult18">
                                        <label class="form-label" for="gender">Cinsiyet</label>
                                        <select class="selectpicker form-control" id="gender" name="gender" data-placeholder="Cinsiyet Seçiniz..." data-size="5" data-live-search="false" required>
                                            @foreach(\App\Enums\Gender::titles() as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="licensed_at">Lisans Tarihi</label>
                                        <input type="text" class="js-flatpickr form-control" id="licensed_at" name="licensed_at" data-locale="tr" placeholder="YYYY-AA-GG" data-max-date="{{ now()->format('Y-m-d') }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="registered_at">Kayıt Tarihi</label>
                                        <input type="text" class="js-flatpickr form-control" id="registered_at" name="registered_at" data-locale="tr" placeholder="YYYY-AA-GG" data-max-date="{{ now()->format('Y-m-d') }}" readonly="readonly">
                                    </div>
                                </div>
                            </div>

                            <div class="row people-player" style="display: none">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="player_club_id">Kulüp</label>
                                        <select class="selectpicker form-control" id="player_club_id" name="player_club_id" data-placeholder="Kulüp Seçiniz...." data-size="5" data-live-search="true">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row people-referee" style="display: none">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="referee_class">Klasman</label>
                                        <input type="text" class="form-control" id="referee_class" name="referee_class" placeholder="Klasman Adı..">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="referee_region">Bölge</label>
                                        <input type="text" class="form-control" id="referee_region" name="referee_region" placeholder="Bölge Adı..">
                                    </div>
                                </div>
                            </div>

                            <div class="row people-coach" style="display: none">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="coach_class">Klasman</label>
                                        <input type="text" class="form-control" id="coach_class" name="coach_class" placeholder="Klasman Adı..">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="coach_job">Görevi</label>
                                        <input type="text" class="form-control" id="coach_job" name="coach_job" placeholder="Görevi..">
                                    </div>
                                </div>
                            </div>

                            <div class="row people-racer" style="display: none">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="racer_section">Yarışma Dalı</label>
                                        <input type="text" class="form-control" id="racer_section" name="racer_section" placeholder="Yarışma Dalı..">
                                    </div>
                                </div>
                            </div>

                            <div class="row people-school" style="display: none">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="school_club_id">Kulüp</label>
                                        <select class="selectpicker form-control" id="school_club_id" name="school_club_id" data-placeholder="Kulüp Seçiniz...." data-size="5" data-live-search="true">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="school_document">Öğrenci Belgesi</label>
                                        <input type="file" class="form-control" id="school_document" accept="application/pdf" name="school_document">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="school_name">Okulu</label>
                                        <input type="text" class="form-control" id="school_name" name="school_name" placeholder="Okulu..">
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-center mt-4 mb-0 pb-5 submit-div" style="display: none">
                                <div class="col-lg-3 col-xxl-3 col-8">
                                    <button type="submit" class="btn w-100 btn-alt-primary mb-0 submit-btn" disabled>
                                        <i class="fa fa-fw fa-user-plus me-1"></i> {{ __('auth.register.submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign In Form -->

                    </div>
                </div>

            @endif
        </div>
    </div>
    <!-- END Sign In Section -->
@endsection
@push('js')
    <script>
        $(document).on('change', 'select[name=federation_id]', function (e) {
            e.preventDefault();

            let typeSelectDiv = $('.people-type-select'),
                typeSelect = typeSelectDiv.find('select'),
                typeOptions = typeSelect.find('option');

            let playerClub = $('#player_club_id'),
                playerClubOptions = playerClub.find('option');

            let schoolClub = $('#school_club_id'),
                schoolClubOptions = schoolClub.find('option');

            typeSelectDiv.hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ route('register.federation.select') }}',
                data: {
                    id: $(this).val()
                },
                dataType: 'json',
                beforeSend: function () {
                    typeSelect.selectpicker('destroy');
                    playerClub.selectpicker('destroy');
                    schoolClub.selectpicker('destroy');
                    typeOptions.remove();
                },
                success: function (response) {
                    $.each(response.types, function (i, item) {
                        typeSelect.append($('<option>', {
                            value: item.value,
                            text : item.text
                        }));
                    });
                    $.each(response.clubs, function (i, item) {
                        playerClub.append($('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                        schoolClub.append($('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                    });

                    typeSelectDiv.show();
                    typeSelect.selectpicker();
                    playerClub.selectpicker();
                    schoolClub.selectpicker();
                },
                error: function (response) {
                    alert.fire({
                        text: 'İşleme devam edilemiyor, daha sonra tekrar deneyiniz!',
                        icon: 'error'
                    });
                }
            });
        });
        $(document).on('change', 'select[name=type]', function (e) {
            e.preventDefault();

            let peopleType = $(this).val();

            $('.people-player').hide();
            $('.people-referee').hide();
            $('.people-coach').hide();
            $('.people-racer').hide();
            $('.people-school').hide();

            $('.people-all').show();
            $('.people-' + peopleType).show();

            setTimeout(() => {
                $('.submit-div').show();
            }, 500)
        });
        $(document).on('change', '#license_no, #identity', function (e) {
            e.preventDefault();
            let btn = $('.submit-btn');

            if ($('#license_no').val() && $('#identity').val()) {
                btn.removeAttr('disabled')
            } else {
                btn.attr('disabled', 'disabled')
            }
        });
        $(document).on('change', 'input[name=birth_date]', function (e) {
            e.preventDefault();

            let birth_date = $(this).val(), adult = $('#adult');

            adult.selectpicker('destroy');

            if (calculateAge(birth_date, 18)) {
                adult.find('option[value="0"]').removeAttr('hidden', 'hidden');
                adult.find('option[value="1"]').attr('hidden', 'hidden');
                adult.find('option[value="2"]').attr('hidden', 'hidden');
                adult.removeAttr('required', 'required');
                adult.selectpicker();
                adult.selectpicker('val', '0');

                return true;
            }

            adult.find('option[value="0"]').attr('hidden', 'hidden');
            adult.find('option[value="1"]').removeAttr('hidden', 'hidden');
            adult.find('option[value="2"]').removeAttr('hidden', 'hidden');
            adult.attr('required', 'required');
            adult.selectpicker();
            adult.selectpicker('val', '');
        });
    </script>
@endpush
