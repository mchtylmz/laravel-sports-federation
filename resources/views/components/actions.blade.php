@props([
    'id' => false,
    'edit' => false,
    'delete' => false,
    'deleteMessage' => __('table.delete_message')
])
<div class="btn-group">
    @if($edit)
        <a type="button" class="btn btn-sm btn-alt-info js-bs-tooltip-enabled" href="{{ $edit }}">
            <i class="fa fa-fw fa-eye"></i>
        </a>
        <a type="button" class="btn btn-sm btn-alt-warning js-bs-tooltip-enabled" href="{{ $edit }}">
            <i class="fa fa-fw fa-pencil-alt"></i>
        </a>
    @endif
    @if($delete && $id)
        <button type="button" class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled" data-toggle="delete" data-route="{{ $delete }}" data-message="{{ $deleteMessage }}" data-id="{{ $id }}">
            <i class="fa fa-fw fa-times"></i>
        </button>
    @endif
</div>
