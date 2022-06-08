<x-app-layout>
    <x-slot name="title">{{ __('User Profile') }}</x-slot>
    {{ view('components.single.dashboard', ['user_id' => $user_id]) }}
</x-app-layout>
<?php
