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
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                           aria-expanded="false" href="#">
                            <i class="nav-main-link-icon si si-puzzle"></i>
                            <span class="nav-main-link-name">Dropdown</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="javascript:void(0)">
                                    <span class="nav-main-link-name">Link #1</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="javascript:void(0)">
                                    <span class="nav-main-link-name">Link #2</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END Main Navigation -->
        </div>
        @if($mobile)
    </div>
@endif
<!-- END Navigation -->
