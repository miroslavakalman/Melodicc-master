<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Melodic') }}</title>
  <!-- сюда ваши стили и @stack('styles') -->
</head>
<body>
  @include('partials.header')

  <main>
    <div id="main-content">
      {{ $slot }}
    </div>
  </main>

  @include('partials.footer')

  <!-- сюда ваши скрипты и @stack('scripts') -->
</body>
</html>
