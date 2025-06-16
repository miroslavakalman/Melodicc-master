<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;

class LikeController extends Controller
{
    /**
     * Переключить лайк у трека для текущего пользователя.
     */
   // LikeController.php
public function toggle(Track $track)
{
    $user = auth()->user();
    $user->favorites()->toggle($track->id);
    
    return response()->json([
        'liked' => $user->favorites()->where('track_id', $track->id)->exists()
    ]);
}
}
