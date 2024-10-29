@extends('layouts.app')

@section('content')

    <div class="row align-items-center justify-content-center">
        @if(permitIf(role(), ['mudur']))
        <div class="col-lg-3 p-3">
           <!-- Your Block - block block-rounded block-mode-hidden -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Yaklaşan Etkinlikler
            </h3>

        </div>
        <div class="block-content fs-sm p-0">


            <div class="list-group" style="height: 400px; overflow-y: scroll;">

                @foreach($events as $event)
                @php $start_date = sprintf('%s %s', $event->start_date?->format('Y-m-d'), $event->start_time); @endphp
                  <a href="javascript:;" class="list-group-item list-group-item-action" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-toggle="view" data-route="{{ route('event.show', $event->id) }}?format=json">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1">{{ $event->title }}</h5>
                      <small>{{ Carbon\Carbon::parse($start_date)->translatedFormat('d M Y, H:i') }}</small>
                    </div>
                    <p class="mb-1">
                        {!! !empty($event->user?->role == 'admin') ? (!empty($event->location) ? $event->location.'<br>': '') . $event->user?->federation()?->name : $event->location !!}
                    </p>
                  </a>
                  @endforeach
                </div>


        </div>
    </div>
    <!-- END Your Block -->


        </div>
        @endif
        <div class="col-lg-6 p-3 text-center">
            <img style="height: 400px; width: 100%; object-fit: contain"
                 src="{{ asset(settings()->home_logo) }}"
                 onerror="this.src='{{ asset('uploads/no-img.png') }}'"
                 class="w-100">
        </div>

            @if(permitIf(role(), ['mudur']))
                <div class="col-lg-3 p-3">
                    <!-- Your Block - block block-rounded block-mode-hidden -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                Genel Kurullar
                            </h3>

                        </div>
                        <div class="block-content fs-sm p-0">


                            <div class="list-group" style="height: 400px; overflow-y: scroll;">

                                @foreach($events2 as $event)
                                    @php $start_date = sprintf('%s %s', $event->start_date?->format('Y-m-d'), $event->start_time); @endphp
                                    <a href="javascript:;" class="list-group-item list-group-item-action" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-toggle="view" data-route="{{ route('event.show', $event->id) }}?format=json">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $event->title }}</h5>
                                            <small>{{ Carbon\Carbon::parse($start_date)->translatedFormat('d M Y, H:i') }}</small>
                                        </div>
                                        <p class="mb-1">
                                            {!! !empty($event->user?->role == 'admin') ? (!empty($event->location) ? $event->location.'<br>': '') . $event->user?->federation()?->name : $event->location !!}
                                        </p>
                                    </a>
                                @endforeach
                            </div>


                        </div>
                    </div>
                    <!-- END Your Block -->


                </div>
            @endif

        <div class="col-lg-8">
            <div class="row justify-content-center align-items-start mt-1">
                @if($phone = settings()->phone)
                    <div class="col-lg-4 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fa fa-phone fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                            <a target="_blank" class="text-dark mb-0 p-0" href="tel:9{{ str_replace(['(',')',' '],'',$phone) }}">{{ $phone }}</a>
                        </h4>
                    </div>
                @endif
                @if($link = settings()->link)
                    <div class="col-lg-4 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fa fa-globe fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                            <a target="_blank" class="text-dark mb-0 p-0" href="{{ $link }}">@php echo str_replace(['http://', 'https://', '/'], '', $link); @endphp</a>
                        </h4>
                    </div>
                @endif
                @if($email = settings()->email)
                    <div class="col-lg-4 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fa fa-at fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                            <a target="_blank" class="text-dark mb-0 p-0" href="maiilto:{{ $email }}">{{ $email }}</a>
                        </h4>
                    </div>
                @endif

                @if($facebook = settings()->facebook)
                    <div class="col-lg-4 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fab fa-facebook fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                           <a target="_blank" class="text-dark mb-0 p-0" href="{{ $facebook }}">Spor Dairesi Müdürlüğü</a>
                        </h4>
                    </div>
                @endif

                @if($x = settings()->x)
                    <div class="col-lg-4 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fa fa-x fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                           <a target="_blank" class="text-dark mb-0 p-0" href="{{ $x }}">Spor Dairesi Müdürlüğü</a>
                        </h4>
                    </div>
                @endif

                @if($youtube = settings()->youtube)
                    <div class="col-lg-4 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fab fa-youtube fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                            <a target="_blank" class="text-dark mb-0 p-0" href="{{ $youtube }}">KKTC Spor Dairesi Müdürlüğü</a>
                        </h4>
                    </div>
                @endif
                @if($address = settings()->address)
                    <div class="col-lg-6 d-flex align-items-start mb-4 justify-content-center text-center">
                        <i class="fa fa-map fa-fw me-2 mt-1"></i>
                        <h4 class="mb-0 text-dark text-center">
                            {{ $address }}
                        </h4>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
