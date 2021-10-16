<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/favicon.ico">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SaftCloud</title>
        <link  href="{{ mix('dist/css/app.css') }}" rel="stylesheet">
    </head>
    <body style="background: #3a3c40;">
        <noscript>
            <strong>We're sorry but SaftCloud doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
        </noscript>
        <div id="app"></div>
        <script defer src="{{ mix('dist/js/manifest.js') }}"></script>
        <script defer src="{{ mix('dist/js/vendor.js') }}"></script>
        <script defer src="{{ mix('dist/js/app.js') }}"></script>
