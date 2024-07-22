<div class="block border-0 p-0">
    <ul class="nav nav-tabs nav-tabs-alt align-items-center border-bottom" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link px-3" id="btabs-newnote-tab" data-bs-toggle="tab" data-bs-target="#btabs-newnote" role="tab" aria-controls="btabs-newnote" aria-selected="false" tabindex="-1">Yeni Not Gönder</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link active px-3" id="btabs-notes-tab" data-bs-toggle="tab" data-bs-target="#btabs-notes" role="tab" aria-controls="btabs-notes" aria-selected="true">Gönderilen Notlar</button>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        <div class="tab-pane" id="btabs-newnote" role="tabpanel" aria-labelledby="btabs-newnote" tabindex="0">
            <!-- -->
            <form class="js-validation-form" action="{{ route('federation.notes.save', $federation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-2">
                            <label class="form-label" for="title">Başlık</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Başlık.." required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-2">
                            <label class="form-label" for="content">Açıklama</label>
                            <textarea class="form-control" rows="15" id="content" name="content" placeholder="Açıklama.."></textarea>
                        </div>
                    </div>
                </div>
                <div class="my-3 text-center submit">
                    <button type="submit" class="btn btn-alt-primary px-4">
                        <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                    </button>
                </div>
            </form>
            <!-- -->
        </div>
        <div class="tab-pane active show" id="btabs-notes" role="tabpanel" aria-labelledby="btabs-notes" tabindex="0">
            @foreach($notes as $note)
                <ul class="list-group list-group-flush border mb-2">
                    <li class="list-group-item bg-light">
                        Başlık : <strong>{{ $note->title }}</strong>
                    </li>
                    <li class="list-group-item">
                        Açıklama
                        <br> <strong>{{ $note->content }}</strong>
                    </li>
                    <li class="list-group-item">
                        @if($note->is_read)
                            <strong class="text-success">Okundu</strong> : {{ $note->read_at?->format('Y-m-d H:i') }}
                        @else
                            <strong class="text-danger">Okunmadı</strong>
                        @endif
                    </li>
                    <li class="list-group-item">
                        Gönderim Zamanı : <strong>{{ $note->created_at?->format('Y-m-d H:i') }}</strong>
                    </li>
                    <li class="list-group-item bg-danger-light">
                        Sil
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
</div>



