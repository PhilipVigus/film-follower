<div 
    x-data="{ open: @entangle('show') }"
    x-init="$watch('open', () => $dispatch('toggle-background-scroll', {}))"
    @toggle-background-scroll="document.body.style.overflowY = open ? 'hidden' : ''"
>
    @if($show)
            <div
                x-show="open" 
                class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-75" 
            >
                @includeWhen($show, 'modals.' . $view, $data)
            </div>
    @endif
</div>
