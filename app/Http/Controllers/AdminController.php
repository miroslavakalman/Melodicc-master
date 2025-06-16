<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ArtistRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    $users = User::latest()->paginate(10);
    $bannedUsers = User::whereNotNull('banned_at')->paginate(10);
    $artistRequests = ArtistRequest::with('user')->latest()->get();
    
    return view('admin.dashboard', compact('users', 'bannedUsers', 'artistRequests'));
}

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function ban(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $user->ban($request->reason);
        
        return back()->with('success', 'Пользователь заблокирован');
    }

    public function unban(User $user)
    {
        $user->unban();
        return back()->with('success', 'Пользователь разблокирован');
    }

    public function delete(User $user)
    {
        $user->delete();
        return back()->with('success', 'Пользователь удалён');
    }

    public function assignModerator(User $user)
    {
        $user->assignRole('moderator');
        return back()->with('success', 'Пользователю назначена роль модератора');
    }

    public function removeModerator(User $user)
    {
        $user->roles()->where('name', 'moderator')->delete();
        return back()->with('success', 'Роль модератора удалена');
    }

    public function acceptRequest(ArtistRequest $request)
    {
        $request->user->assignRole('author');
        $request->delete();
        
        return back()->with('success', 'Заявка принята');
    }

    public function rejectRequest(ArtistRequest $request)
    {
        $request->delete();
        
        return back()->with('success', 'Заявка отклонена');
    }
}