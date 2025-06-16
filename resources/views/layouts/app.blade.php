<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Melodic') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  
  <style>
    /* === Базовые стили === */
    :root {
      --sidebar-width: 240px;
      --player-height: 89px;
      --border-radius: 8px;
      --gap: 16px;
      --content-padding: 24px;
      --primary-color: #1DB954;
      --text-color: #fff;
      --text-secondary: #b3b3b3;
      --bg-primary: #000;
      --bg-secondary: #181818;
      --bg-tertiary: #282828;
    }
    
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background: var(--bg-primary);
      color: var(--text-color);
      font-family: "Exo 2", sans-serif;
      display: flex;
      overflow-x: hidden;
    }
    
    /* === Анимации === */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes progress {
      from { width: 0; }
      to { width: 100%; }
    }
    
    /* === Боковое меню === */
    .sidebar {
      width: var(--sidebar-width);
      background: var(--bg-secondary);
      padding: var(--content-padding);
      height: 100vh;
      position: fixed;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      z-index: 100;
      border-right: 1px solid rgba(255,255,255,0.1);
      box-sizing: border-box;
    }
    
    .sidebar-content {
      flex: 1;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
    }
    
    .logo {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 30px;
      padding: 10px;
      color: var(--primary-color);
      text-align: center;
    }
    
    .menu-section {
      margin-bottom: 30px;
    }
    
    .menu-title {
      font-size: 12px;
      text-transform: uppercase;
      color: var(--text-secondary);
      margin-bottom: 15px;
      padding-left: 10px;
      letter-spacing: 1px;
    }
    
    .menu-item {
      display: flex;
      align-items: center;
      padding: 10px;
      border-radius: var(--border-radius);
      margin-bottom: 4px;
      color: var(--text-secondary);
      text-decoration: none;
      transition: all 0.3s ease;
      gap: 12px;
    }
    
    .menu-item:hover {
      background: var(--bg-tertiary);
      color: var(--text-color);
    }
    
    .menu-item.active {
      background: var(--bg-tertiary);
      color: var(--text-color);
      font-weight: 600;
    }
    
    .menu-icon {
      width: 20px;
      height: 20px;
      object-fit: contain;
    }
    
    /* === Основное содержимое === */
    .main-content {
      margin-left: var(--sidebar-width);
      flex: 1;
      padding: var(--content-padding);
      min-height: calc(100vh - var(--player-height));
      padding-bottom: calc(var(--player-height) + var(--content-padding));
      width: calc(100vw - var(--sidebar-width));
      box-sizing: border-box;
    }
    
    .content-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 var(--gap);
    }
    
    /* === PJAX-контейнер и анимации === */
    #pjax-container {
      position: relative;
      min-height: 60vh;
    }
    
    .pjax-page {
      animation: fadeIn 0.4s ease forwards;
    }
    
    .pjax-loader {
      position: fixed;
      top: 0;
      left: var(--sidebar-width);
      height: 3px;
      background: var(--primary-color);
      z-index: 1000;
      animation: progress 1s ease-out forwards;
      display: none;
    }
    
    /* === Верхняя панель === */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding: 0 var(--gap);
    }
    
    .search-form input {
      padding: 8px 15px;
      border-radius: 20px;
      background: #333;
      color: var(--text-color);
      border: none;
      width: 300px;
      font-size: 14px;
      transition: all 0.3s ease;
    }
    
    .search-form input:focus {
      outline: none;
      box-shadow: 0 0 0 2px var(--primary-color);
    }
    
    /* === Карточки === */
    .card {
      background: var(--bg-secondary);
      border-radius: var(--border-radius);
      padding: 16px;
      transition: all 0.3s ease;
      margin-bottom: var(--gap);
    }
    
    .card:hover {
      background: var(--bg-tertiary);
      transform: translateY(-2px);
    }
    
    /* === Плеер === */
    #bottom-player {
      position: fixed;
      bottom: 0;
      left: var(--sidebar-width);
      right: 0;
      height: var(--player-height);
      background: var(--bg-secondary);
      display: grid;
      grid-template-columns: 1fr 2fr 1fr;
      align-items: center;
      padding: 0 var(--content-padding);
      z-index: 100;
      border-top: 1px solid rgba(255,255,255,0.1);
      box-shadow: 0 -5px 20px rgba(0,0,0,0.3);
      box-sizing: border-box;
    }
    
    .player-track {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    #player-cover {
      width: 56px;
      height: 56px;
      object-fit: cover;
      border-radius: 4px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    
    .player-info {
      min-width: 0;
    }
    
    #player-title {
      font-size: 14px;
      font-weight: 600;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      margin-bottom: 4px;
    }
    
    #player-artist {
      font-size: 12px;
      color: var(--text-secondary);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .player-controls {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }
    
    .player-buttons {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    
    .player-progress {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
      max-width: 500px;
    }
    
    #seek-bar {
      flex: 1;
      height: 4px;
      background: #535353;
      border-radius: 2px;
      cursor: pointer;
      transition: height 0.2s;
    }
    
    #seek-bar:hover {
      height: 6px;
    }
    
    #seek-bar::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: var(--text-color);
      cursor: pointer;
    }
    
    .time-display {
      font-size: 12px;
      color: var(--text-secondary);
      min-width: 40px;
      text-align: center;
    }
    
    .player-extra {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 16px;
    }
    
    .player-button {
      background: none;
      border: none;
      cursor: pointer;
      color: var(--text-secondary);
      transition: all 0.2s;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }
    
    .player-button:hover {
      background: rgba(255,255,255,0.1);
      color: var(--text-color);
      transform: scale(1.1);
    }
    
    .player-button.active {
      color: var(--primary-color);
    }
    
    .player-icon {
      width: 20px;
      height: 20px;
      object-fit: contain;
    }
    
    /* === Текущий трек === */
    .track-item.now-playing {
      background: rgba(29, 185, 84, 0.1);
      border-left: 3px solid var(--primary-color);
    }
    
    /* === Профиль пользователя === */
    .user-profile {
      margin-top: auto;
      padding-top: 20px;
      border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .user-profile-link {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: var(--text-color);
      padding: 8px;
      border-radius: var(--border-radius);
      transition: background 0.3s;
      width: calc(100% - 16px);
      box-sizing: border-box;
    }
    
    .user-profile-link:hover {
      background: var(--bg-tertiary);
    }
    
    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--primary-color);
      flex-shrink: 0;
    }
    
    .user-name {
      font-size: 14px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    /* === Адаптивность === */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        width: 280px;
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
        width: 100vw;
      }
      
      #bottom-player {
        left: 0;
        grid-template-columns: 1fr;
        padding: 10px;
        gap: 10px;
      }
      
      .player-track, .player-controls, .player-extra {
        justify-content: center;
      }
      
      .pjax-loader {
        left: 0;
      }
    }
  </style>
