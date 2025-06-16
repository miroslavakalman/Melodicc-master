<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WaveController;
use App\Http\Controllers\AdminController;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenreController;

// Главный роут
Route::get('/', function (Request $request) {
    if (! auth()->check() && ! $request->hasCookie('visited')) {
        return response()
            ->view('landing')
            ->cookie('visited', '1', 60 * 24 * 365);
    }

    $albums = Album::latest()->take(12)->get();
    $genres = Genre::withCount('tracks')->get();
    $topTracks = Track::orderByDesc('play_count')
                      ->take(10)
                      ->get();
                      
    $featuredGenres = Genre::withCount('tracks')
        ->orderByDesc('tracks_count')
        ->limit(3)
        ->get()
        ->each(function($genre) {
            $genre->setRelation('featuredTracks', $genre->featuredTracks());
        });

    return view('welcome', compact('albums', 'genres', 'topTracks', 'featuredGenres'));
})->name('home');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Все маршруты, доступные только аутентифицированным пользователям
Route::middleware('auth')->group(function () {
    // Профиль
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');

    // Загрузка треков
    Route::get('/tracks/create', [TrackController::class, 'create'])->name('tracks.create');
    Route::post('/tracks',       [TrackController::class, 'store'])->name('tracks.store');

    // Создание альбомов
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');

    // Лайки (toggle)
    Route::post('/tracks/{track}/like', [LikeController::class, 'toggle'])
         ->name('tracks.like');

    // Страница «Любимые треки»
    Route::get('/favorites', function () {
        $tracks = auth()->user()->favorites()->with('artist')->get();
        return view('favorites', compact('tracks'));
    })->name('favorites');

    // Заявки на роль автора (только для админов)
    Route::middleware('can:admin')->group(function () {
        Route::post('/admin/requests/{request}/accept', [AdminController::class, 'acceptRequest'])
             ->name('admin.requests.accept');
        Route::post('/admin/requests/{request}/reject', [AdminController::class, 'rejectRequest'])
             ->name('admin.requests.reject');
    });
});

// Public: просмотр альбома
Route::get('/albums/{album}', [AlbumController::class, 'show'])
     ->name('albums.show');

// Поиск по трекам, альбомам и исполнителям
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Страница артиста
Route::get('/artists/{user}', function (User $user) {
    $albums = $user->albums()->with('artist')->latest()->get();
    $popularTracks = $user->tracks()
                          ->whereNull('banned_at')
                          ->latest()
                          ->take(10)
                          ->get();

    return view('artists.show', compact('user','albums','popularTracks'));
})->name('artists.show');

// Подключаем маршруты аутентификации
require __DIR__.'/auth.php';

// Wave-эффект
Route::get('/wave', [WaveController::class,'index'])->name('wave');
Route::get('/wave/random', [WaveController::class,'random']);

// Воспроизведение треков
Route::post('/tracks/{track}/play', [TrackController::class, 'incrementPlay'])
     ->name('tracks.play');

// Проверка статуса лайка
Route::get('/tracks/{track}/like/status', [LikeController::class, 'checkStatus'])
     ->name('tracks.like.status');

// Жанры
Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');
// Добавим в web.php после других маршрутов
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');
    Route::post('/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');
    Route::post('/users/{user}/delete', [AdminController::class, 'delete'])->name('admin.users.delete');
    Route::post('/users/{user}/assign-moderator', [AdminController::class, 'assignModerator'])->name('admin.users.assign-moderator');
    Route::post('/users/{user}/remove-moderator', [AdminController::class, 'removeModerator'])->name('admin.users.remove-moderator');
        Route::post('/requests/{request}/accept', [AdminController::class, 'acceptRequest'])
         ->name('admin.requests.accept');
    Route::post('/requests/{request}/reject', [AdminController::class, 'rejectRequest'])
         ->name('admin.requests.reject');
});
