<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name'];
    
    public function tracks()
    {
        return $this->belongsToMany(Track::class)->withCount('likedBy');
    }
    
    public function featuredTracks()
    {
        return $this->tracks()
            ->with('artist')
            ->orderByDesc('play_count')
            ->limit(5)
            ->get();
    }
}