<x-app-layout>
    <x-slot name="title">{{ __('Edit Profile') }}</x-slot>
    <link rel="stylesheet" href="{{ asset('assets/plugins/forms/forms.css') }}">
    {{ view('components.single.profileEdit', ['user_id' => $user_id]) }}
    <script src="{{ asset('assets/plugins/forms/forms.js') }}" defer></script>
</x-app-layout>

