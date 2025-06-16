<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Casts\Attribute;
class Track extends Model
{
    protected $fillable = [
        'title',
        'artist_id',
        'album_id',
        'file_path',
        'cover_path',
        'duration',
        'play_count',
    ];

protected function audioUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('storage/'.$this->file_path)
        );
    }
        protected function coverUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cover_path 
                ? asset('storage/'.$this->cover_path)
                : asset('images/default-cover.jpg')
        );
    }
    public function artist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    /**
     * Альбом, в котором находится трек (или null для сингла).
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Пользователи, добавившие в «Любимое» — связь многие-ко-многим через pivot track_user.
     */
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'track_user',
            'track_id',
            'user_id'
        )->withTimestamps();
    }

    /**
     * Жанры трека: многие-ко-многим через pivot genre_track.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(
            Genre::class,
            'genre_track',
            'track_id',
            'genre_id'
        );
    }

    /**
     * Подборки (playlists), в которые включён трек.
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(
            Playlist::class,
            'playlist_track',
            'track_id',
            'playlist_id'
        )->withTimestamps();
    }

    /**
     * Возвращает топ-N треков по популярности (лайки + прослушивания).
     */
    public static function top(int $limit = 10)
    {
        return static::withCount('likedBy')
            ->orderByDesc('liked_by_count')
            ->orderByDesc('play_count')
            ->take($limit)
            ->get();
    }
}
