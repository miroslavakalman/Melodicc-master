<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Album;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * Показать страницу результатов поиска.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $tracks  = Track::where('title', 'like', "%{$q}%")->get();
        $albums  = Album::where('title', 'like', "%{$q}%")->get();
        $artists = User::where('name', 'like', "%{$q}%")->get();

        return view('search.results', compact('tracks','albums','artists','q'));
    }
}
