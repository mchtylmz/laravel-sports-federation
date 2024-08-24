<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} | {{ $site_title }}</title>

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset($site_favicon) }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset($site_favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset($site_favicon) }}">
    <!-- END Icons -->

    <!-- Stylesheets --><!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-select/dist/css/bootstrap-select.css') }}" />

    <!-- Stylesheets -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
<div id="page-container">
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="hero-static d-flex align-items-center" style="background-image: url('{{ asset('uploads/bg.png') }}')">
            <div class="w-100">
                @yield('content')
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>

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
<script src="{{ asset('assets/js/plugins/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-select/dist/js/i18n/defaults-tr_TR.js') }}"></script>

<!-- Page JS Code -->
<script src="{{ asset('assets/js/pages/op_auth_signin.min.js') }}"></script>
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
