<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;

class WaveController extends Controller
{
    public function index()
    {
        // Для главной — передать все жанры
        $genres = \App\Models\Genre::all();
        return view('wave', compact('genres'));
    }

    public function random(Request $request)
    {
        $q = Track::query()->whereNull('banned_at');

        if ($ids = $request->query('genres')) {
            $q->whereHas('genres', fn($q2) => $q2->whereIn('genres.id', $ids));
        }

        $tracks = $q->inRandomOrder()->take(20)->get([
            'id','title','file_path','cover_path'
        ])->map(fn($t) => [
            'id'=>$t->id,
            'src'=>asset('storage/'.$t->file_path),
            'cover'=>asset('storage/'.($t->cover_path?:'covers/default.png')),
            'title'=>$t->title,
        ]);

        return response()->json($tracks);
    }
}

