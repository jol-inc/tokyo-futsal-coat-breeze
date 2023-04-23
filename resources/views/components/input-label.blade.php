@props(['value'])

{{-- <label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}> --}}
<label {{ $attributes->merge(['class' => 'block font-medium text-base text-black-700']) }}>
    {{ $value ?? $slot }}
</label>
