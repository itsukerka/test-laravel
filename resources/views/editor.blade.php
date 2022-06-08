<x-app-layout>
    <x-slot name="title">{{ __('Writing Post') }}</x-slot>
    {{ view('components.single.editor', ['editor' => $editor]) }}
</x-app-layout>
