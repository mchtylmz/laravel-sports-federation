@props([
    'id' => false,
    'edit' => false,
    'approve' => false,
    'approveMessage' => '',
    'view' => false,
    'delete' => false,
    'deleteMessage' => __('table.delete_message')
])
<div class="btn-group">
    @if($view)
        <button type="button" class="btn btn-sm btn-alt-info" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" data-toggle="view" data-route="{{ $view }}?format=json">
            <i class="fa fa-fw fa-eye"></i>
        </button>
    @endif
    @if($edit)
        <a type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled" href="{{ $edit }}">
            <i class="fa fa-fw fa-pencil-alt"></i>
        </a>
    @endif
    @if($approve && $id)
        <button type="button" class="btn btn-sm btn-alt-success js-bs-tooltip-enabled px-3" data-toggle="delete" data-route="{{ $approve }}" data-message="{{ $approveMessage }}" data-id="{{ $id }}">
            <i class="fa fa-fw fa-check-double fw-bold"></i>
        </button>
    @endif
    @if($delete && $id)
        <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-toggle="delete" data-route="{{ $delete }}" data-message="{{ $deleteMessage }}" data-id="{{ $id }}">
            <i class="fa fa-fw fa-trash-alt"></i>
        </button>
    @endif
</div>
