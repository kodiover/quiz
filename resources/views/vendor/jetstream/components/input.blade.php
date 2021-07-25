@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-300 focus-ring-opacity-1 rounded-md shadow-sm']) !!}>
