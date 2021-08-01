<div 
    x-data="{ 
        open: @entangle('open'),
        close() {
            this.open = false;
            document.body.style.overflowY='';
        },
        updateOverflow() {
            document.body.style.overflowY = open ? 'hidden' : '';
        } 
    }"

    x-init="
        $watch('open', () => $dispatch('toggle-background-scroll', {}));
        updateOverflow();
    "
    
    @toggle-background-scroll="updateOverflow()"
>
    @if($open)
        <div class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-75">
            <x-dynamic-component :component="$view" :data="$data"/>
        </div>
    @endif
</div>
