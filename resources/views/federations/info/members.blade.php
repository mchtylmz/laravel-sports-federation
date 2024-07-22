@extends('layouts.app')
@section('content')

    <x-block title="{{ $title }}">
        <form class="js-validation-form repeater" action="{{ route('federation.info.members.save', $federation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label d-flex align-items-center mb-3" for="members">
                    <button type="button" class="btn btn-sm btn-alt-success px-2 me-3" data-repeater-create>
                        <i class="fa fa-plus mx-1 fa-faw"></i> Üye Kuruluş Ekle
                    </button>
                </label>

                <div class="mt-2" data-repeater-list="members">
                    @if($members = json_decode($federation->getMeta('members')))
                        @foreach(collect($members)->sortByDesc('date') as $member)
                            <div data-repeater-item>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="date">Üyelik Tarihi</label>
                                            <input type="text" class="form-control js-flatpickr" id="date" name="date" data-locale="tr" placeholder="YYYY-AA-GG" value="{{ $member->date }}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-2">
                                            <label class="form-label" for="name">Kurul Adı</label>
                                            <textarea name="name" id="name" class="form-control" rows="1">{{ $member->name }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-2">
                                            <label class="form-label" for="description">Kuruluş Açıklama</label>
                                            <textarea name="description" id="description" class="form-control" rows="2">{{ $member->description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="form-label invisible" for="name">Kuruluş Adı</label>
                                        <button type="button" class="btn btn-danger w-100" data-repeater-delete>
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
                                        <label class="form-label" for="date">Üyelik Tarihi</label>
                                        <input type="text" class="form-control js-flatpickr" id="date" name="date" data-locale="tr" placeholder="YYYY-AA-GG" readonly required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-2">
                                        <label class="form-label" for="name">Kuruluş Adı</label>
                                        <textarea name="name" id="name" class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-2">
                                        <label class="form-label" for="description">Kuruluş Açıklama</label>
                                        <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label invisible" for="name">Kuruluş Adı</label>
                                    <button type="button" class="btn btn-danger w-100" data-repeater-delete>
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
                    $(this).slideUp(deleteElement);
                },
            })
        });
    </script>
@endpush
