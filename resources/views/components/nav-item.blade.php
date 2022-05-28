@props(['active'])

@php
    $classes = 'item';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="icon">
        <span class="{{$attributes->get('icon')}}"></span>
    </span>
    <span class="label">{{ $slot }}</span>
</a>
