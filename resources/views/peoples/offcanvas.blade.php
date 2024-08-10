<div class="block border p-0">
    <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-5" id="btabs-people-tab" data-bs-toggle="tab" data-bs-target="#btabs-people" role="tab" aria-controls="btabs-people" aria-selected="false" tabindex="-1">Kişi Bilgileri</button>
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
                    <img src="{{ asset($people->photo) }}" alt="{{ $people->fullname }}" class="w-100" style="max-height: 240px; object-fit: contain" />
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
                            Ad Soyad
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
                        Muafiyet Belgesi <br> <strong>{{ $people->getMeta('racer_document') }}</strong>
                    </li>
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
            @if($punishments = $people->punishments()->count())
                @foreach($people->punishments as $punishment)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Ceza Sebebi <br> <strong>{{ $punishment->reason }}</strong>
                        </li>
                        <li class="list-group-item">
                            Ceza Açıklama <br> <strong>{{ $punishment->description }}</strong>
                        </li>
                        <li class="list-group-item">
                            Kayıt Tarihi <br> <strong>{{ $punishment->created_at->format('Y-m-d H:i') }}</strong>
                        </li>
                    </ul>
                    <hr>
                @endforeach
            @else
                <div class="alert alert-warning">
                    Disiplin cezası bulunmuyor!.
                </div>
            @endif
            <!--punishment -->
        </div>
    </div>
</div>

