@extends('layouts.app')
@section('content')

    <x-block title="{{ $title }}">
        <form class="js-validation-form repeater" action="{{ route('federation.info.date.save', user()?->federation()?->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label d-flex align-items-center mb-3" for="meet_dates">
                    <button type="button" class="btn btn-sm btn-alt-success px-2 me-3" data-repeater-create>
                        <i class="fa fa-plus mx-1 fa-faw"></i> Tarih Ekle
                    </button>
                </label>

                <div class="mt-2" data-repeater-list="meet_dates">
                    @if(count($dates))
                        @foreach($dates as $date)
                            <div data-repeater-item>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="date">Kurul Tarihi</label>
                                            <input type="text" class="form-control js-flatpickr" id="date" name="date" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $date->start_date?->format('Y-m-d') }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="mb-2">
                                            <label class="form-label" for="description">Kurul Açıklama</label>
                                            <textarea name="description" id="description" class="form-control" rows="2">{{ $date->content }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="hidden" name="id" value="{{ $date->id }}">
                                        <label class="form-label invisible" for="description">Kurul Açıklama</label>
                                        <button type="button" class="btn btn-danger w-100" data-event="{{ $date->id }}" data-repeater-delete>
                                            <i class="fa fa-trash-alt mx-2"></i> Kaldır
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div data-repeater-item>
                            <div class="row mb-3">
                                <div class="col-lg-3">
                                    <div class="mb-2">
                                        <label class="form-label" for="date">Kurul Tarihi</label>
                                        <input type="text" class="form-control js-flatpickr" id="date" name="date" data-locale="tr" placeholder="YYYY-AA-GG" readonly required>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="mb-2">
                                        <label class="form-label" for="description">Kurul Açıklama</label>
                                        <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <input type="hidden" name="id" value="">
                                    <label class="form-label invisible" for="description">Kurul Açıklama</label>
                                    <button type="button" class="btn btn-danger w-100" data-event="0" data-repeater-delete>
                                        <i class="fa fa-trash-alt mx-2"></i> Kaldır
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            <div class="my-3 text-center submit">
                <button type="submit" class="btn btn-alt-primary px-4">
                    <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                </button>
            </div>
        </form>
    </x-block>

@endsection
@push('js')
    <script src="{{ asset('assets/js/plugins/jquery.repeater/jquery.repeater.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.repeater').repeater({
                show: function () {
                    $(this).slideDown();
                    $(".js-flatpickr").flatpickr({});
                },
                hide: function (deleteElement) {
                    window.alert.fire({
                        text: 'Genel kurul tarihi silinecektir, işleme devam edilsin mi?',
                        icon: "question",
                        showCancelButton: true,
                        showConfirmButton: true,
                        timer: 15000,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let $this = $(this),
                                btn = $this.find('button[data-repeater-delete]'),
                                id = btn.data('event');

                            if (!id) {
                                $(this).slideUp(deleteElement);
                                return true;
                            }

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'POST',
                                url: '{{ route('federation.info.date.delete') }}',
                                data: {
                                    id: id
                                },
                                dataType: 'json',
                                beforeSend: function () {
                                    btn.loading('show');
                                },
                                success: function (response) {
                                    $this.slideUp(deleteElement);
                                },
                                error: function (response) {
                                    alert.fire({
                                        text: response.responseJSON.message,
                                        icon: 'error'
                                    });
                                }
                            }).always(function () {
                                btn.loading('hide');
                            });
                        }
                    });

                },
            })
        });
    </script>
@endpush
