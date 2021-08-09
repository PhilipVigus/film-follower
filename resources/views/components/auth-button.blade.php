<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-bold text-white hover:bg-gray-700 active:bg-gray-900 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-200 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
