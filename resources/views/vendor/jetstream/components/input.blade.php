@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'focus:ring bg-black rounded-md shadow-sm']) !!}>
