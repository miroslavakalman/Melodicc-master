@extends('layouts.app')

@section('content')
<div class="favorites-container">
  <div class="favorites-header">
    <div class="header-content">
      <div class="flex items-start gap-8">
        <!-- Место для обложки -->
        <div class="cover-placeholder" style="width: 250px; height: 250px; background: rgba(255,255,255,0.05); border-radius: 8px;">
          <img src="/images/Group 3.png" alt="облжка" style="width: 250px; height: 250px;">
        </div>
        
        <div class="flex-1">
          <div class="flex items-center gap-4 mb-4">
            <h1 class="text-4xl font-bold">Мне нравится</h1>
            <button class="play-all-button">
              <svg viewBox="0 0 24 24" width="28" height="28">
                <path fill="currentColor" d="M8 5v14l11-7z"></path>
              </svg>
            </button>
          </div>
          
          <div class="flex items-center gap-6">
            <div>
              <p class="text-gray-300">{{ auth()->user()->name }}</p>
              <span class="text-sm text-gray-400">{{ $tracks->count() }} {{ trans_choice('трек|трека|треков', $tracks->count()) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="tracks-list-container">
    @if($tracks->isEmpty())
      <div class="empty-state">
        <div class="empty-icon">🎵</div>
        <h3 class="empty-title">Нет любимых треков</h3>
        <p class="empty-text">Сохраняйте понравившиеся треки, нажимая на сердечко</p>
        <a href="{{ route('home') }}" class="discover-button">Найти музыку</a>
      </div>
    @else
      <div class="tracks-list-header">
        <div class="header-number">#</div>
        <div class="header-title">Название</div>
        <div class="header-artist">Исполнитель</div>
        <div class="header-duration">Длительность</div>
        <div class="header-actions"></div>
      </div>

      <ul class="tracks-list">
        @foreach($tracks as $index => $track)
          <li class="track-item group"
              data-id="{{ $track->id }}"
              data-src="{{ asset('storage/' . $track->file_path) }}"
              data-cover="{{ asset('storage/' . ($track->cover_path ?? 'covers/default.png')) }}"
              data-title="{{ $track->title }}"
              data-artist="{{ $track->artist->name }}">
            <div class="track-number">
              <span class="number">{{ $index + 1 }}</span>
              <button class="play-button hidden">
                <svg viewBox="0 0 24 24" width="16" height="16">
                  <path fill="currentColor" d="M8 5v14l11-7z"></path>
                </svg>
              </button>
            </div>
            <div class="track-info">
              <img src="{{ asset('storage/' . ($track->cover_path ?? 'covers/default.png')) }}" 
                   alt="{{ $track->title }}" 
                   class="track-cover">
              <div class="track-details">
                <span class="track-title">{{ $track->title }}</span>
                <span class="track-artist">{{ $track->artist->name }}</span>
              </div>
            </div>
            <div class="track-album">{{ $track->album->name ?? 'Без альбома' }}</div>
            <div class="track-duration">{{ gmdate('i:s', $track->duration) }}</div>
            <div class="track-actions">
              <form action="{{ route('tracks.like', $track) }}" method="POST" class="like-form">
                @csrf
                <button type="submit" class="like-button liked" title="Удалить из любимых">
                  <svg viewBox="0 0 24 24" width="20" height="20">
                    <path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
                  </svg>
                </button>
              </form>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</div>

<style>
.favorites-container {
  max-width: 1200px;
  margin: 0 auto;
  color: white;
}

.favorites-header {
  position: relative;
  padding: 30px;
  margin-bottom: 30px;
}

.header-content {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.cover-placeholder {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(255,255,255,0.3);
  font-size: 14px;
}

.play-all-button {
  background: #1db954;
  border: none;
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.2s;
}

.play-all-button:hover {
  transform: scale(1.05);
}

.play-all-button svg {
  margin-left: 3px;
}

.tracks-list-container {
  padding: 0 30px;
}

.tracks-list-header {
  display: grid;
  grid-template-columns: 50px 1fr 1fr 100px 50px;
  padding: 10px 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  color: #b3b3b3;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.tracks-list {
  margin: 0;
  padding: 0;
  list-style: none;
}

.track-item {
  display: grid;
  grid-template-columns: 50px 1fr 1fr 100px 50px;
  align-items: center;
  padding: 10px 0;
  border-radius: 4px;
  transition: background-color 0.2s;
}

.track-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.track-number {
  position: relative;
  text-align: center;
  color: #b3b3b3;
}

.track-item:hover .track-number .number {
  opacity: 0;
}

.track-item:hover .track-number .play-button {
  opacity: 1;
}

.play-button {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: none;
  border: none;
  color: white;
  opacity: 0;
  cursor: pointer;
}

.track-info {
  display: flex;
  align-items: center;
  gap: 15px;
}

.track-cover {
  width: 40px;
  height: 40px;
  object-fit: cover;
  border-radius: 4px;
}

.track-title {
  display: block;
  font-weight: 500;
}

.track-artist {
  display: block;
  font-size: 14px;
  color: #b3b3b3;
}

.track-duration {
  color: #b3b3b3;
}

.like-button {
  background: none;
  border: none;
  color: #b3b3b3;
  cursor: pointer;
  transition: transform 0.2s;
}

.like-button:hover {
  transform: scale(1.1);
}

.like-button.liked {
  color: #1db954;
}

.empty-state {
  text-align: center;
  padding: 60px 0;
}

.empty-icon {
  font-size: 60px;
  margin-bottom: 20px;
}

.empty-title {
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.empty-text {
  color: #b3b3b3;
  margin-bottom: 20px;
}

.discover-button {
  display: inline-block;

  color: white;
  padding: 10px 30px;
  border-radius: 20px;
  text-decoration: none;
  font-weight: bold;
  transition: transform 0.2s;
}

.discover-button:hover {
  transform: scale(1.05);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Воспроизведение всех треков
  document.querySelector('.play-all-button').addEventListener('click', function() {
    const tracks = Array.from(document.querySelectorAll('.track-item'));
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

  // Воспроизведение при клике на трек
  document.querySelectorAll('.track-item').forEach(item => {
    item.addEventListener('click', function(e) {
      // Игнорируем клики по кнопкам внутри трека
      if (e.target.closest('button') || e.target.closest('a')) return;
      
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