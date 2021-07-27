@if ($errors->any())
    <div class="mt-4 text-sm text-red-600 w-full">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif
