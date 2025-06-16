<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Album;
use getID3;
use App\Models\Genre;

class TrackController extends Controller
{
    /**
     * Показ формы загрузки трека
     */
    public function create()
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole('author')) {
            abort(403, 'Только авторы могут загружать треки.');
        }

        $albums = $user->albums;
        $tracks = $user->tracks()
                     ->whereNull('banned_at')
                     ->latest()
                     ->get();
        $genres = Genre::all();

        return view('tracks.create', compact('albums', 'tracks', 'genres'));
    }

    /**
     * Обработка загрузки трека
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasRole('author')) {
            abort(403, 'Только авторы могут загружать треки.');
        }
        
        $mode = $request->input('mode', 'single');

        if ($mode === 'album') {
            return $this->handleAlbumUpload($request, $user);
        }

        return $this->handleSingleUpload($request, $user);
    }

    /**
     * Загрузка одиночного трека
     */
    protected function handleSingleUpload(Request $request, $user)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'track'     => 'required|file|mimes:mp3,wav,ogg|max:51200',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'album_id'  => 'nullable|exists:albums,id',
            'genre_id'  => 'required|exists:genres,id',
        ]);

        // Обработка аудиофайла
        $audioPath = $request->file('track')->store('tracks', 'public');
        
        // Анализ аудиофайла
        $getID3 = new getID3;
        $fileInfo = $getID3->analyze($request->file('track')->path());
        $duration = $fileInfo['playtime_seconds'] ?? null;

        // Обработка обложки
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('covers', 'public')
            : null;

        // Создание трека
        $track = Track::create([
            'title'      => $validated['title'],
            'artist_id'  => $user->id,
            'album_id'   => $validated['album_id'] ?? null,
            'file_path'  => $audioPath,
            'cover_path' => $coverPath,
            'duration'   => $duration,
        ]);

        // Привязка жанра
        $track->genres()->attach($validated['genre_id']);

        return back()->with('success', 'Трек успешно загружен!');
    }

    /**
     * Загрузка альбома с треками
     */
    protected function handleAlbumUpload(Request $request, $user)
    {
        $validated = $request->validate([
            'album_title'    => 'required|string|max:255',
            'tracks'         => 'required|array|min:1',
            'tracks.*'       => 'file|mimes:mp3,wav,ogg|max:51200',
            'track_titles'   => 'required|array|min:1',
            'track_titles.*' => 'required|string|max:255',
            'album_cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'album_genre_id' => 'required|exists:genres,id',
        ]);

        // Обработка обложки
        $coverPath = $request->hasFile('album_cover')
            ? $request->file('album_cover')->store('covers', 'public')
            : null;

        // Создание альбома
        $album = Album::create([
            'title'      => $validated['album_title'],
            'artist_id'  => $user->id,
            'cover_path' => $coverPath,
        ]);

        // Обработка треков
        $getID3 = new getID3;
        
        foreach ($request->file('tracks') as $i => $file) {
            $path = $file->store('tracks', 'public');
            
            $fileInfo = $getID3->analyze($file->path());
            $duration = $fileInfo['playtime_seconds'] ?? null;

            $track = Track::create([
                'title'      => $validated['track_titles'][$i],
                'artist_id'  => $user->id,
                'album_id'   => $album->id,
                'file_path'  => $path,
                'cover_path' => $coverPath,
                'duration'   => $duration,
            ]);

            $track->genres()->attach($validated['album_genre_id']);
        }

        return back()->with('success', 'Альбом и треки успешно загружены!');
    }
    public function getTrackInfo(Track $track)
    {
        return response()->json([
            'id'     => $track->id,
            'title'  => $track->title,
            'src'    => $track->audioUrl,
            'cover'  => $track->coverUrl,
            'artist' => $track->artist->name,
            'duration' => $track->duration
        ]);
    }
    public function incrementPlay(\App\Models\Track $track)
{
    // +1 к счётчику просмотров
    $track->increment('plays');
    // если хотите вернуть новый счётчик:
    return response()->json(['plays' => $track->plays]);
}

}