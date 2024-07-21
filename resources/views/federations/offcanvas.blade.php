<div class="block border p-0">
    <ul class="nav nav-tabs nav-tabs-alt" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-5" id="btabs-federation-tab" data-bs-toggle="tab" data-bs-target="#btabs-federation" role="tab" aria-controls="btabs-federation" aria-selected="false" tabindex="-1">Bilgiler</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link px-5" id="btabs-clubs-tab" data-bs-toggle="tab" data-bs-target="#btabs-clubs" role="tab" aria-controls="btabs-clubs" aria-selected="true">Bağlı Kulüpler</button>
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
                <li class="list-group-item">
                    Branş Dosya No Liste
                    <br> <strong>{{ $federation->branch_number }}</strong>
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
    </div>
</div>

