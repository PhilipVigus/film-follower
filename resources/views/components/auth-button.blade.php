<button {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-bold text-white hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:ring focus:ring-gray-900 focus:ring-opacity-200 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
