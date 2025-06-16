@extends('layouts.app')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Админ-панель</h1>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="active">Главная</a>
            <a href="{{ route('admin.users') }}">Пользователи</a>
        </nav>
    </div>

    <div class="admin-stats">
        <div class="stat-card">
            <h3>Всего пользователей</h3>
            <div class="value">{{ User::count() }}</div>
        </div>
        <div class="stat-card">
            <h3>Заблокированных</h3>
            <div class="value">{{ User::whereNotNull('banned_at')->count() }}</div>
        </div>
        <div class="stat-card">
            <h3>Модераторов</h3>
            <div class="value">{{ User::whereHas('roles', fn($q) => $q->where('name', 'moderator'))->count() }}</div>
        </div>
    </div>

    <div class="admin-section">
        <h2>Последние пользователи</h2>
        <div class="user-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->hasRole('admin'))
                                <span class="badge admin">Админ</span>
                            @elseif($user->hasRole('moderator'))
                                <span class="badge moderator">Модератор</span>
                            @elseif($user->hasRole('artist'))
                                <span class="badge artist">Артист</span>
                            @else
                                <span class="badge user">Пользователь</span>
                            @endif
                        </td>
                        <td>
                            @if($user->isBanned())
                                <span class="badge banned">Заблокирован</span>
                            @else
                                <span class="badge active">Активен</span>
                            @endif
                        </td>
                        <td class="actions">
                            <div class="dropdown">
                                <button class="btn btn-sm">Действия</button>
                                <div class="dropdown-content">
                                    @if($user->isBanned())
                                        <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                            @csrf
                                            <button type="submit">Разблокировать</button>
                                        </form>
                                    @else
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('ban-form-{{ $user->id }}').showModal()">Заблокировать</a>
                                        <dialog id="ban-form-{{ $user->id }}">
                                            <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                                @csrf
                                                <h3>Блокировка пользователя {{ $user->name }}</h3>
                                                <select name="reason" required>
                                                    <option value="">Выберите причину</option>
                                                    <option value="Нарушение правил">Нарушение правил</option>
                                                    <option value="Спам">Спам</option>
                                                    <option value="Мошенничество">Мошенничество</option>
                                                    <option value="Другое">Другое</option>
                                                </select>
                                                <div class="dialog-actions">
                                                    <button type="button" onclick="this.closest('dialog').close()">Отмена</button>
                                                    <button type="submit">Подтвердить</button>
                                                </div>
                                            </form>
                                        </dialog>
                                    @endif
                                    
                                    @if(!$user->hasRole('moderator'))
                                        <form method="POST" action="{{ route('admin.users.assign-moderator', $user) }}">
                                            @csrf
                                            <button type="submit">Назначить модератором</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.remove-moderator', $user) }}">
                                            @csrf
                                            <button type="submit">Убрать модератора</button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('admin.users.delete', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>

    <div class="admin-section">
        <h2>Заблокированные пользователи</h2>
        @if($bannedUsers->count() > 0)
            <div class="user-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Причина</th>
                            <th>Дата блокировки</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bannedUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->ban_reason }}</td>
                            <td>{{ $user->banned_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm">Разблокировать</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $bannedUsers->links() }}
            </div>
        @else
            <p class="empty">Нет заблокированных пользователей</p>
        @endif
    </div>
</div>

<style>
.admin-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 1rem;
    color: var(--text-white);
    font-family: 'Circular', sans-serif;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.admin-header h1 {
    font-size: 2rem;
    font-weight: 700;
}

.admin-nav {
    display: flex;
    gap: 1rem;
}

.admin-nav a {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    color: var(--text-light);
    text-decoration: none;
    transition: all 0.2s;
}

.admin-nav a:hover, .admin-nav a.active {
    background: rgba(29, 185, 84, 0.2);
    color: var(--primary);
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--card-bg);
    border-radius: 0.75rem;
    padding: 1.5rem;
    text-align: center;
}

.stat-card h3 {
    color: var(--text-light);
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.stat-card .value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-white);
}

.admin-section {
    margin-bottom: 3rem;
}

.admin-section h2 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: var(--primary);
}

.user-table {
    background: var(--dark-bg);
    border-radius: 0.75rem;
    overflow: hidden;
}

.user-table table {
    width: 100%;
    border-collapse: collapse;
}

.user-table th, .user-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.user-table th {
    background: rgba(29, 185, 84, 0.1);
    color: var(--primary);
    font-weight: 600;
}

.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge.admin {
    background: rgba(239, 68, 68, 0.2);
    color: #EF4444;
}

.badge.moderator {
    background: rgba(59, 130, 246, 0.2);
    color: #3B82F6;
}

.badge.artist {
    background: rgba(139, 92, 246, 0.2);
    color: #8B5CF6;
}

.badge.user {
    background: rgba(75, 85, 99, 0.2);
    color: #4B5563;
}

.badge.banned {
    background: rgba(239, 68, 68, 0.2);
    color: #EF4444;
}

.badge.active {
    background: rgba(34, 197, 94, 0.2);
    color: #22C55E;
}

.actions .dropdown {
    position: relative;
    display: inline-block;
}

.actions .dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: var(--card-bg);
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 0.5rem;
    overflow: hidden;
}

.actions .dropdown-content form {
    width: 100%;
}

.actions .dropdown-content button {
    width: 100%;
    padding: 0.75rem 1rem;
    text-align: left;
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
}

.actions .dropdown-content button:hover {
    background: rgba(255,255,255,0.05);
    color: var(--primary);
}

.actions .dropdown-content button.delete {
    color: #EF4444;
}

.actions .dropdown:hover .dropdown-content {
    display: block;
}

.empty {
    color: var(--text-light);
    font-style: italic;
    padding: 2rem;
    text-align: center;
    background: var(--dark-bg);
    border-radius: 0.75rem;
}

dialog {
    border: none;
    border-radius: 0.75rem;
    padding: 1.5rem;
    background: var(--dark-bg);
    color: var(--text-white);
    width: 400px;
    max-width: 90%;
}

dialog h3 {
    margin-top: 0;
    margin-bottom: 1rem;
}

dialog select {
    width: 100%;
    padding: 0.75rem;
    border-radius: 0.5rem;
    background: var(--card-bg);
    border: 1px solid rgba(255,255,255,0.1);
    color: var(--text-white);
    margin-bottom: 1rem;
}

.dialog-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.dialog-actions button {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
}

.dialog-actions button[type="submit"] {
    background: var(--primary);
    color: white;
    border: none;
}

.pagination {
    display: flex;
    justify-content: center;
    padding: 1rem;
    background: var(--dark-bg);
}

.pagination a, .pagination span {
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.5rem;
    color: var(--text-light);
    text-decoration: none;
}

.pagination a:hover {
    background: rgba(29, 185, 84, 0.2);
    color: var(--primary);
}

.pagination .active {
    background: var(--primary);
    color: white;
}
</style>
@endsection