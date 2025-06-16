@extends('layouts.app')


<style>
:root {
  --primary: #1DB954;
  --primary-hover: #1ED760;
  --dark-bg: #181818;
  --card-bg: #252525;
  --text-light: #B3B3B3;
  --text-white: #FFFFFF;
  --danger: #EF4444;
}

.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
  color: var(--text-white);
  font-family: 'Circular', sans-serif;
}

/* Header */
.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2.5rem;
}

.dashboard-title {
  font-size: 2.5rem;
  font-weight: 700;
  background: linear-gradient(90deg, var(--text-white), var(--text-light));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* Profile Card */
.profile-card {
  background: var(--dark-bg);
  border-radius: 1rem;
  padding: 2rem;
  display: flex;
  gap: 2rem;
  align-items: center;
  margin-bottom: 2rem;
  border: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.avatar {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid var(--primary);
  background: linear-gradient(135deg, var(--primary) 0%, #191414 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  font-weight: bold;
  color: var(--text-white);
  flex-shrink: 0;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.profile-info h2 {
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
  color: var(--text-white);
}

.profile-meta {
  color: var(--text-light);
  margin-bottom: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.role-badge {
  background: rgba(29, 185, 84, 0.15);
  color: var(--primary);
  padding: 0.25rem 0.75rem;
  border-radius: 1rem;
  font-size: 0.875rem;
  font-weight: 500;
}

.profile-actions {
  display: flex;
  gap: 1rem;
}

.btn {
  padding: 0.75rem 1.5rem;
  border-radius: 2rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s;
  cursor: pointer;
  font-size: 0.95rem;
}

.btn-primary {
  background: var(--primary);
  color: white;
  border: none;
}

.btn-primary:hover {
  background: var(--primary-hover);
  transform: translateY(-2px);
}

.btn-outline {
  background: transparent;
  color: var(--text-white);
  border: 1px solid var(--text-light);
}

.btn-outline:hover {
  border-color: var(--text-white);
  transform: translateY(-2px);
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: var(--card-bg);
  border-radius: 0.75rem;
  padding: 1.5rem;
  transition: transform 0.3s;
  border: 1px solid rgba(255,255,255,0.05);
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card h3 {
  color: var(--text-light);
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
}

.stat-card .value {
  font-size: 2rem;
  font-weight: 700;
  color: var(--text-white);
}

/* Role Sections */
.role-section {
  background: var(--dark-bg);
  border-radius: 1rem;
  padding: 2rem;
  margin-bottom: 2rem;
  border: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.section-title {
  font-size: 1.5rem;
  margin-bottom: 1.5rem;
  color: var(--primary);
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.action-list {
  list-style: none;
  padding: 0;
}

.action-item {
  margin-bottom: 0.75rem;
}

.action-link {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  border-radius: 0.5rem;
  color: var(--text-light);
  text-decoration: none;
  transition: all 0.2s;
}

.action-link:hover {
  background: rgba(255,255,255,0.05);
  color: var(--primary);
}

.action-link svg {
  width: 24px;
  height: 24px;
  flex-shrink: 0;
}

/* Admin specific */
.requests-list {
  list-style: none;
  padding: 0;
}

.request-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background: rgba(255,255,255,0.03);
  border-radius: 0.5rem;
  margin-bottom: 0.75rem;
  border: 1px solid rgba(255,255,255,0.05);
}

.request-info {
  flex: 1;
}

.request-info strong {
  display: block;
  margin-bottom: 0.25rem;
}

.request-info span {
  color: var(--text-light);
  font-size: 0.875rem;
}

.request-actions {
  display: flex;
  gap: 0.5rem;
}

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
  border-radius: 0.5rem;
}

.btn-success {
  background: var(--primary);
  color: white;
  border: none;
}

.btn-danger {
  background: var(--danger);
  color: white;
  border: none;
}

/* Artist stats */
.genre-stats {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-bottom: 1.5rem;
}

.genre-badge {
  background: rgba(30,215,96,0.1);
  color: var(--primary);
  padding: 0.5rem 1rem;
  border-radius: 1rem;
  font-size: 0.875rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

/* Moderation */
.content-list {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1.5rem;
}

.content-list th, .content-list td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

.content-list th {
  color: var(--text-light);
  font-weight: 500;
  font-size: 0.875rem;
}

.content-list tr:hover {
  background: rgba(255,255,255,0.03);
}

.empty-message {
  color: var(--text-light);
  font-style: italic;
  padding: 1rem;
  text-align: center;
}

@media (max-width: 768px) {
  .profile-card {
    flex-direction: column;
    text-align: center;
  }
  
  .profile-actions {
    justify-content: center;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .request-item {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }
  
  .request-actions {
    width: 100%;
    justify-content: flex-end;
  }
}
</style>
<style>
:root {
  --primary: #1DB954;
  --primary-hover: #1ED760;
  --dark-bg: #181818;
  --card-bg: #252525;
  --text-light: #B3B3B3;
  --text-white: #FFFFFF;
  --danger: #EF4444;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s;
  cursor: pointer;
  font-size: 0.9rem;
  border: none;
}

.btn-sm {
  padding: 0.4rem 0.8rem;
  font-size: 0.8rem;
}

.btn-primary {
  background: var(--primary);
  color: white;
}

.btn-primary:hover {
  background: var(--primary-hover);
}

.btn-outline {
  background: transparent;
  color: var(--text-white);
  border: 1px solid var(--text-light);
}

.btn-outline:hover {
  border-color: var(--text-white);
}

.btn-danger {
  background: var(--danger);
  color: white;
}

.btn-danger:hover {
  opacity: 0.9;
}
</style>

@section('content')
<div class="dashboard-container">
  <div class="dashboard-header">
    <h1 class="dashboard-title">Личный кабинет</h1>
    @if(auth()->user()->hasRole('admin'))
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
      </svg>
      Админ-панель
    </a>
    @endif
  </div>

  <!-- Profile Section -->
  <div class="profile-card">
    <div class="avatar">
      @if(auth()->user()->avatar_path)
        <img src="{{ Storage::url(auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}">
      @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      @endif
    </div>
    <div class="profile-content">
      <h2>{{ auth()->user()->name }}</h2>
      <div class="profile-meta">
        @if(auth()->user()->hasRole('artist'))
          <span class="role-badge">Артист</span>
        @elseif(auth()->user()->hasRole('moderator'))
          <span class="role-badge">Модератор</span>
        @elseif(auth()->user()->hasRole('admin'))
          <span class="role-badge">Администратор</span>
        @else
          <span class="role-badge">Пользователь</span>
        @endif
        <span>{{ auth()->user()->email }}</span>
      </div>
      <div class="profile-actions">
        <a href="{{ route('profile.edit') }}" class="btn btn-outline">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
          Редактировать
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16 17 21 12 16 7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Выйти
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Stats Section -->
  <div class="stats-grid">
    <div class="stat-card">
      <h3>Прослушано треков</h3>
      <div class="value">1,247</div>
    </div>
    <div class="stat-card">
      <h3>Время прослушивания</h3>
      <div class="value">142 ч</div>
    </div>
    <div class="stat-card">
      <h3>Любимых треков</h3>
      <div class="value">{{ auth()->user()->favorites()->count() }}</div>
    </div>
    <div class="stat-card">
      <h3>Активность</h3>
      <div class="value">Ежедневно</div>
    </div>
  </div>

  <!-- User Specific Content -->
  @if(auth()->user()->hasRole('user'))
  <div class="role-section">
    <h3 class="section-title">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
        <circle cx="12" cy="7" r="4"></circle>
      </svg>
      Для пользователей
    </h3>
    <ul class="action-list">
      <li class="action-item">
        <a href="{{ route('favorites') }}" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
          </svg>
          <span>Мои любимые треки</span>
        </a>
      </li>
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
          </svg>
          <span>Рекомендации</span>
        </a>
      </li>
      <li class="action-item">
        <form method="POST" action="{{ route('artist.request') }}" class="w-full">
          @csrf
          <button type="submit" class="action-link" style="width: 100%; text-align: left;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"></path>
              <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
              <line x1="12" y1="19" x2="12" y2="23"></line>
              <line x1="8" y1="23" x2="16" y2="23"></line>
            </svg>
            <span>Стать артистом</span>
          </button>
        </form>
      </li>
    </ul>
  </div>
  @endif

  <!-- Artist Specific Content -->
  @if(auth()->user()->hasRole('artist'))
  <div class="role-section">
    <h3 class="section-title">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18V5l12-2v13"></path>
        <circle cx="6" cy="18" r="3"></circle>
        <circle cx="18" cy="16" r="3"></circle>
      </svg>
      Для артистов
    </h3>
    
    <div style="margin-bottom: 2rem;">
      <h4 style="font-size: 1.25rem; margin-bottom: 1rem; color: var(--text-white);">Статистика прослушиваний</h4>
      <div class="stats-grid">
        <div class="stat-card">
          <h3>Всего прослушиваний</h3>
          <div class="value">{{ auth()->user()->tracks()->sum('play_count') }}</div>
        </div>
        <div class="stat-card">
          <h3>Треков</h3>
          <div class="value">{{ auth()->user()->tracks()->count() }}</div>
        </div>
        <div class="stat-card">
          <h3>Альбомов</h3>
          <div class="value">{{ auth()->user()->albums()->count() }}</div>
        </div>
      </div>
    </div>
    
    <ul class="action-list">
      <li class="action-item">
        <a href="{{ route('artists.show', auth()->user()) }}" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
          </svg>
          <span>Моя страница артиста</span>
        </a>
      </li>
      <li class="action-item">
        <a href="{{ route('tracks.create') }}" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"></path>
            <path d="M5 12h14"></path>
          </svg>
          <span>Загрузить новый трек</span>
        </a>
      </li>
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="9" y1="9" x2="15" y2="15"></line>
            <line x1="15" y1="9" x2="9" y2="15"></line>
          </svg>
          <span>Создать альбом</span>
        </a>
      </li>
    </ul>
  </div>
  @endif

  <!-- Moderator Specific Content -->
  @if(auth()->user()->hasRole('moderator'))
  <div class="role-section">
    <h3 class="section-title">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
      </svg>
      Модерация контента
    </h3>
    
    <div style="margin-bottom: 1.5rem;">
      <h4 style="font-size: 1.25rem; margin-bottom: 1rem; color: var(--text-white);">Последние жалобы</h4>
      @if($reports && $reports->count() > 0)
        <table class="content-list">
          <thead>
            <tr>
              <th>Контент</th>
              <th>Тип</th>
              <th>Жалоба</th>
              <th>Действия</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reports as $report)
            <tr>
              <td>{{ $report->content->title ?? 'Удалённый контент' }}</td>
              <td>{{ $report->content_type }}</td>
              <td>{{ $report->reason }}</td>
              <td>
                <button class="btn btn-sm btn-success">Принять</button>
                <button class="btn btn-sm btn-danger">Отклонить</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="empty-message">Нет новых жалоб</p>
      @endif
    </div>
    
    <ul class="action-list">
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
          <span>Модерация треков</span>
        </a>
      </li>
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="9" y1="9" x2="15" y2="15"></line>
            <line x1="15" y1="9" x2="9" y2="15"></line>
          </svg>
          <span>Модерация альбомов</span>
        </a>
      </li>
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span>Модерация артистов</span>
        </a>
      </li>
    </ul>
  </div>
  @endif

  <!-- Admin Specific Content -->
  @if(auth()->user()->hasRole('admin'))
  <div class="role-section">
    <h3 class="section-title">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"></path>
        <circle cx="12" cy="10" r="3"></circle>
        <circle cx="12" cy="12" r="10"></circle>
      </svg>
      Администрирование
    </h3>
    

    -->
    <ul class="action-list">
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
          </svg>
          <span>Управление пользователями</span>
        </a>
      </li>
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"></path>
            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
          </svg>
          <span>Управление контентом</span>
        </a>
      </li>
      <li class="action-item">
        <a href="#" class="action-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
          </svg>
          <span>Настройки системы</span>
        </a>
      </li>
    </ul>
  </div>
  @endif
</div>
@endsection