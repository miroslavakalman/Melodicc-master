{{-- resources/views/partials/header.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Melodic</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Pacifico&display=swap" rel="stylesheet">
  <style>
    body { font-family: "Exo 2"; }
    a { color: white; text-decoration: none; }
    .menu { font-size: 30px; }
    .logo { font-size: 60px; }
    header {
      background: #181818;
      padding: 16px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .men {
      display: flex;
      align-items: center;
      gap: 30px;
    }
    .search-form input {
      padding: 4px 8px;
      border-radius: 4px;
      background: #333;
      color: #fff;
      border: none;
    }
  </style>
</head>
<body>
<header>
  {{-- Логотип --}}
  <a href="{{ route('home') }}">
    <div id="logo-placeholder" class="logo">Melodic</div>
  </a>

  {{-- Меню для авторизованных --}}
  @auth
    <div class="men">
      <a href="{{ route('home') }}" class="menu">Главная</a>
      <a href="{{ route('tracks.create') }}" class="menu">Загрузить</a>
      <a href="{{ route('favorites') }}" class="menu">Любимое</a>
      {{-- Ссылка на личный кабинет с именем пользователя --}}
      <a href="{{ route('dashboard') }}" class="menu">{{ auth()->user()->name }}</a>
    </div>

    {{-- Поисковая форма --}}
    <form action="{{ route('search') }}" method="GET" class="search-form">
      <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="Искать…"
      />
    </form>
  @endauth

  {{-- Меню для гостей --}}
  @guest
    <div class="men">
      <a href="{{ route('login') }}" class="menu">Войти</a>
      @if (Route::has('register'))
        <a href="{{ route('register') }}" class="menu">Регистрация</a>
      @endif
    </div>
  @endguest
</header>
</body>
</html>
