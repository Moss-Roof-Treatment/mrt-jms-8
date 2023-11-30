<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Do Not Index --}}
  <meta name="robots" content="noindex, nofollow">

  {{-- CSRF Token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- Title --}}
  <title>{{ config('app.name', 'JMS') }} @yield('title')</title>

  {{-- Scripts --}}
  <script src="{{ asset('js/app.js') }}" defer></script>

  {{-- Fonts --}}
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Maven+Pro&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

  {{-- Styles --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @stack('css')
</head>
<body>
  @include('partials.nav')
  @include('partials.iconMenu')
  @include('partials.messages')
  @yield('content')
  @stack('js')
</body>
</html>
