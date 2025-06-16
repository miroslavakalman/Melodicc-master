@extends('layouts.app')

@section('content')
<div class="search-results-container">
  <div class="search-header">
    <h1 class="search-title">Результаты поиска: <span class="search-query">"{{ $q }}"</span></h1>
  </div>

  <div class="results-sections">
    {{-- Треки --}}
    <section class="results-section">
      <div class="section-header">
        <h2 class="section-title">Треки</h2>
        @if(!$tracks->isEmpty())
    
        @endif
      </div>
      
      @if($tracks->isEmpty())
        <p class="empty-results">Ничего не найдено</p>
      @else
        <ul class="tracks-list">
          @foreach($tracks->take(5) as $track)
            <li class="track-item"
                data-id="{{ $track->id }}"
                data-src="{{ asset('storage/' . $track->file_path) }}"
                data-cover="{{ asset('storage/' . ($track->cover_path ?? 'covers/default.png')) }}"
                data-title="{{ $track->title }}"
                data-artist="{{ $track->artist->name }}">
              <div class="track-info">
                <img src="{{ asset('storage/' . ($track->cover_path ?? 'covers/default.png')) }}" 
                     alt="{{ $track->title }}" 
                     class="track-cover">
                <div class="track-details">
                  <span class="track-title">{{ $track->title }}</span>
                  <span class="track-artist">{{ $track->artist->name }}</span>
                </div>
              </div>
              <button class="play-button">
                <svg viewBox="0 0 24 24" width="20" height="20">
                  <path fill="currentColor" d="M8 5v14l11-7z"></path>
                </svg>
              </button>
            </li>
          @endforeach
        </ul>
      @endif
    </section>

    {{-- Альбомы --}}
    <section class="results-section">
      <div class="section-header">
        <h2 class="section-title">Альбомы</h2>
        @if(!$albums->isEmpty())

        @endif
      </div>
      
      @if($albums->isEmpty())
        <p class="empty-results">Ничего не найдено</p>
      @else
        <div class="albums-grid">
          @foreach($albums->take(4) as $album)
            <a href="{{ route('albums.show', $album) }}" class="album-card">
              <div class="album-cover-container">
                @if($album->cover_path)
                  <img src="{{ asset('storage/'.$album->cover_path) }}" 
                       alt="Обложка {{ $album->title }}" 
                       class="album-cover">
                @else
                  <div class="album-cover-placeholder"></div>
                @endif
              </div>
              <div class="album-info">
                <div class="album-title">{{ $album->title }}</div>
                <div class="album-artist">{{ $album->artist->name }}</div>
              </div>
            </a>
          @endforeach
        </div>
      @endif
    </section>

    {{-- Исполнители --}}
    <section class="results-section">
      <div class="section-header">
        <h2 class="section-title">Исполнители</h2>
        @if(!$artists->isEmpty())

        @endif
      </div>
      
      @if($artists->isEmpty())
        <p class="empty-results">Ничего не найдено</p>
      @else
        <div class="artists-grid">
          @foreach($artists->take(6) as $artist)
            <a href="{{ route('artists.show', $artist) }}" class="artist-card">
              <div class="artist-avatar">

              </div>
              <div class="artist-name">{{ $artist->name }}</div>
            </a>
          @endforeach
        </div>
      @endif
    </section>
  </div>
</div>

<style>
.search-results-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  color: white;
}

.search-header {
  margin-bottom: 30px;
}

.search-title {
  font-size: 28px;
  font-weight: 700;
}
a{
    color:white;
}
.search-query {
  color: #1db954;
}

.results-sections {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.results-section {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.section-title {
  font-size: 22px;
  font-weight: 700;
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

.empty-results {
  color: #b3b3b3;
  font-size: 16px;
}

/* Треки */
.tracks-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.track-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  border-radius: 4px;
  background: rgba(255, 255, 255, 0.03);
  transition: background 0.2s;
  cursor: pointer;
}

.track-item:hover {
  background: rgba(255, 255, 255, 0.08);
}

.track-info {
  display: flex;
  align-items: center;
  gap: 12px;
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
}

.play-button {
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  opacity: 0;
  transition: opacity 0.2s;
}

.track-item:hover .play-button {
  opacity: 1;
}

/* Альбомы */
.albums-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
}

.album-card {
  background: rgba(255, 255, 255, 0.03);
  border-radius: 6px;
  padding: 16px;
  transition: background 0.2s, transform 0.2s;
  text-decoration: none;
}

.album-card:hover {
  background: rgba(255, 255, 255, 0.08);
  transform: translateY(-2px);
}

.album-cover-container {
  margin-bottom: 12px;
  position: relative;
  padding-bottom: 100%;
}

.album-cover, .album-cover-placeholder {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 4px;
  object-fit: cover;
}

.album-cover-placeholder {
  background: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #b3b3b3;
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
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Исполнители */
.artists-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 20px;
}

.artist-card {
  background: rgba(255, 255, 255, 0.03);
  border-radius: 6px;
  padding: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  transition: background 0.2s, transform 0.2s;
  text-decoration: none;
}

.artist-card:hover {
  background: rgba(255, 255, 255, 0.08);
  transform: translateY(-2px);
}

.artist-avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: linear-gradient(135deg, #1db954, #1e3a8a);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 36px;
  font-weight: bold;
}

.artist-name {
  font-weight: 600;
  text-align: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Воспроизведение треков
  document.querySelectorAll('.track-item').forEach(item => {
    item.addEventListener('click', function(e) {
      // Игнорируем клики по кнопкам внутри трека
      if (e.target.closest('button')) return;
      
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