<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Отображает страницу альбома с треками.
     */
    public function show(Album $album)
    {
        $album->load('artist', 'tracks');
    
        // передаем обе переменные
        return view('albums.show', [
            'album'  => $album,
            'tracks' => $album->tracks,
        ]);
    }
    
}
