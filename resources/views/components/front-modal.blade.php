<div class="modal">
    <div class="modal-bg"></div>
    <div class="modal-wrapper">
        @isset($header)
        <div class="modal-header">
            {{ $header }}
        </div>
        @endisset
        <div class="modal-content">
            {{ $slot }}
        </div>
        @isset($footer)
        <div class="modal-footer">
            {{ $footer }}
        </div>
        @endisset
    </div>
</div>
