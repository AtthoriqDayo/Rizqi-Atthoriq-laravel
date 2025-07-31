@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-black/20 border-2 border-white/70 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
