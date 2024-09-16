@extends('layouts.app')
@section('content')
    <div class="text-end mb-3">
        <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAdd" aria-controls="offcanvasAdd">
            <i class="fa fa-fw fa-plus"></i> Üye Ekle
        </button>
    </div>


    <div class="row">
        @foreach($directors as $director)
            <div class="col-lg-4 pb-3">
                <div class="block block-rounded h-100 mb-0">
                    <div class="py-2 block-content block-content-full d-flex align-items-center justify-content-between bg-primary-dark">
                        <div class="me-3">
                            <p class="fs-sm fw-small text-white-75 mb-0">
                               #{{ $director->sort }}
                            </p>
                            <p class="text-white fw-bold mb-0">
                               {{ $director->name }} {{ $director->surname }}
                            </p>
                        </div>
                    </div>
                    <div class="block-content p-0">
                        <div class="list-group push m-0 p-0">
                            <a class="list-group-item list-group-item-action" href="javascript:void(0)">
                                <h5 class="fs-base mb-1">Görevi: {{ $director->title }}</h5>
                            </a>
                            <a class="list-group-item list-group-item-action" href="javascript:void(0)">
                                <h5 class="fs-base mb-1">Telefon: {{ $director->phone }}</h5>
                            </a>
                            <a class="list-group-item list-group-item-action" href="javascript:void(0)">
                                <h5 class="fs-base mb-1">Email: {{ $director->email }}</h5>
                            </a>
                            <a class="list-group-item list-group-item-action" href="javascript:void(0)">
                                <h5 class="fs-base mb-1">Kimlik: {{ $director->identity }}</h5>
                            </a>
                        </div>
                    </div>
                    <div class="block-content py-2">
                        <div class="d-flex justify-content-between push m-0 p-0">
                            <button type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled" data-bs-toggle="offcanvas" data-bs-target="#offcanvasUpdate_{{ $director->id }}" aria-controls="offcanvasUpdate_{{ $director->id }}">
                                <i class="fa fa-fw fa-pencil-alt opacity-50 me-1"></i> Düzenle
                            </button>
                            <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-toggle="delete" data-route="{{ route('federation.info.director.delete', $director->id) }}" data-message="({{ $director->name }} {{ $director->surname }}) Üye silinecektir, işleme devam edilsin mi?" data-id="{{ $director->id }}">
                                <i class="fa fa-fw fa-trash-alt"></i> Sil
                            </button>
                        </div>

                        <!--  -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUpdate_{{ $director->id }}" aria-labelledby="offcanvasUpdate_{{ $director->id }}Label">
                            <div class="offcanvas-header bg-light">
                                <h5 class="offcanvas-title" id="offcanvasUpdate_{{ $director->id }}Label">Üye Ekle</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <form class="js-validation-form" action="{{ route('federation.info.director.save', $director->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="name">Ad <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Ad..." value="{{ $director->name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="surname">Soyad <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad..." value="{{ $director->surname }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="title">Görev <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="title" name="title" placeholder="Görev..." value="{{ $director->title }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="phone">Telefon <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Telefon..." value="{{ $director->phone }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Email..." value="{{ $director->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="identity">Kimlik</label>
                                                <input type="text" class="form-control" id="identity" name="identity" placeholder="Kimlik..." value="{{ $director->identity }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="sort">Gösterim Sırası</label>
                                                <input type="number" class="form-control" id="sort" name="sort" placeholder="1"  value="{{ $director->sort }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-3 text-center submit">
                                        <button type="submit" class="btn btn-alt-primary px-4">
                                            <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="my-3 p-3 pb-0">
        {{ $directors->links() }}
    </div>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAdd" aria-labelledby="offcanvasAddLabel">
        <div class="offcanvas-header bg-light">
            <h5 class="offcanvas-title" id="offcanvasAddLabel">Üye Ekle</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form class="js-validation-form" action="{{ route('federation.info.director.save') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="name">Ad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ad..." required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="surname">Soyad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="surname" name="surname" placeholder="Soyad..." required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label" for="title">Görev <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Görev..." required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="phone">Telefon <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Telefon..." required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="identity">Kimlik</label>
                            <input type="text" class="form-control" id="identity" name="identity" placeholder="Kimlik...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label" for="sort">Gösterim Sırası</label>
                            <input type="number" class="form-control" id="sort" name="sort" placeholder="1" value="1">
                        </div>
                    </div>
                </div>

                <div class="my-3 text-center submit">
                    <button type="submit" class="btn btn-alt-primary px-4">
                        <i class="fa fa-save mx-2 fa-faw"></i> {{ __('table.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
