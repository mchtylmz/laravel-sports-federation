@props([
    'title' => '',
    'subtitle' => '',
    'options' => true,
    'class' => ''
])
<div>
    <!-- Your Block - block block-rounded block-mode-hidden -->
    <div class="block block-rounded {{ $class }}">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                {{ $title }}
                @if($subtitle)
                    <p class="text-muted text-capitalize mb-0" style="font-size: 13px">
                        {{ $subtitle }}
                    </p>
                @endif
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
