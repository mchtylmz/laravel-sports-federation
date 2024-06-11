<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }} {{ (!empty($title) ? '| ' : '') . $site_title }}</title>

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset($site_favicon) }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset($site_favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset($site_favicon) }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropify/dist/css/dropify.min.css') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/style.css') }}">

    @stack('css')
</head>
<body>
<div id="page-container" class="page-header-light main-content-boxed">
    <div id="page-loader" class="show"></div>

    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="d-flex align-items-center">
                <!-- Logo -->
                <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="{{ route('home') }}">
                    <img src="{{ asset($site_logo) }}" class="header-logo" alt="logo">
                </a>
                <!-- END Logo -->

                {{--- @include('layouts.parts.theme-switcher') ---}}
            </div>
            <!-- END Left Section -->

            <div class="d-none d-sm-flex align-items-center">
                @include('layouts.parts.menu')
            </div>

            <!-- Right Section -->
            <div class="d-flex align-items-center">
                @include('layouts.parts.user-menu')
            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Loader -->
        <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
        <div id="page-header-loader" class="overlay-header bg-primary-lighter">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        @include('layouts.parts.menu', ['mobile' => true])
        @yield('content')
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <footer id="page-footer" class="bg-body-extra-light">
        <div class="content py-3">
            <div class="row fs-sm">
                <div class="col-sm-12 py-0 text-center">
                    {{ $site_title  }} &copy; 2024
                </div>
            </div>
        </div>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Page Container -->

<script>
    window.lang = <?php echo json_encode(trans('table')); ?>;
</script>
<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
<!-- jQuery (required for jQuery Validation plugin) -->
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-validation/localization/messages_tr.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropify/dist/js/dropify.min.js') }}"></script>

<script src="{{ asset('assets/js/app.js') }}"></script>

@stack('js')
</body>
</html>
