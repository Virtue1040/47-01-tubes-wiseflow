@props(['value'])

<a {{ $attributes->merge(['class' => 'text-black dark:text-gray-300']) }}>
    {!! nl2br(e($value ?? $slot)) !!}
</a>
