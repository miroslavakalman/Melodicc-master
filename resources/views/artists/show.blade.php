@extends('layouts.app')

@section('content')
<div class="artist-page">
  {{-- Хедер артиста --}}
  <div class="artist-header">
    <div class="artist-avatar-container">
      @if($user->avatar_path)
        <img src="{{ asset('storage/'.$user->avatar_path) }}" 
             alt="{{ $user->name }}" 
             class="artist-avatar">
      @else
        <div class="artist-avatar-default">
          {{ substr($user->name, 0, 1) }}
        </div>
      @endif
    </div>

    <div class="artist-info">
      <div class="artist-type">ИСПОЛНИТЕЛЬ</div>
      <h1 class="artist-name">{{ $user->name }}</h1>
      
      <div class="artist-stats">
        <span>{{ $popularTracks->count() }} популярных треков</span>
        <span>{{ $albums->count() }} альбомов</span>
      </div>

      <div class="artist-actions">
        <button class="btn-play">
          <svg viewBox="0 0 24 24" width="16" height="16">
            <path fill="currentColor" d="M8 5v14l11-7z"></path>
          </svg>
          Слушать
        </button>
      </div>
    </div>
  </div>

  {{-- Основной контент --}}
  <div class="artist-content">
    {{-- Последний релиз --}}
    @if($latest = $albums->first())
    <div class="latest-release">
      <h2 class="section-title">Последний релиз</h2>
      <a href="{{ route('albums.show', $latest) }}" class="latest-release-card">
        <div class="latest-release-cover">
          @if($latest->cover_path)
            <img src="{{ asset('storage/'.$latest->cover_path) }}" 
                 alt="{{ $latest->title }}">
          @else
            <div class="cover-placeholder"></div>
          @endif
        </div>
        <div class="latest-release-info">
          <div class="release-title">{{ $latest->title }}</div>
          <div class="release-year">{{ $latest->created_at->format('Y') }}</div>
        </div>
      </a>
    </div>
    @endif

    {{-- Популярные треки --}}
    @if($popularTracks->isNotEmpty())
    <div class="popular-tracks">
      <h2 class="section-title">Популярные треки</h2>
      <ul class="tracks-list">
        @foreach($popularTracks as $track)
        <li class="track-item"
            data-id="{{ $track->id }}"
            data-src="{{ asset('storage/'.$track->file_path) }}"
            data-cover="{{ asset('storage/'.($track->cover_path ?? 'covers/default.png')) }}"
            data-title="{{ $track->title }}"
            data-artist="{{ $user->name }}">
          <div class="track-number">{{ $loop->iteration }}</div>
          <div class="track-info">
            <div class="track-title">{{ $track->title }}</div>
            <div class="track-plays">{{ number_format($track->play_count, 0, ',', ' ') }} прослушиваний</div>
          </div>
          <div class="track-duration">{{ gmdate('i:s', $track->duration) }}</div>
        </li>
        @endforeach
      </ul>
    </div>
    @endif

    {{-- Все альбомы --}}
    <div class="artist-albums">
      <h2 class="section-title">Альбомы</h2>
      <div class="albums-grid">
        @foreach($albums as $album)
        <a href="{{ route('albums.show', $album) }}" class="album-card">
          <div class="album-cover">
            @if($album->cover_path)
              <img src="{{ asset('storage/'.$album->cover_path) }}" 
                   alt="{{ $album->title }}">
            @else
              <div class="cover-placeholder"></div>
            @endif
          </div>
          <div class="album-info">
            <div class="album-title">{{ $album->title }}</div>
            <div class="album-year">{{ $album->created_at->format('Y') }}</div>
          </div>
        </a>
        @endforeach
      </div>
    </div>

    {{-- Биография --}}
    @if(!empty($user->bio))
    <div class="artist-bio">
      <h2 class="section-title">Об исполнителе</h2>
      <div class="bio-text">{{ $user->bio }}</div>
    </div>
    @endif
  </div>
</div>

<style>
.artist-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  color: white;
}

/* Хедер артиста */
.artist-header {
  display: flex;
  gap: 30px;
  margin-bottom: 40px;
}

.artist-avatar-container {
  flex-shrink: 0;
}

.artist-avatar {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  object-fit: cover;
  box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}

.artist-avatar-default {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: linear-gradient(135deg, #1db954, #1e3a8a);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 72px;
  font-weight: bold;
  box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}

.artist-info {
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
}

.artist-type {
  font-size: 14px;
  text-transform: uppercase;
  color: #b3b3b3;
  margin-bottom: 8px;
}

.artist-name {
  font-size: 48px;
  font-weight: 900;
  margin: 0 0 16px 0;
}

.artist-stats {
  display: flex;
  gap: 16px;
  color: #b3b3b3;
  font-size: 14px;
  margin-bottom: 24px;
}

.artist-actions {
  display: flex;
  gap: 16px;
}

.btn-play {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #1db954;
  color: #000;
  border: none;
  border-radius: 24px;
  padding: 12px 32px;
  font-size: 14px;
  font-weight: bold;
  cursor: pointer;
  transition: transform 0.2s, background 0.2s;
}

.btn-play:hover {
  background: #1ed760;
  transform: scale(1.03);
}

/* Секции */
.section-title {
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 20px 0;
}

/* Последний релиз */
.latest-release {
  margin-bottom: 40px;
}

.latest-release-card {
  display: flex;
  gap: 24px;
  text-decoration: none;
  color: white;
  transition: transform 0.2s;
}

.latest-release-card:hover {
  transform: translateY(-2px);
}

.latest-release-cover {
  width: 250px;
  height: 250px;
  flex-shrink: 0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0,0,0,0.5);
}

.latest-release-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.cover-placeholder {
  width: 100%;
  height: 100%;
  background: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #b3b3b3;
}

.latest-release-info {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.release-title {
  font-size: 36px;
  font-weight: 700;
  margin-bottom: 8px;
}

.release-year {
  font-size: 16px;
  color: #b3b3b3;
}

/* Популярные треки */
.popular-tracks {
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
  flex: 1;
  margin-left: 16px;
}

.track-title {
  font-size: 16px;
  font-weight: 500;
}

.track-plays {
  font-size: 14px;
  color: #b3b3b3;
  margin-top: 4px;
}

.track-duration {
  color: #b3b3b3;
  font-size: 14px;
}

/* Альбомы */
.artist-albums {
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

.album-cover {
  width: 100%;
  aspect-ratio: 1;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.3);
}

.album-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.album-title {
  font-weight: 600;
  margin-bottom: 4px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.album-year {
  font-size: 14px;
  color: #b3b3b3;
}

/* Биография */
.artist-bio {
  margin-bottom: 40px;
}

.bio-text {
  color: #b3b3b3;
  line-height: 1.6;
  max-width: 800px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

  // Воспроизведение всех популярных треков
  document.querySelector('.btn-play').addEventListener('click', function() {
    const tracks = Array.from(document.querySelectorAll('.track-item'));
    if (tracks.length === 0) return;
    
    window.playerQueue = tracks.map(track => ({
      id: track.dataset.id,
      src: track.dataset.src,
      cover: track.dataset.cover,
      title: track.dataset.title,
      artist: track.dataset.artist
    }));
    
    window.playerIdx = 0;
    window.playCurrent();
  });
});
</script>
@endsection