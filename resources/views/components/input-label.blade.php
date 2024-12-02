@props(['value'])

<label {{ $attributes->merge(['class' => 'block mb-2 text-xs font-medium text-white']) }}>
    {{ $value ?? $slot }}
</label>
