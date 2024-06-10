@props([
    'title' => '',
    'options' => true
])
<div>
    <!-- Your Block -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                {{ $title }}
            </h3>

            @if($options)
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="fullscreen_toggle"></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="content_toggle"></button>
                </div>
            @endif


        </div>
        <div class="block-content fs-sm">
            {{ $slot }}

        </div>
    </div>
    <!-- END Your Block -->
</div>
