<div x-data="{open: false}">
    {{ $trigger }}
    <div class="modal" style="display: none" x-show="open">
        <div class="modal-bg"></div>
        <div class="modal-wrapper" @click.away="open = false">
            <div class="modal-header">
                <div class="relative">
                    {{ $header }}
                    <button type="button" class="absolute right-1 top-1/2 -translate-y-1/2"
                            @click="open = false">x</button>
                </div>
            </div>
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
</div>
