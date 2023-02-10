<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon-globe.png') }}">
    <title>Code Challenge</title>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
