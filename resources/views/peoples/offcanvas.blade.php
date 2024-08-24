@php
    $peoples = \App\Models\People::where('identity', $people->identity ?? 0)
        ->orWhere('id', $people->id)
        ->groupBy('type')
        ->get();

    $punishments = \App\Models\Punishment::whereIn('people_id', collect($peoples)->pluck('id')->all())
        ->latest()
        ->get();
@endphp
<div class="block border p-0">
    <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-5" id="btabs-people-tab" data-bs-toggle="tab" data-bs-target="#btabs-people" role="tab" aria-controls="btabs-people" aria-selected="false" tabindex="-1">Kişi Bilgileri</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-5" id="btabs-federations-tab" data-bs-toggle="tab" data-bs-target="#btabs-federations" role="tab" aria-controls="btabs-federations" aria-selected="true">Federasyonlar</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-5" id="btabs-punishment-tab" data-bs-toggle="tab" data-bs-target="#btabs-punishment" role="tab" aria-controls="btabs-punishment" aria-selected="true">Disiplin Cezaları</button>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        <div class="tab-pane active show" id="btabs-people" role="tabpanel" aria-labelledby="btabs-people" tabindex="0">
            <!--people -->
            <div class="row mb-0">
                <div class="col-lg-3 p-3 text-center">
                    <img src="{{ asset($people->photo) }}" alt="{{ $people->fullname }}" onerror="this.src='{{ asset('uploads/no-img.png') }}'" class="w-100" style="max-height: 240px; object-fit: contain" />
                </div>
                <div class="col-lg-9">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Kişi Tipi
                            <br> <strong>{{ $people->type?->title() }}</strong>
                        </li>
                        <li class="list-group-item">
                            Lisans No
                            <br> <strong>{{ $people->license_no }}</strong>
                        </li>
                        <li class="list-group-item">
                            İsim Soyisim
                            <br> <strong>{{ $people->fullname }}</strong>
                        </li>
                        <li class="list-group-item">
                            Uyruğu
                            <br> <strong>{{ $people->nationality }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="list-group list-group-flush mb-3 pb-3">
                <li class="list-group-item">
                    Telefon <br> <strong>{{ $people->phone }}</strong>
                </li>
                <li class="list-group-item">
                    E-posta Adresi <br> <strong>{{ $people->email }}</strong>
                </li>
                <li class="list-group-item">
                    Pasaport/Kimlik Bilgisi <br> <strong>{{ $people->identity }}</strong>
                </li>
                <li class="list-group-item">
                    Doğum Tarihi / Yeri <br> <strong>{{ $people->birth_date?->format('Y-m-d') }} / {{ $people->birth_place }}</strong>
                </li>
                <li class="list-group-item">
                    Veli Onay Durumu <br> <strong>{{ $people->adult?->title() }}</strong>
                </li>
                <li class="list-group-item">
                    Baba Adı <br> <strong>{{ $people->father_name }}</strong>
                </li>
                <li class="list-group-item">
                    Cinsiyet <br> <strong>{{ $people->gender?->title() }}</strong>
                </li>
                <li class="list-group-item">
                    Lisans Tarihi <br> <strong>{{ $people->licensed_at?->format('Y-m-d') }}</strong>
                </li>
                <li class="list-group-item">
                    Kayıt Tarihi <br> <strong>{{ $people->registered_at?->format('Y-m-d') }}</strong>
                </li>
                <li class="list-group-item">
                    Durum <br> <strong class="status {{ $people->status?->value }}">{{ $people->status?->title() }}</strong>
                </li>

                @if($people->type == \App\Enums\PeopleType::player)
                    @php
                        $player_club_id = $people->getMeta('player_club_id');
                        $club = cache()->remember('player_club_id_'.$player_club_id, 86400 * 7, function () use($player_club_id) {
                            return \App\Models\Club::find($player_club_id);
                        });
                    @endphp
                    <li class="list-group-item">
                        Kulüp <br> <strong>{{ $club?->name }}</strong>
                    </li>
                @endif

                @if($people->type == \App\Enums\PeopleType::referee)
                    <li class="list-group-item">
                        Klasman <br> <strong>{{ $people->getMeta('referee_class') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Bölge <br> <strong>{{ $people->getMeta('referee_region') }}</strong>
                    </li>
                @endif

                @if($people->type == \App\Enums\PeopleType::coach)
                    <li class="list-group-item">
                        Klasman <br> <strong>{{ $people->getMeta('coach_class') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Görevi <br> <strong>{{ $people->getMeta('coach_job') }}</strong>
                    </li>
                @endif

                @if($people->type == \App\Enums\PeopleType::racer)
                    <li class="list-group-item">
                        Yarışma Dalı <br> <strong>{{ $people->getMeta('racer_section') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Araç Markası <br> <strong>{{ $people->getMeta('racer_car_brand') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Araç Şasi No <br> <strong>{{ $people->getMeta('racer_car_no') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Muafiyet <br> <strong>{{ $people->getMeta('racer_document') }}</strong>
                    </li>
                    @if($file = $people->getMeta('racer_document_file'))
                        <li class="list-group-item">
                            Muafiyet Belgesi <br>
                            <a target="_blank" class="text-dark text-decoration-underline" href="{{ asset($file) }}">
                                <strong>{{ $file }}</strong>
                            </a>
                        </li>
                    @endif
                @endif

                @if($people->type == \App\Enums\PeopleType::school)
                    @php
                    $school_club_id = $people->getMeta('school_club_id');
                    $club = cache()->remember('school_club_id_'.$school_club_id, 86400 * 7, function () use($school_club_id) {
                        return \App\Models\Club::find($school_club_id);
                    });
                    @endphp
                    <li class="list-group-item">
                        Kulüp <br>
                        <strong>{{ $club?->name }}</strong>
                    </li>
                    <li class="list-group-item">
                        Okul <br> <strong>{{ $people->getMeta('school_name') }}</strong>
                    </li>
                    <li class="list-group-item">
                        Öğrenci Belgesi <br> <a target="_blank" href="{{ asset($people->getMeta('school_document')) }}"><strong class="text-dark text-decoration-underline">Belgeyi Görüntüle</strong></a>
                    </li>
                @endif
            </ul>
            <!--people -->
        </div>
        <div class="tab-pane" id="btabs-punishment" role="tabpanel" aria-labelledby="btabs-punishment" tabindex="0">
            <!--punishment -->
            @if(count($punishments))
                @foreach($punishments as $punishment)
                    <ul class="list-group mb-3">
                        <li class="list-group-item bg-light p-2">
                            {{ $punishment->people?->federation?->name }}
                        </li>
                        <li class="list-group-item p-2">
                            Lisans No <br> <strong>{{ $punishment->people?->license_no }}</strong>
                        </li>
                        <li class="list-group-item p-2">
                            Ceza Sebebi <br> <strong>{{ $punishment->reason }}</strong>
                        </li>
                        <li class="list-group-item p-2">
                            Ceza Açıklama <br> <strong>{{ $punishment->description }}</strong>
                        </li>
                        <li class="list-group-item p-2">
                            Kayıt Tarihi <br> <strong>{{ $punishment->created_at->format('Y-m-d H:i') }}</strong>
                        </li>
                    </ul>
                @endforeach
            @else
                <div class="alert alert-warning">
                    Disiplin cezası bulunmuyor!.
                </div>
            @endif
            <!--punishment -->
        </div>
        <div class="tab-pane" id="btabs-federations" role="tabpanel" aria-labelledby="btabs-federations" tabindex="0">
            <!--federations -->
            @if($peoples)
                <ul class="list-group list-group-flush">
                @foreach($peoples as $people_other)
                    <li class="list-group-item">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-lg-9 {{ !hasRole('superadmin') ? 'd-flex align-items-center gap-2':'' }}">
                                <img src="{!! asset($people_other->federation?->logo) !!}"
                                     style="max-width: 320px; height: 108px; object-fit: contain; margin-right: 10px; border: solid 1px #eee;"
                                     onerror="this.src='{{ asset('uploads/no-img.png') }}'"
                                     alt="{{ $people_other->federation?->name }}">
                                <p class="mb-0 mt-1">
                                    <span>Lisans No: {{ $people_other->license_no }}</span>
                                    <br>
                                    <strong>{{ $people_other->federation?->name }}</strong>
                                    <br>
                                    <span>{{ $people_other->type?->title() }}</span>
                                </p>
                            </div>
                            <div class="col-lg-3">
                                @if(hasRole('superadmin') && $people_other->id != $people->id)
                                    <button type="button" class="btn btn-info btn-sm w-100 show-people-other"
                                            data-toggle="view" data-route="{{ route('people.show', $people_other->id) }}?format=json">
                                        <i class="fa fa-fw fa-eye me-1"></i> Görüntüle
                                    </button>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            @else
                <div class="alert alert-warning">
                    Kayıt bulunmuyor!.
                </div>
            @endif
            <!--federations -->
        </div>
    </div>
</div>

