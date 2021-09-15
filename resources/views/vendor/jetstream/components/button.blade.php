<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-900 focus:border-blue-300 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
