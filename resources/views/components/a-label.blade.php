@props(['value'])

<a {{ $attributes->merge(['class' => 'text-black dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</a>
