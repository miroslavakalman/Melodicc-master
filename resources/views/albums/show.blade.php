@extends('layouts.app')

@section('content')

<style>
  /* Контейнер страницы */
  .album-container {
    max-width: 1024px;
    margin: 0 auto;
    padding: 1rem;
    color: #eee;
  }
  /* Ссылка «назад» */
  .album-back {
    display: inline-block;
    margin-bottom: 1rem;
    color: #aaa;
    text-decoration: none;
    transition: color .2s;
  }
  .album-back:hover { color: #fff; }

  /* Хедер альбома: обложка + информация */
  .album-header {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 2rem;
    align-items: center;
  }
  .album-cover {
    flex-shrink: 0;
    width: 500px;
    height: 500px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.7);
    background: #333;
  }
  .album-info {
    flex: 1;
    min-width: 280px;
  }
  .album-info .label {
    text-transform: uppercase;
    color: #aaa;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
  }
  .album-info .title {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
    color: #fff;
  }
  .album-info .meta {
    color: #bbb;
    margin-bottom: 1.5rem;
  }
  .album-info .play-button {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.5rem;
    background: #ffa500;
    color: #000;
    font-weight: 600;
    border-radius: 999px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s;
  }
  .album-info .play-button:hover {
    background: #ffb733;
  }

  /* Список треков */
  .tracks-list {
    background: #1a1a1a;
    border-radius: 8px;
    overflow: hidden;
  }
  .tracks-list ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .tracks-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .75rem 1rem;
    border-bottom: 1px solid #333;
    cursor: pointer;
    transition: background .2s;
  }
  .tracks-list li:last-child {
    border-bottom: none;
  }
  .tracks-list li:hover {
    background: #2a2a2a;
  }
  .tracks-list .track-index {
    width: 2rem;
    color: #777;
  }
  .tracks-list .track-title {
    flex: 1;
    color: #fff;
  }
  .tracks-list .track-duration {
    width: 4rem;
    text-align: right;
    color: #777;
  }
    /* ======== Добавить в конец <style> ======== */

  /* 1) Подготовка li-к трекам для иконки */
  .tracks-list li {
    position: relative;              /* чтобы иконка позиционировалась относительно li */
    padding-left: 3rem;              /* отступ слева под иконку */
  }

  /* 2) Скрытая иконка */
  .tracks-list li .play-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    opacity: 0;
    transition: opacity .2s;
    pointer-events: none;
  }

  /* 3) При hover показываем иконку */
  .tracks-list li:hover .play-icon {
    opacity: 1;
  }

</style>

<div class="album-container">
  {{-- Назад к альбомам --}}
  <a href="{{ route('home') }}" class="album-back">← Назад к альбомам</a>

  {{-- Хедер альбома --}}
  <div class="album-header">
    @if($album->cover_path)
      <img 
        src="{{ asset('storage/' . $album->cover_path) }}" 
        alt="Обложка {{ $album->title }}" 
        class="album-cover"
      >
    @else
      <div class="album-cover"></div>
    @endif

    <div class="album-info">
      <div class="label">Альбом</div>
      <div class="title">{{ $album->title }}</div>
      <div class="meta">
        {{ $album->artist->name }} · {{ $album->created_at->format('Y') }}
      </div>
      <button class="play-button" onclick="document.querySelectorAll('.track-item')[0]?.click()">
        ▶ Слушать
      </button>
    </div>
  </div>

  {{-- Список треков --}}
  <div class="tracks-list">
  <ul>
    @foreach($album->tracks as $track)
    <li
  class="track-item"
  data-id="{{ $track->id }}"
  data-src="{{ asset('storage/'.$track->file_path) }}"
  data-cover="{{ asset('storage/'.($track->cover_path ?? 'covers/default.png')) }}"
  data-title="{{ $track->title }}"
>

        {{-- Добавляем иконку: --}}
        <img src="/images/play_icon.png" alt="Play" class="play-icon">

        <span class="track-index">{{ $loop->iteration }}</span>
        <span class="track-title">{{ $track->title }}</span>
        @if($track->duration)
          <span class="track-duration">{{ gmdate('i:s', $track->duration) }}</span>
        @endif
      </li>
    @endforeach
  </ul>
</div>

</div>

@endsection
