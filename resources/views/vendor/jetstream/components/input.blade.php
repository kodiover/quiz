@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'focus:border-blue-300 bg-black rounded-md shadow-sm']) !!}>
