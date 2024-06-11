@props([
    'mobile' => false
])

<!-- Navigation -->
@if($mobile)
    <div class="bg-white d-block d-sm-none">
        @endif
        <div class="content py-3">
            @if($mobile)
                <!-- Toggle Main Navigation -->
                <div class="d-lg-none">
                    <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
                    <button type="button"
                            class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center"
                            data-toggle="class-toggle" data-target="#main-navigation" data-class="d-none">
                        Menu
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <!-- END Toggle Main Navigation -->
            @endif
            <!-- Main Navigation -->
            <div id="main-navigation" class="d-none d-lg-block mt-2 mt-lg-0">
                <ul class="nav-main nav-main-light nav-main-horizontal nav-main-hover">
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('home') }}">
                            <i class="nav-main-link-icon si si-speedometer"></i>
                            <span class="nav-main-link-name">{{ __('home.title') }}</span>
                        </a>
                    </li>

                    @if(auth()->user()->hasRole('superadmin'))
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('home') }}">
                            <i class="nav-main-link-icon si si-flag"></i>
                            <span class="nav-main-link-name">{{ __('settings.federation') }}</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('home') }}">
                            <i class="nav-main-link-icon si si-flag"></i>
                            <span class="nav-main-link-name">{{ __('table.federasyon_bilgi') }}</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasRole('superadmin', 'admin'))
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('home') }}">
                            <i class="nav-main-link-icon si si-feed"></i>
                            <span class="nav-main-link-name">{{ __('table.bilgi_bankasi') }}</span>
                        </a>
                    </li>

                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('home') }}">
                            <i class="nav-main-link-icon si si-briefcase"></i>
                            <span class="nav-main-link-name">{{ __('table.kulupler') }}</span>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('home') }}">
                                <i class="nav-main-link-icon si si-ban"></i>
                                <span class="nav-main-link-name">{{ __('table.ceza') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole('admin', 'manager'))
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="{{ route('home') }}">
                                <i class="nav-main-link-icon si si-event"></i>
                                <span class="nav-main-link-name">{{ __('table.etkinlik') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->hasRole('superadmin'))

                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                               aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-users"></i>
                                <span class="nav-main-link-name">Kullanıcılar</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('settings.index') }}">
                                        <span class="nav-main-link-name">Tesis Sorumluları</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('settings.federation') }}">
                                        <span class="nav-main-link-name">Federasyon Kullanıcıları</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('settings.federation') }}">
                                        <span class="nav-main-link-name">Yöneticiler</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-main-item d-block d-sm-none">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                               aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-settings"></i>
                                <span class="nav-main-link-name">{{ __('settings.title') }}</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('settings.index') }}">
                                        <span class="nav-main-link-name">{{ __('settings.general') }}</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('settings.federation') }}">
                                        <span class="nav-main-link-name">{{ __('settings.federation') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- END Main Navigation -->
        </div>
        @if($mobile)
    </div>
@endif
<!-- END Navigation -->
