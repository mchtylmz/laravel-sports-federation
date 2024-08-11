<div class="block border-0 p-0">
    <ul class="nav nav-tabs nav-tabs-alt align-items-center border-bottom" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ !count($notes) ? 'active' : '' }} px-3" id="btabs-newnote-tab" data-bs-toggle="tab" data-bs-target="#btabs-newnote" role="tab" aria-controls="btabs-newnote" aria-selected="false" tabindex="-1">Yeni Not Gönder</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ count($notes) ? 'active' : '' }} px-3" id="btabs-notes-tab" data-bs-toggle="tab" data-bs-target="#btabs-notes" role="tab" aria-controls="btabs-notes" aria-selected="true">Gönderilen Notlar</button>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        <div class="tab-pane {{ !count($notes) ? 'active show' : '' }}" id="btabs-newnote" role="tabpanel" aria-labelledby="btabs-newnote" tabindex="0">
            <!-- -->
            <form class="note-form" action="{{ route('federation.notes.save', $federation->id) }}" method="POST" enctype="multipart/form-data">
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
        <div class="tab-pane {{ count($notes) ? 'active show' : '' }}" id="btabs-notes" role="tabpanel" aria-labelledby="btabs-notes" tabindex="0">
            @foreach($notes as $note)
                <ul class="list-group list-group-flush border mb-3 element-source">
                    <li class="list-group-item bg-light py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>{{ $note->title }}</strong>
                            <button type="button" class="btn btn-sm btn-danger text-center px-2" data-toggle="delete" data-route="{{ route('federation.notes.delete', $note->id) }}" data-message="Gönderilen not silinecektir, işleme devam edilsin mi?" data-id="{{ $note->id }}">
                                <i class="fa fa-fw fa-trash-alt me-2"></i> Sil
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item">
                       <strong>{{ $note->content }}</strong>
                    </li>
                    <li class="list-group-item">
                        @if($note->is_read)
                            <strong class="text-success">Okundu</strong>
                            (<strong>{{ $note->read_at?->format('Y-m-d H:i') }}</strong>)
                        @else
                            <strong class="text-danger">Okunmadı</strong>
                        @endif
                    </li>
                    <li class="list-group-item">
                        Gönderim Zamanı : <strong>{{ $note->created_at?->format('Y-m-d H:i') }}</strong>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
</div>



