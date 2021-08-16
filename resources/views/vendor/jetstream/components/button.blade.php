<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest     active:bg-gray-900 focus:outline-none focus:ring disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
