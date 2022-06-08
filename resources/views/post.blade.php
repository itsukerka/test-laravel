<x-app-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>
    {{ view('components.single.post', ['post' => $post]) }}
</x-app-layout>
