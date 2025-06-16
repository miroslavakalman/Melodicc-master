<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    // Какие поля можно массово заполнять (mass assignment)
    protected $fillable = [
        'title',
        'artist_id',
        'cover_path',
    ];

    /**
     * Автор (artist) — это пользователь с ролью author.
     */
    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    /**
     * Треки, входящие в этот альбом.
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
