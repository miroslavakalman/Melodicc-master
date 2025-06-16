@extends('layouts.app')

@section('content')
<div class="genre-page">
  <div class="genre-header">
    <h1>{{ $genre->name }}</h1>
    <p>Популярные треки в этом жанре</p>
  </div>

  <ol class="tracks-list">
    @foreach($tracks as $track)
      <li class="track-item" 
          data-id="{{ $track->id }}"
          data-src="{{ $track->audioUrl }}"
          data-cover="{{ $track->coverUrl }}"
          data-title="{{ $track->title }}"
          data-artist="{{ $track->artist->name }}">
        <div class="track-number">{{ $loop->iteration }}</div>
        <div class="track-info">
          <img src="{{ $track->coverUrl }}" 
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

  {{ $tracks->links() }}
</div>

<style>
.genre-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  color: white;
}

.genre-header {
  margin-bottom: 30px;
  text-align: center;
}

.genre-header h1 {
  font-size: 32px;
  margin-bottom: 8px;
  color: #1db954;
}

.genre-header p {
  color: #b3b3b3;
  font-size: 16px;
}

/* Остальные стили такие же как в welcome.blade.php */
</style>
@endsection