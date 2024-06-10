<!-- Options -->
<div class="dropdown d-inline-block ms-1">
    <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-themes-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-brush"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
        <!-- Color Themes -->
        <!-- Layout API, functionality initialized in Template._uiHandleTheme() -->
        <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="default" href="#">
            <span>Default</span>
            <i class="fa fa-circle text-default"></i>
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/amethyst.min.css') }}" href="#">
            <span>Amethyst</span>
            <i class="fa fa-circle text-amethyst"></i>
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/city.min.css') }}" href="#">
            <span>City</span>
            <i class="fa fa-circle text-city"></i>
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/flat.min.css') }}" href="#">
            <span>Flat</span>
            <i class="fa fa-circle text-flat"></i>
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/modern.min.css') }}" href="#">
            <span>Modern</span>
            <i class="fa fa-circle text-modern"></i>
        </a>
        <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="{{ asset('assets/css/themes/smooth.min.css') }}" href="#">
            <span>Smooth</span>
            <i class="fa fa-circle text-smooth"></i>
        </a>
        <!-- END Color Themes -->

        <!-- Header Styles -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        {{---
        <div class="dropdown-divider"></div>

        <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">
            <span>Header Light</span>
        </a>
        <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">
            <span>Header Dark</span>
        </a>
        ---}}
        <!-- END Header Styles -->
    </div>
</div>
<!-- END Options -->
