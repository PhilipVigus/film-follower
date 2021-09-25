@if ($errors->any())
    <div class="mt-4 w-full">
        @foreach ($errors->all() as $error)
            <p class="text-sm text-red-600">{{ $error }}</p>
        @endforeach
    </div>
@endif
