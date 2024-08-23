@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-800 dark:text-blue-300']) }}>
    {{ $value ?? $slot }}
</label>