</head>
<body>
  <!-- Боковое меню -->
  <div class="sidebar">
    <div class="sidebar-content">
      <div class="logo">Melodic</div>
      
      <div class="menu-section">
        <div class="menu-title">Меню</div>
        <a href="{{ route('home') }}" class="menu-item ajax-link {{ request()->routeIs('home') ? 'active' : '' }}">
          <img src="/images/home.png" class="menu-icon" alt="Главная">
          Главная
        </a>
        <a href="{{ route('search') }}" class="menu-item ajax-link {{ request()->routeIs('search') ? 'active' : '' }}">
          <img src="/images/search.png" class="menu-icon" alt="Поиск">
          Поиск
        </a>
      </div>
      
      <div class="menu-section">
        <div class="menu-title">Моя медиатека</div>
        <a href="{{ route('favorites') }}" class="menu-item ajax-link {{ request()->routeIs('favorites') ? 'active' : '' }}">
          <img src="/images/Ellipse 1.svg" class="menu-icon" alt="Избранное">
          Мне нравится
        </a>
      </div>
      
      @auth
      <div class="menu-section">
        <div class="menu-title">Создать</div>
        <a href="{{ route('tracks.create') }}" class="menu-item ajax-link {{ request()->routeIs('tracks.create') ? 'active' : '' }}">
          <img src="/images/Download.png" class="menu-icon" alt="Загрузить">
          Загрузить
        </a>
      </div>
      @endauth
    </div>
    
    <!-- Профиль пользователя -->
    <div class="user-profile">
      @auth
      <a href="{{ route('dashboard') }}" class="user-profile-link ajax-link">
        @if(auth()->user()->avatar_path)
          <img src="{{ Storage::url(auth()->user()->avatar_path) }}" class="user-avatar" alt="{{ auth()->user()->name }}">
        @else
          <div class="user-avatar" style="background: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
        @endif
        <div class="user-name">{{ auth()->user()->name }}</div>
      </a>
      @endauth
      
      @guest
      <div class="menu-section">
        <a href="{{ route('login') }}" class="menu-item ajax-link">Войти</a>
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="menu-item ajax-link">Регистрация</a>
        @endif
      </div>
      @endguest
    </div>
  </div>
  
  <!-- Основное содержимое -->
  <div class="main-content">
    <div class="content-container">
      <!-- Верхняя панель с поиском -->
      <div class="top-bar">
        <form action="{{ route('search') }}" method="GET" class="search-form">
          <input type="text" name="q" placeholder="Искать треки, альбомы..." value="{{ request('q') }}">
        </form>
      </div>
      
      <!-- Индикатор загрузки PJAX -->
      <div class="pjax-loader" id="pjax-loader"></div>
      
      <!-- PJAX-контейнер -->
      <main id="pjax-container">
        <div class="pjax-page">
          @yield('content')
        </div>
      </main>
    </div>
  </div>

  <!-- Нижний плеер -->
  <div id="bottom-player">
    <div class="player-track">
      <img id="player-cover" src="/images/default-cover.jpg" alt="Обложка">
      <div class="player-info">
        <div id="player-title">Не выбрано</div>
        <div id="player-artist">—</div>
      </div>
    </div>
    
    <div class="player-controls">
      <div class="player-buttons">
        <button id="play-pause" class="player-button" title="Play/Pause">
          <img src="/images/Polygon 1.svg" alt="Play/Pause" class="player-icon" id="play-pause-icon">
        </button>
      </div>
      <div class="player-progress">
        <span id="current-time" class="time-display">0:00</span>
        <input type="range" id="seek-bar" value="0" min="0" step="1">
        <span id="duration" class="time-display">0:00</span>
      </div>
    </div>
    
    <div class="player-extra">
      <button id="like-btn" class="player-button" title="Like/Unlike">
        <img src="/images/Ellipse 1.svg" alt="Like" class="player-icon" id="like-icon">
      </button>
      <button id="next-track" class="player-button" title="Next">
        <img src="/images/Group 2.svg" alt="Next" class="player-icon">
      </button>
    </div>
    
    <audio id="player-audio"></audio>
  </div>

  <!-- Скрипты -->
  <script>
  // Инициализация плеера
  document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('player-audio');
    const playBtn = document.getElementById('play-pause');
    const likeBtn = document.getElementById('like-btn');
    const nextBtn = document.getElementById('next-track');
    const playIcon = document.getElementById('play-pause-icon');
    const likeIcon = document.getElementById('like-icon');
    const cover = document.getElementById('player-cover');
    const titleEl = document.getElementById('player-title');
    const artistEl = document.getElementById('player-artist');
    const seekBar = document.getElementById('seek-bar');
    const curTime = document.getElementById('current-time');
    const dur = document.getElementById('duration');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Состояние плеера
    window.playerQueue = window.playerQueue || [];
    window.playerIdx = window.playerIdx || 0;
    window.currentTrack = window.currentTrack || null;
    window.likedTrackIds = @json(auth()->check() ? auth()->user()->favorites()->pluck('track_id')->toArray() : []);

    // Пути к иконкам
    const PLAY_ICON = '/images/Polygon 1.svg';
    const PAUSE_ICON = '/images/Group 1.svg';
    const HEART_ICON = '/images/Ellipse 1.svg';
    const HEART_FILLED_ICON = '/images/Ellipse 2.svg';

    // Обновление иконки лайка
    function updateLikeIcon() {
      if (!window.currentTrack) return;
      const isLiked = window.likedTrackIds.includes(window.currentTrack.id);
      likeBtn.classList.toggle('active', isLiked);
      likeIcon.src = isLiked ? HEART_FILLED_ICON : HEART_ICON;
    }

    // Форматирование времени
    function formatTime(s) {
      const m = Math.floor(s/60), sec = String(Math.floor(s%60)).padStart(2,'0');
      return `${m}:${sec}`;
    }

    // Обновление иконки play/pause
    function updatePlayIcon() {
      playIcon.src = audio.paused ? PLAY_ICON : PAUSE_ICON;
    }

    // Подсветка текущего трека
    function updateNowPlayingUI() {
      document.querySelectorAll('.track-item').forEach(item => {
        const isCurrent = window.currentTrack && 
                         parseInt(item.dataset.id) === window.currentTrack.id;
        item.classList.toggle('now-playing', isCurrent);
      });
    }

    // Воспроизведение текущего трека
    window.playCurrent = async function() {
      const t = window.playerQueue[window.playerIdx];
      if (!t) return;
      
      window.currentTrack = t;
      audio.src = t.src;
      cover.src = t.cover || '/images/default-cover.jpg';
      titleEl.textContent = t.title;
      artistEl.textContent = t.artist || 'Неизвестный исполнитель';
      
      try {
        await audio.play();
        updatePlayIcon();
        updateLikeIcon();
        updateNowPlayingUI();
        
        if (t.id) {
          fetch(`/tracks/${t.id}/play`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf }
          });
        }
      } catch (error) {
        console.error('Playback failed:', error);
      }
    };

    // Переключение play/pause
    window.togglePlayback = function() {
      if (audio.paused) {
        audio.play().catch(e => console.error('Playback failed:', e));
      } else {
        audio.pause();
      }
      updatePlayIcon();
    };

    // Следующий трек
    window.playNext = function() {
      if (window.playerQueue.length < 2) return;
      window.playerIdx = (window.playerIdx + 1) % window.playerQueue.length;
      window.playCurrent();
    };

    // Обработчик клика по треку
    function handleTrackClick(e) {
      const item = e.target.closest('.track-item');
      if (!item) return;
      
      const container = item.closest('.tracks-list') || document;
      const items = Array.from(container.querySelectorAll('.track-item'));
      
      window.playerQueue = items.map(el => ({
        id: +el.dataset.id,
        src: el.dataset.src,
        cover: el.dataset.cover,
        title: el.dataset.title,
        artist: el.dataset.artist
      }));
      
      window.playerIdx = items.indexOf(item);
      window.playCurrent();
    }

    // Инициализация событий плеера
    playBtn.onclick = window.togglePlayback;
    nextBtn.onclick = window.playNext;
    audio.onended = window.playNext;

    audio.onloadedmetadata = () => {
      seekBar.max = Math.floor(audio.duration);
      dur.textContent = formatTime(audio.duration);
    };
    
    audio.ontimeupdate = () => {
      seekBar.value = Math.floor(audio.currentTime);
      curTime.textContent = formatTime(audio.currentTime);
    };
    
    seekBar.oninput = () => {
      audio.currentTime = seekBar.value;
    };

    // Обработчик лайков
    likeBtn.onclick = async () => {
      if (!window.currentTrack?.id) return;
      
      const trackId = window.currentTrack.id;
      const wasLiked = window.likedTrackIds.includes(trackId);
      
      try {
        likeBtn.disabled = true;
        const newLikedState = !wasLiked;
        
        if (newLikedState) {
          window.likedTrackIds.push(trackId);
        } else {
          const index = window.likedTrackIds.indexOf(trackId);
          if (index !== -1) window.likedTrackIds.splice(index, 1);
        }
        
        updateLikeIcon();
        
        const response = await fetch(`/tracks/${trackId}/like`, {
          method: 'POST',
          headers: { 
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json'
          }
        });
        
        if (!response.ok) throw new Error('Request failed');
        
        const data = await response.json();
        if (data.liked !== newLikedState) {
          window.likedTrackIds = data.liked 
            ? [...window.likedTrackIds, trackId]
            : window.likedTrackIds.filter(id => id !== trackId);
          updateLikeIcon();
        }
        
      } catch (error) {
        console.error('Like error:', error);
        if (wasLiked) {
          window.likedTrackIds.push(trackId);
        } else {
          const index = window.likedTrackIds.indexOf(trackId);
          if (index !== -1) window.likedTrackIds.splice(index, 1);
        }
        updateLikeIcon();
      } finally {
        likeBtn.disabled = false;
      }
    };

    // Инициализация кликов по трекам
    document.addEventListener('click', handleTrackClick);
  });

  // PJAX навигация
  document.addEventListener('DOMContentLoaded', () => {
    const loader = document.getElementById('pjax-loader');
    const container = document.getElementById('pjax-container');
    
    // Функция загрузки контента
    async function loadContent(url, pushState = true) {
      try {
        // Показываем индикатор загрузки
        loader.style.display = 'block';
        
        // Получаем контент
        const res = await fetch(url, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        if (!res.ok) throw new Error(res.statusText);
        
        const html = await res.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newContent = doc.getElementById('pjax-container').innerHTML;
        const newTitle = doc.querySelector('title').textContent;
        
        // Анимация перехода
        container.querySelector('.pjax-page').classList.add('fade-out');
        await new Promise(r => setTimeout(r, 200));
        
        // Вставляем новый контент
        container.innerHTML = `<div class="pjax-page">${newContent}</div>`;
        document.title = newTitle;
        
        // Скрываем индикатор
        loader.style.display = 'none';
        
        // Обновляем историю
        if (pushState) {
          history.pushState(null, '', url);
        }
        
      } catch (error) {
        console.error('PJAX error:', error);
        loader.style.display = 'none';
        window.location.href = url;
      }
    }
    
    // Обработчик кликов
    document.addEventListener('click', async (e) => {
      const link = e.target.closest('a.ajax-link');
      if (!link || e.ctrlKey || e.metaKey) return;
      
      e.preventDefault();
      await loadContent(link.href);
    });
    
    // Обработчик истории
    window.addEventListener('popstate', () => {
      loadContent(location.href, false);
    });
  });
  </script>
</body>
</html>