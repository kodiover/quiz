@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-100 focus:ring focus:ring-indigo-100 focus-ring-opacity-1 rounded-md shadow-sm']) !!}>
