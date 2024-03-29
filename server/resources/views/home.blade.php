<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preload" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;400&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>SaftCloud</title>
</head>
<body  style="background: rgba(34, 37, 48, 1);overflow:hidden">
<noscript>
<strong>We're sorry but SaftCloud doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div id="app"></div>
<script  src="{{ mix('dist/js/manifest.js') }}"></script>
<script  src="{{ mix('dist/js/vendor.js') }}"></script>
<script  src="{{ mix('dist/js/app.js') }}"></script>
