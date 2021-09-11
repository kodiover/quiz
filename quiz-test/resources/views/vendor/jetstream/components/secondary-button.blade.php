<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-black border border-gray-300 rounded-md font-semibold text-xs text-gray-700 active:bg-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>