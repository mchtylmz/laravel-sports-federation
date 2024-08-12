@extends('layouts.app')

@section('content')
    <style>
        .notes-warning {
            display: none !important;
        }
    </style>

    <div class="container">
        <div class="row my-3">
            @if(!empty($notes))
                @foreach($notes as $note)
                    <div class="col-lg-12">
                        <x-block title="{{ $note->title }}"
                                 subtitle="{{ !$note->is_read ? 'Okunmamış Not':'Okuma Zamanı:'.$note->read_at?->format('Y-m-d H:i') }}"
                                 class="{{ $note->is_read ? 'block-mode-hidden' : '' }} mb-3">
                            <div class="mb-3">
                                {{ $note->content }}
                            </div>
                            <div class="my-3 border p-3 d-flex justify-content-between align-items-center">
                                @if($note->is_read)
                                    <p class="mb-0">Okuma Zamanı : <strong>{{ $note->read_at?->format('Y-m-d H:i') }}</strong></p>
                                @endif
                                <p class="mb-0">Gönderim Zamanı : <strong>{{ $note->created_at?->format('Y-m-d H:i') }}</strong></p>
                            </div>
                        </x-block>
                        @php
                            if (!$note->is_read) {
                                $note->read();
                            }
                        @endphp
                    </div>
                @endforeach
            @else
                <div class="col-lg-12">
                    <div class="alert alert-danger">
                        Görüntülenecek not bulunmamaktadır!.
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
