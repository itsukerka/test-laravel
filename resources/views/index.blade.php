<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@isset($title)
            {{ $title }} |
        @endisset
        {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body class="antialiased">
<div id="_page">
    {{ view('components.header.header-1') }}
    @include('components.single.home')
    {{ view('components.footer.footer-1') }}
</div>

<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
