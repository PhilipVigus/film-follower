<div 
    x-data="{ 
        open: @entangle('open'),
        close() {
            this.open = false;
            document.body.style.overflowY='';
        },
        toggleBackgroundScrolling() {
            document.body.style.overflowY = document.body.style.overflowY === '' ? 'hidden' : '';
        } 
    }"

    x-init="
        document.body.style.overflowY = '';
        $watch('open', () => toggleBackgroundScrolling());
    "
>
    @if($open)
        <div class="fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-75">
            <x-dynamic-component :component="$view" :data="$data"/>
        </div>
    @endif
</div>
