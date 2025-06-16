@extends('layouts.app')

@section('content')
<div class="home-page">
  {{-- Моя волна --}}
  <section class="wave-section">
    <div class="wave-header">
      <h2 class="section-title">Моя волна</h2>
      <div class="wave-controls">
        <details class="wave-filter">
          <summary class="filter-summary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Выбрать жанры
          </summary>
          <div class="filter-options-container">
            <div class="filter-options">
              @foreach($genres as $genre)
                <label class="filter-option">
                  <input type="checkbox" class="wave-genre" value="{{ $genre->id }}">
                  <span class="genre-name">{{ $genre->name }}</span>
             
                </label>
              @endforeach
            </div>
          </div>
        </details>
        <button id="wave-play" class="wave-play-button">
          <svg class="play-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 3L19 12L5 21V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>
    <div class="wave-visual">
      <div class="wave-animation"></div>
    </div>
  </section>

  {{-- Подборки по жанрам --}}
  @foreach($featuredGenres as $genre)
    <section class="genre-section">
      <div class="section-header">
        <h2 class="section-title">{{ $genre->name }}</h2>
        <a href="{{ route('genres.show', $genre) }}" class="see-all">Смотреть все</a>
      </div>
      
      <div class="tracks-list">
        @foreach($genre->featuredTracks as $track)
          <li class="track-item" 
              data-id="{{ $track->id }}"
              data-src="{{ asset('storage/'.$track->file_path) }}"
              data-cover="{{ asset('storage/'.($track->cover_path ?? 'covers/default.png')) }}"
              data-title="{{ $track->title }}"
              data-artist="{{ $track->artist->name }}">
            <div class="track-number">{{ $loop->iteration }}</div>
            <div class="track-info">
              <img src="{{ asset('storage/'.($track->cover_path ?? 'covers/default.png')) }}" 
                  alt="{{ $track->title }}" 
                  class="track-cover">
              <div class="track-details">
                <div class="track-title">{{ $track->title }}</div>
                <div class="track-artist">{{ $track->artist->name }}</div>
              </div>
            </div>
            <div class="track-plays">{{ number_format($track->play_count, 0, ',', ' ') }}</div>
            <div class="track-duration">{{ gmdate('i:s', $track->duration) }}</div>
          </li>
        @endforeach
      </div>
    </section>
  @endforeach

  {{-- Новые альбомы --}}
  <section class="albums-section">
    <div class="section-header">
      <h2 class="section-title">Новые альбомы</h2>
      <a href="{{ route('search', ['type' => 'album']) }}" class="see-all">Смотреть все</a>
    </div>
    
    <div class="albums-grid">
      @foreach($albums as $album)
        <a href="{{ route('albums.show', $album) }}" class="album-card">
          <div class="album-cover-container">
            @if($album->cover_path)
              <img src="{{ asset('storage/'.$album->cover_path) }}" 
                   alt="{{ $album->title }}" 
                   class="album-cover">
            @else
              <div class="album-cover-placeholder">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 16L12 13M12 13L15 16M12 13V21M3 16V8C3 6.11438 3 5.17157 3.58579 4.58579C4.17157 4 5.11438 4 7 4H17C18.8856 4 19.8284 4 20.4142 4.58579C21 5.17157 21 6.11438 21 8V16C21 17.8856 21 18.8284 20.4142 19.4142C19.8284 20 18.8856 20 17 20H7C5.11438 20 4.17157 20 3.58579 19.4142C3 18.8284 3 17.8856 3 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            @endif
            <button class="album-play-button">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 3L19 12L5 21V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
          <div class="album-info">
            <div class="album-title">{{ $album->title }}</div>
            <div class="album-artist">{{ $album->artist->name }}</div>
            <div class="album-date">{{ $album->created_at->format('d.m.Y') }}</div>
          </div>
        </a>
      @endforeach
    </div>
  </section>

  {{-- Топ-10 по просмотрам --}}
  <section class="top-tracks-section">
    <div class="section-header">
      <h2 class="section-title">Топ-10 по просмотрам</h2>
    </div>
    
    <ol class="tracks-list">
      @foreach($topTracks as $track)
        <li class="track-item" 
            data-id="{{ $track->id }}"
            data-src="{{ asset('storage/'.$track->file_path) }}"
            data-cover="{{ asset('storage/'.($track->cover_path ?? 'covers/default.png')) }}"
            data-title="{{ $track->title }}"
            data-artist="{{ $track->artist->name }}">
          <div class="track-number">{{ $loop->iteration }}</div>
          <div class="track-info">
            <img src="{{ asset('storage/'.($track->cover_path ?? 'covers/default.png')) }}" 
                 alt="{{ $track->title }}" 
                 class="track-cover">
            <div class="track-details">
              <div class="track-title">{{ $track->title }}</div>
              <div class="track-artist">{{ $track->artist->name }}</div>
            </div>
          </div>
          <div class="track-plays">{{ number_format($track->play_count, 0, ',', ' ') }}</div>
          <div class="track-duration">{{ gmdate('i:s', $track->duration) }}</div>
        </li>
      @endforeach
    </ol>
  </section>
