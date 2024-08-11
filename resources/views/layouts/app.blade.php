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
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-select/dist/css/bootstrap-select.css') }}" />

    <!-- Stylesheets -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">

    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/style.css') }}">

    @stack('css')
</head>
<body>
<div id="page-container" class="page-header-light main-content-full">
    <!-- <div id="page-loader" class="show"></div> -->

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

        @if($header_under_text)
            <div class="bg-white-50 mb-{{ $note_count ? 0:3 }} p-3">
                <!-- Soldan Sağa, Döngü İçinde -->
                <marquee behavior="scroll" direction="left" scrollamount="14">
                    <h5 class="mb-0">{{ $header_under_text }}</h5>
                </marquee>
            </div>
        @endif
        @if($note_count)
            <div class="bg-danger-light mt-0 mb-3 p-0 notes-warning">
                <div class="container alert my-0">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-6">
                            <i class="fa fa-note-sticky fa-fw mx-2"></i>
                            <strong>{{ $note_count }} okunmamış notunuz var!</strong>
                        </div>
                        <div class="col-lg-3">
                            <a type="button" class="btn btn-sm btn-dark js-bs-tooltip-enabled w-100" href="{{ route('my.notes') }}">
                                <i class="fa fa-fw fa-eye mx-2"></i> Görüntüle ve Oku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <div class="content pt-{{ $header_under_text ? 2 : 4 }}">
            @yield('content')
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

    @include('components.offcanvas')

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
<script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr/l10n/tr.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-select/dist/js/i18n/defaults-tr_TR.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    function calculateAge(birthdate, minAge = 0) {
        const birthDateObj = new Date(birthdate);
        const currentDate = new Date();

        let years = currentDate.getFullYear() - birthDateObj.getFullYear();
        let months = currentDate.getMonth() - birthDateObj.getMonth();
        let days = currentDate.getDate() - birthDateObj.getDate();

        if (months < 0 || (months === 0 && days < 0)) {
            years--;
            months += 12;
        }
        if (days < 0) {
            const previousMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 0);
            days += previousMonth.getDate();
            months--;
        }

        if (minAge) {
            return years >= minAge
        }

        return years;
    }
</script>
@stack('js')

</body>
</html>
