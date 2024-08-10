<div class="block border p-0">
    <ul class="nav nav-tabs nav-tabs-alt align-items-center border-bottom" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-3" id="btabs-federation-tab" data-bs-toggle="tab" data-bs-target="#btabs-federation" role="tab" aria-controls="btabs-federation" aria-selected="false" tabindex="-1">Bilgiler</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-3" id="btabs-clubs-tab" data-bs-toggle="tab" data-bs-target="#btabs-clubs" role="tab" aria-controls="btabs-clubs" aria-selected="true">Bağlı Kulüpler</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-3" id="btabs-tab4-tab" data-bs-toggle="tab" data-bs-target="#btabs-tab4" role="tab" aria-controls="btabs-tab4" aria-selected="true">İletişim Bilgileri</button>
        </li>

        <li class="nav-item ms-auto">
            <div class="btn-group btn-group-sm pe-2">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-alt-secondary dropdown-toggle px-3" id="btnGroupTabs1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Diğer Bilgiler
                    </button>
                    <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="btnGroupTabs1" style="">
                        <button class="dropdown-item" data-bs-toggle="tab" data-bs-target="#btabs-tab1" role="tab">
                            Yönetim Kurulu
                        </button>
                        <button class="dropdown-item" data-bs-toggle="tab" data-bs-target="#btabs-tab2" role="tab">
                            Tüzük
                        </button>
                        <button class="dropdown-item" data-bs-toggle="tab" data-bs-target="#btabs-tab3" role="tab">
                            Genel Kurul Tarihi
                        </button>
                        <button class="dropdown-item" data-bs-toggle="tab" data-bs-target="#btabs-tab5" role="tab">
                            Üye Kuruluşlar
                        </button>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        <div class="tab-pane active show" id="btabs-federation" role="tabpanel" aria-labelledby="btabs-federation" tabindex="0">
            <!--federation -->
            <img src="{{ asset($federation->logo) }}"
                 alt="{{ $federation->name }}"
                 class="w-100"
                 style="max-height: 240px; object-fit: contain" />
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    Başlık
                    <br> <strong>{{ $federation->name }}</strong>
                </li>
                <li class="list-group-item">
                    Dosya No
                    <br> <strong>{{ $federation->document_number }}</strong>
                </li>
                <li class="list-group-item d-none">
                    Branş Dosya No Liste
                    <br> <strong>{{ $federation->branch_number }}</strong>
                </li>
                <li class="list-group-item">
                    Özerk
                    <br> <strong>{{ $federation->is_special == 1 ? __('table.yes') : __('table.no') }}</strong>
                </li>
                <li class="list-group-item">
                    Website
                    <br> <strong>{{ $federation->website }}</strong>
                </li>
                <li class="list-group-item">
                    Kayıt Tarihi
                    <br> <strong>{{ $federation->created_at?->format('Y-m-d') }}</strong>
                </li>
            </ul>
            <!--federation -->
        </div>
        <div class="tab-pane" id="btabs-clubs" role="tabpanel" aria-labelledby="btabs-clubs" tabindex="0">
            @php $federation_clubs = federation_clubs($federation->id); @endphp
            <div class="alert alert-info">
                Toplam {{ count($federation_clubs) }} kulüp bağlı bulunuyor.
            </div>

            <ol class="list-group list-group-numbered mb-3">
                @foreach($federation_clubs as $club)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $club->name }}</div>
                            Yetkili: {{ $club->user_name }} {{ $club->user_phone }}
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>

        <!-- -->
        <div class="tab-pane" id="btabs-tab1" role="tabpanel" aria-labelledby="btabs-tab1" tabindex="0">
            @if($directors = $federation->directors)
                <ul class="list-group list-group-flush">
                    @foreach($directors as $director)
                        <li class="list-group-item">
                            İsim Soyisim: <strong>{{ $director->name }} {{ $director->surname }}</strong>
                            <br>
                            Görev: <strong>{{ $director->titlee ?? ' - ' }}</strong>
                            <br>
                            Telefon: <span>{{ $director->phone ?? ' - '}}</span>
                            <br>
                            Email: <span>{{ $director->emaile ?? ' - ' }}</span>
                            <br>
                            Kimlik: <span>{{ $director->identitye ?? ' - ' }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-danger">
                    Yönetim kurulu üyeleri bulunmuyor!.
                </div>
            @endif
        </div>
        <!-- -->

        <!-- -->
        <div class="tab-pane" id="btabs-tab2" role="tabpanel" aria-labelledby="btabs-tab2" tabindex="0">
            @if($statute_files = $federation->getMeta('statute_files'))
                @foreach($statute_files as $statute_file)
                    <div class="mb-3 bg-white">
                        <h4 class="p-3 mb-1">Dosya: @php echo explode('/', $statute_file)[1] ?? ''; @endphp</h4>
                        <a target="_blank" href="{{ asset($statute_file) }}" class="btn btn-alt-info w-100 py-3 rounded-0">
                            <i class="fa fa-external-link mx-2 fa-faw"></i> Dosyayı Yeni Sekmede Aç
                        </a>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger">
                    Tüzük dosyası bulunmuyor!.
                </div>
            @endif
        </div>
        <!-- -->

        <!-- -->
        <div class="tab-pane" id="btabs-tab3" role="tabpanel" aria-labelledby="btabs-tab3" tabindex="0">
            @if($dates = json_decode($federation->getMeta('meet_dates')))
                <ul class="list-group list-group-flush">
                    @foreach(collect($dates)->sortByDesc('date') as $date)
                        <li class="list-group-item">
                            Kurul Tarihi / Açıklama
                            <br>
                            <strong>{{ $date->date }}</strong>
                            <br>
                            <span>{{ $date->description }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-danger">
                    Genel kurul tarihleri bulunmuyor!.
                </div>
            @endif
        </div>
        <!-- -->

        <!-- -->
        <div class="tab-pane" id="btabs-tab4" role="tabpanel" aria-labelledby="btabs-tab4" tabindex="0">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    Federasyon Adı
                    <br> <strong>{{ $federation->getMeta('fullname') }}</strong>
                </li>
                <li class="list-group-item">
                    Telefon
                    <br> <strong>{{ $federation->getMeta('phone') }}</strong>
                </li>
                <li class="list-group-item">
                    Email
                    <br> <strong>{{ $federation->getMeta('email') }}</strong>
                </li>
                <li class="list-group-item">
                    Fax
                    <br> <strong>{{ $federation->getMeta('fax') }}</strong>
                </li>
                <li class="list-group-item">
                    Website
                    <br> <strong>{{ $federation->getMeta('website') }}</strong>
                </li>
            </ul>
        </div>
        <!-- -->

        <!-- -->
        <div class="tab-pane" id="btabs-tab5" role="tabpanel" aria-labelledby="btabs-tab5" tabindex="0">
            @if($members = json_decode($federation->getMeta('members')))
                <ul class="list-group list-group-numbered list-group-flush">
                    @foreach(collect($members)->sortByDesc('date') as $member)
                        <li class="list-group-item">
                            Üyelik Tarihi: <strong>{{ $member->date }}</strong>
                            <br>
                            Kurul Adı: <strong>{{ $member->name }}</strong>
                            <br>
                            Açıklama: <span>{{ $member->description }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="alert alert-danger">
                    Üye olunan kuruluşlar bulunmuyor!.
                </div>
            @endif
        </div>
        <!-- -->
    </div>
</div>

