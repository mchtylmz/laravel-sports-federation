<!-- User Dropdown -->
<div class="dropdown d-inline-block ms-2">
    <button type="button" class="btn btn-sm btn-alt-secondary" id="page-header-user-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-user"></i>
        <span class="ms-1">{{ auth()->user()->name }}</span>
        <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
         aria-labelledby="page-header-user-dropdown">
        <div class="p-3 text-center bg-body-light border-bottom rounded-top">
            <p class="mt-2 mb-0 fw-medium">{{ auth()->user()->name }}</p>
            <p class="mb-0 text-muted fs-sm fw-medium">{{ auth()->user()->role }}</p>
        </div>
        <div class="p-2">
            <a class="dropdown-item d-flex align-items-center justify-content-between"
               href="op_auth_lock.html">
                <span class="fs-sm fw-medium">{{ __('auth.profile.title') }}</span>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between"
               href="op_auth_lock.html">
                <span class="fs-sm fw-medium">{{ __('auth.changePassword.title') }}</span>
            </a>
            <a class="dropdown-item d-flex align-items-center justify-content-between"
               href="{{ route('logout') }}">
                <span class="fs-sm fw-medium">{{ __('auth.logout.title') }}</span>
            </a>
        </div>
    </div>
</div>
<!-- END User Dropdown -->
