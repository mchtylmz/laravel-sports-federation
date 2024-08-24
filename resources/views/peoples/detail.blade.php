@extends('layouts.app')
@section('content')
    @php
    //$muafiyet = hasRole('superadmin') && userPermit(['muafiyet']);
    $muafiyet = hasRole('superadmin');
    @endphp

    <x-block title="{{ $title }}">

        <form class="js-validation-form" action="{{ route('people.save', $people->id ?? '') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if(hasRole('superadmin'))
                <div class="mb-3">
                    <label class="form-label" for="federation_id">{{ __('table.federation') }} / Branş</label>
                    <select class="selectpicker form-control" id="federation_id" name="federation_id" data-placeholder="{{ __('table.federation') }}...." data-size="10" data-live-search="true" required>
                        @foreach(federations() as $federation)
                            <option value="{{ $federation->id }}" @selected($people->federation_id == $federation->id)>{{ $federation->name }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="federation_id" value="{{ user()->federation()?->id }}">
            @endif

            <div class="mb-0">
                <label class="form-label" for="type">Kişi Tipi</label>
                <select class="selectpicker form-control" id="type" name="type" data-placeholder="Kişi Tipi Seçiniz..." data-size="5" data-live-search="true" required>
                    @foreach(\App\Enums\PeopleType::titles() as $key => $value)
                        @if(hasRole('admin'))
                            @if(in_array($key, user()?->federation()->people_types_json ?? []))
                            <option value="{{ $key }}" @selected($key == $people->type?->value)>{{ $value }}</option>
                           @endif
                        @elseif(hasRole('superadmin') && userPermit(['muafiyet']))
                            @if($key == \App\Enums\PeopleType::racer->value)
                                <option value="{{ $key }}" @selected($key == $people->type?->value)>{{ $value }}</option>
                            @endif
                        @else
                            <option value="{{ $key }}" @selected($key == $people->type?->value)>{{ $value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="row people-all">
                <div class="col-lg-12"><hr></div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="photo">Fotoğraf</label>
                        <input type="file" class="dropify" id="photo" name="photo"
                               data-show-remove="false"
                               data-show-errors="true"
                               data-allowed-file-extensions="jpg png jpeg"
                               data-max-file-size="2M"
                               @if($people->photo) data-default-file="{{ asset($people->photo) }}" @endif
                        />
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="license_no">Lisans No</label>
                        <input type="text" class="form-control" id="license_no" name="license_no" placeholder="XXXXX..." value="{{ $people->license_no ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="name">İsim</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="İsim.." value="{{ $people->name ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="surname">Soyisim</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyisim.." value="{{ $people->surname ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="phone">Telefon</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Telefon.." value="{{ $people->phone ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="email">E-posta Adresi</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="E-posta Adresi.." value="{{ $people->email ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="nationality">Uyruğu</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Uyruğu.." value="{{ $people->nationality ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="identity">Pasaport/Kimlik Bilgisi</label>
                        <input type="text" class="form-control" id="identity" name="identity" placeholder="Pasaport/Kimlik  Bilgisi.." value="{{ $people->identity ?? '' }}" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="birth_place">Doğum Yeri</label>
                        <input type="text" class="form-control" id="birth_place" name="birth_place" placeholder="Doğum Yeri.." value="{{ $people->birth_place ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="birth_date">Doğum Tarihi</label>
                        <input type="text" class="js-flatpickr form-control" id="birth_date" name="birth_date" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $people->birth_date?->format('Y-m-d') ?? '' }}" readonly="readonly">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3 adult18">
                        <label class="form-label" for="adult">Veli Onay Durumu</label>
                        <select class="selectpicker form-control" id="adult" name="adult"  data-size="5" data-live-search="true">
                            @foreach(\App\Enums\PeopleAdult::titles() as $key => $value)
                                <option value="{{ $key }}" @selected($key == $people->adult?->value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="father_name">Baba Adı</label>
                        <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Baba Adı.." value="{{ $people->father_name ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3 adult18">
                        <label class="form-label" for="gender">Cinsiyet</label>
                        <select class="selectpicker form-control" id="gender" name="gender" data-placeholder="Cinsiyet Seçiniz..." data-size="5" data-live-search="true" required>
                            @foreach(\App\Enums\Gender::titles() as $key => $value)
                                <option value="{{ $key }}" @selected($key == $people->gender?->value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="licensed_at">Lisans Tarihi</label>
                        <input type="text" class="js-flatpickr form-control" id="licensed_at" name="licensed_at" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $people->licensed_at?->format('Y-m-d') ?? '' }}" readonly="readonly">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="registered_at">Kayıt Tarihi</label>
                        <input type="text" class="js-flatpickr form-control" id="registered_at" name="registered_at" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $people->registered_at?->format('Y-m-d') ?? '' }}" readonly="readonly">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3 adult18">
                        <label class="form-label" for="status">Durum</label>
                        <select class="selectpicker form-control" id="status" name="status" data-placeholder="Durum Seçiniz..." data-size="5" data-live-search="true" required>
                            @foreach(\App\Enums\Status::titles() as $key => $value)
                                @if(!hasRole('superadmin') && $key == 'pending')
                                    @continue
                                @endif
                                <option value="{{ $key }}" @selected($key == $people->status?->value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row people-player" style="display: none">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label" for="player_club_id">Kulüp</label>
                        <select class="selectpicker form-control" id="player_club_id" name="player_club_id" data-placeholder="Kulüp Seçiniz...." data-size="5" data-live-search="true">
                            @if(hasRole('superadmin'))
                                @foreach(clubs() as $club)
                                    <option value="{{ $club->id }}" @selected($club->id == $people->getMeta('player_club_id'))>{{ $club->name }}</option>
                                @endforeach
                            @elseif(hasRole('admin'))
                                @foreach(federation_clubs(user()?->federation()?->id) as $club)
                                    <option value="{{ $club->id }}" @selected($club->id == $people->getMeta('player_club_id'))>{{ $club->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="row people-referee" style="display: none">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="referee_class">Klasman</label>
                        <input type="text" class="form-control" id="referee_class" name="referee_class" placeholder="Klasman Adı.." value="{{ $people->getMeta('referee_class') ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="referee_region">Bölge</label>
                        <input type="text" class="form-control" id="referee_region" name="referee_region" placeholder="Bölge Adı.." value="{{ $people->getMeta('referee_region') ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="row people-coach" style="display: none">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="coach_class">Klasman</label>
                        <input type="text" class="form-control" id="coach_class" name="coach_class" placeholder="Klasman Adı.." value="{{ $people->getMeta('coach_class') ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label" for="coach_job">Görevi</label>
                        <input type="text" class="form-control" id="coach_job" name="coach_job" placeholder="Görevi.." value="{{ $people->getMeta('coach_job') ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="row people-racer" style="display: none">
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label" for="racer_section">Yarışma Dalı</label>
                        <input type="text" class="form-control" id="racer_section" name="racer_section" placeholder="Yarışma Dalı.." value="{{ $people->getMeta('racer_section') ?? '' }}">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        @php $racer_document = $people->getMeta('racer_document'); @endphp
                        <label class="form-label" for="racer_document">Muafiyet Belgesi</label>
                        <select class="selectpicker form-control" id="racer_document" name="racer_document" data-placeholder="Seçiniz..." data-size="5" data-live-search="true" @disabled(!$muafiyet)>
                            @foreach(['Evet', 'Hayır'] as $value)
                                <option value="{{ $value }}" @selected($value == $racer_document)>{{ $value }}</option>
                            @endforeach
                        </select>
                        @if(!$muafiyet)
                            <small><i class="fas fa-times"></i> Düzenleme yapılamaz</small>
                        @endif
                    </div>

                    <div class="mb-3 racer_document_file" style="display: none">
                        @php
                            $racer_document_file = $people->getMeta('racer_document_file');
                            $explode = explode('/', $racer_document_file);
                        @endphp
                        <label class="form-label" for="racer_document">Muafiyet Belgesi</label>
                        <input type="file" class="form-control" name="racer_document_file" accept=".pdf,.xls,.xlsx,.doc,.docx">
                        @if($racer_document_file)
                            <a target="_blank" class="border text-dark w-100"
                               href="{{ asset($racer_document_file) }}">
                                <strong>{{ $explode[count($explode) - 1] ?? $racer_document_file }}</strong>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label" for="racer_car_brand">Araç Markası</label>
                        <input type="text" class="form-control" id="racer_car_brand" name="racer_car_brand" placeholder="Araç Markası.." value="{{ $people->getMeta('racer_car_brand') ?? '' }}" @disabled(!$muafiyet)>
                    </div>
                    @if(!$muafiyet)
                        <small><i class="fas fa-times"></i> Düzenleme yapılamaz</small>
                    @endif
                </div>
                <div class="col-lg-3">
                    <div class="mb-3">
                        <label class="form-label" for="racer_car_no">Araç Şasi No</label>
                        <input type="text" class="form-control" id="racer_car_no" name="racer_car_no" placeholder="Araç Şasi No.." value="{{ $people->getMeta('racer_car_no') ?? '' }}" @disabled(!$muafiyet)>
                    </div>
                    @if(!$muafiyet)
                        <small><i class="fas fa-times"></i> Düzenleme yapılamaz</small>
                    @endif
                </div>
            </div>

            <div class="row people-school" style="display: none">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="school_club_id">Kulüp</label>
                        <select class="selectpicker form-control" id="school_club_id" name="school_club_id" data-placeholder="Kulüp Seçiniz...." data-size="5" data-live-search="true">
                            @if(hasRole('superadmin'))
                                @foreach(clubs() as $club)
                                    <option value="{{ $club->id }}" @selected($club->id == $people->getMeta('school_club_id'))>{{ $club->name }}</option>
                                @endforeach
                            @elseif(hasRole('admin'))
                                @foreach(federation_clubs(user()?->federation()?->id) as $club)
                                    <option value="{{ $club->id }}" @selected($club->id == $people->getMeta('school_club_id'))>{{ $club->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="school_document">Öğrenci Belgesi</label>
                        <input type="file" class="form-control" id="school_document" accept="application/pdf" name="school_document">
                        @if($school_doc = $people->getMeta('school_document'))
                            <small><a target="_blank" href="{{ $school_doc }}">{{ $school_doc }}</a></small>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="school_name">Okulu</label>
                        <input type="text" class="form-control" id="school_name" name="school_name" placeholder="Okulu.." value="{{ $people->getMeta('school_name') ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="my-4 text-center submit">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>

    </x-block>
@endsection
@push('js')
    <script>
        function racer_document_file($this) {
            let value = $this.val();

            if (value === 'Evet') {
                $('.racer_document_file').show();
            } else {
                $('.racer_document_file').hide();
            }
        }

        $(document).ready(function() {
            $('select[name=type]').trigger('change');
            $('input[name=birth_date]').trigger('change');
        });
        $(document).on('change', 'select[name=type]', function (e) {
            e.preventDefault();

            let peopleType = $(this).val();

            $('.people-player').hide();
            $('.people-referee').hide();
            $('.people-coach').hide();
            $('.people-racer').hide();
            $('.people-school').hide();

            $('.people-' + peopleType).show();
        });
        $(document).on('change', 'select[name=racer_document]', function (e) {
            e.preventDefault();

            racer_document_file($(this));
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
    @if($racer_document == 'Evet')
        <script>
            $(document).ready(function() {
                racer_document_file($('#racer_document'));
            });
        </script>
    @endif
@endpush
