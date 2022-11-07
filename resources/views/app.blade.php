<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    {{--
    <meta name="description"
        content="OneUI Vue Edition is a Bootstrap 5 Admin Template &amp; UI Framework based on Vue.js 3. Created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow"> --}}

    <link rel="shortcut icon" href="{{ asset('/images/circle-cropped.png') }}">

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/images/circle-cropped.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/circle-cropped.png') }}">

    <!-- Fonts -->
    {{--
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body>
    <noscript>
        <strong>
            We're sorry but app doesn't work properly without JavaScript enabled. Please enable it to continue.
        </strong>
    </noscript>

    @inertia
</body>

</html>
