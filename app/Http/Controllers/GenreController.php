<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Отображает страницу жанра с треками
     */
    public function show(Genre $genre)
    {
        $tracks = $genre->tracks()
            ->with('artist')
            ->orderByDesc('play_count')
            ->paginate(20);

        return view('genres.show', compact('genre', 'tracks'));
    }
}