@extends('layouts.app')
@section('content')

    <x-block title="{{ $title }}">
        <form class="js-validation-form" action="{{ route('federation.info.statute.save', $federation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-0">
                        <label class="form-label" for="file">Tüzük Dosya Yükle (PDF, WORD, EXCEL)</label>
                        <input type="file" class="form-control" id="file" accept=".pdf,.xlsx,.xls,.doc,.docx" name="file[]" multiple required>
                    </div>
                    <small>Dosya yüklenirse tüzük içeriği güncellenir. Birden fazla dosya eklenebilir.</small>
                </div>
            </div>

            <div class="my-3 text-center submit">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>
    </x-block>

    <hr>

    @if($statute_files = $federation->getMeta('statute_files'))
        @foreach($statute_files as $statute_file)
            <div class="mb-3 bg-white">
                <h4 class="p-3 mb-1">Dosya: @php echo explode('/', $statute_file)[1] ?? ''; @endphp</h4>
                <a target="_blank" href="{{ asset($statute_file) }}" class="btn btn-alt-info w-100 py-3 rounded-0">
                    <i class="fa fa-external-link mx-2 fa-faw"></i> Dosyayı Yeni Sekmede Aç
                </a>
            </div>
        @endforeach
    @endif

@endsection