</div>

<style>
.home-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  color: white;
}

/* Общие стили секций */
.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.section-title {
  font-size: 24px;
  font-weight: 700;
  margin: 0;
}

.see-all {
  color: #b3b3b3;
  font-size: 14px;
  text-decoration: none;
  transition: color 0.2s;
}

.see-all:hover {
  color: white;
  text-decoration: underline;
}

/* Секция "Моя волна" */
.wave-section {
  background: #121212;
  border-radius: 12px;
  padding: 30px;
  margin-bottom: 40px;
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(255,255,255,0.1);
}

.wave-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  position: relative;
  z-index: 2;
}

.wave-controls {
  display: flex;
  align-items: center;
  gap: 16px;
}

.wave-filter {
  position: relative;
}

.filter-summary {
  background: rgba(255,255,255,0.1);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 20px;
  padding: 8px 16px;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.2s;
  list-style: none;
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-summary:hover {
  background: rgba(255,255,255,0.2);
}

.filter-summary::-webkit-details-marker {
  display: none;
}

.filter-options-container {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  z-index: 100;
  display: none;
}

.wave-filter[open] .filter-options-container {
  display: block;
}

.filter-options {
  position: absolute;
  top: 50px;
  right: 0;
  background: #282828;
  border-radius: 8px;
  padding: 12px;
  min-width: 280px;
  max-height: 60vh;
  overflow-y: auto;
  box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}

.filter-option {
  display: flex;
  justify-content: space-between;
  padding: 10px 8px;
  color: #ddd;
  font-size: 14px;
  cursor: pointer;
  border-radius: 4px;
  transition: background 0.2s;
}

.filter-option:hover {
  background: rgba(255,255,255,0.1);
}

.genre-name {
  flex-grow: 1;
}

.genre-count {
  color: #b3b3b3;
  font-size: 12px;
}

.wave-play-button {
  background: #1db954;
  border: none;
  border-radius: 50%;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.2s, background 0.2s;
}

.wave-play-button:hover {
  background: #1ed760;
  transform: scale(1.05);
}

.play-icon {
  width: 24px;
  height: 24px;
  stroke: currentColor;
}

.wave-visual {
  position: relative;
  height: 120px;
  margin-top: 20px;
  overflow: hidden;
  border-radius: 8px;
}

.wave-animation {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, #1db954, #1e3a8a, #1db954);
  background-size: 200% 200%;
  animation: gradientWave 8s ease infinite;
}

@keyframes gradientWave {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Секции по жанрам */
.genre-section {
  margin-bottom: 40px;
}

.genre-section .section-title {
  color: #1db954;
}

/* Секция альбомов */
.albums-section {
  margin-bottom: 40px;
}

.albums-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 24px;
}

.album-card {
  text-decoration: none;
  color: white;
  transition: transform 0.2s;
}

.album-card:hover {
  transform: translateY(-4px);
}

.album-cover-container {
  position: relative;
  margin-bottom: 12px;
}

.album-cover {
  width: 100%;
  aspect-ratio: 1;
  border-radius: 4px;
  object-fit: cover;
  box-shadow: 0 8px 24px rgba(0,0,0,0.3);
}

.album-cover-placeholder {
  width: 100%;
  aspect-ratio: 1;
  background: #333;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #b3b3b3;
}

.album-play-button {
  position: absolute;
  bottom: 8px;
  right: 8px;
  background: #1db954;
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.2s, transform 0.2s;
}

.album-card:hover .album-play-button {
  opacity: 1;
}

.album-play-button:hover {
  transform: scale(1.05);
}

.album-play-button svg {
  width: 16px;
  height: 16px;
  stroke: currentColor;
}

.album-info {
  padding: 0 4px;
}

.album-title {
  font-weight: 600;
  margin-bottom: 4px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.album-artist {
  font-size: 14px;
  color: #b3b3b3;
  margin-bottom: 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.album-date {
  font-size: 12px;
  color: #777;
}

/* Секция топ-треков */
.top-tracks-section, .genre-section {
  margin-bottom: 40px;
}

.tracks-list {
  list-style: none;
  padding: 0;
  margin: 0;
  background: rgba(255,255,255,0.03);
  border-radius: 8px;
  overflow: hidden;
}

.track-item {
  display: flex;
  align-items: center;
  padding: 12px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  cursor: pointer;
  transition: background 0.2s;
}

.track-item:hover {
  background: rgba(255,255,255,0.08);
}

.track-number {
  width: 30px;
  color: #b3b3b3;
  font-size: 16px;
}

.track-info {
  display: flex;
  align-items: center;
  gap: 16px;
  flex: 1;
}

.track-cover {
  width: 40px;
  height: 40px;
  object-fit: cover;
  border-radius: 4px;
}

.track-details {
  display: flex;
  flex-direction: column;
}

.track-title {
  font-size: 16px;
  font-weight: 500;
}

.track-artist {
  font-size: 14px;
  color: #b3b3b3;
  margin-top: 2px;
}

.track-plays {
  width: 100px;
  text-align: right;
  color: #b3b3b3;
  font-size: 14px;
}

.track-duration {
  width: 60px;
  text-align: right;
  color: #b3b3b3;
  font-size: 14px;
}

/* Адаптивность */
@media (max-width: 768px) {
  .albums-grid {
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 16px;
  }
  
  .track-item {
    padding: 10px 12px;
  }
  
  .track-info {
    gap: 12px;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Воспроизведение "Моей волны"
  const waveBtn = document.getElementById('wave-play'),
        isGuest = @guest true @else false @endguest,
        loginUrl = "{{ route('login') }}";

  let waveStarted = false;

  waveBtn.onclick = async () => {
    if (!waveStarted) {
      if (isGuest) return window.location = loginUrl;
      
      const selected = Array.from(document.querySelectorAll('.wave-genre:checked'))
                          .map(ch => ch.value);
      const query = selected.length ? '?' + new URLSearchParams({ genres: selected }) : '';
      
      try {
        const res = await fetch('/wave/random' + query);
        const tracks = await res.json();
        if (!tracks.length) return;
        
        window.playerQueue = tracks.map(t => ({
          id: t.id,
          src: t.src,
          cover: t.cover,
          title: t.title,
          artist: t.artist
        }));
        
        window.playerIdx = 0;
        window.playCurrent();
        waveStarted = true;
        waveBtn.innerHTML = `
          <svg class="pause-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 5H7V19H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 5H15V19H17V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        `;
      } catch (error) {
        console.error('Error loading wave:', error);
      }
    } else {
      window.togglePlayback();
      if (audio.paused) {
        waveBtn.innerHTML = `
          <svg class="play-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 3L19 12L5 21V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        `;
      } else {
        waveBtn.innerHTML = `
          <svg class="pause-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 5H7V19H9V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 5H15V19H17V5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        `;
      }
    }
  };

  // Закрытие фильтра при клике вне его
  document.addEventListener('click', (e) => {
    const filter = document.querySelector('.wave-filter');
    const filterOptions = document.querySelector('.filter-options-container');
    if (filter.open && !filter.contains(e.target) && e.target !== filter) {
      filter.removeAttribute('open');
      filterOptions.style.display = 'none';
    }
  });

  // Воспроизведение альбома
  document.querySelectorAll('.album-play-button').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      const albumCard = this.closest('.album-card');
      const albumUrl = albumCard.href;
      
      // Здесь можно добавить логику для воспроизведения альбома
      // Например, загрузить треки альбома и добавить в очередь
      console.log('Play album:', albumUrl);
    });
  });

  // Воспроизведение треков
  document.querySelectorAll('.track-item').forEach(item => {
    item.addEventListener('click', function() {
      const container = this.closest('.tracks-list');
      const items = Array.from(container.querySelectorAll('.track-item'));
      
      window.playerQueue = items.map(el => ({
        id: el.dataset.id,
        src: el.dataset.src,
        cover: el.dataset.cover,
        title: el.dataset.title,
        artist: el.dataset.artist
      }));
      
      window.playerIdx = items.indexOf(this);
      window.playCurrent();
    });
  });
});
</script>
@endsection