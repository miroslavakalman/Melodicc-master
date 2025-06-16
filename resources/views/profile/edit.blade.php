@extends('layouts.app')

@section('content')
<div class="profile-edit-container">
  <div class="profile-header">
    <h1 class="profile-title">Редактирование профиля</h1>
    
    @if(session('status') === 'profile-updated')
    <div class="success-message">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      Профиль успешно обновлён
    </div>
    @endif
  </div>

  <div class="profile-sections">
    <!-- Основная информация -->
    <section class="profile-section">
      <h2 class="section-title">Основная информация</h2>
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
    @csrf
    @method('PATCH')

        <!-- Аватар -->
         <!-- Аватар -->
    <div class="avatar-upload">
        <div class="avatar-preview">
            @if($user->avatar_path)
                <img src="{{ Storage::url($user->avatar_path) }}" alt="Аватар" class="avatar-image" id="avatar-preview">
            @else
                <div class="avatar-placeholder" id="avatar-preview">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <label class="avatar-upload-btn">
            <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*"/>
            <span>Изменить фото</span>
        </label>
        @error('avatar') <div class="error-message">{{ $message }}</div> @enderror
    </div>

        <!-- Имя -->
        <div class="form-group">
          <label class="form-label">Имя</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                 class="form-input @error('name') input-error @enderror" />
          @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                 class="form-input @error('email') input-error @enderror" />
          @error('email') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <!-- О себе -->
        <div class="form-group">
          <label class="form-label">О себе</label>
          <textarea name="bio" rows="3" class="form-textarea @error('bio') input-error @enderror">{{ old('bio', $user->bio) }}</textarea>
          @error('bio') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="save-btn">
          Сохранить изменения
        </button>
      </form>
    </section>

    <!-- Смена пароля -->
    <section class="profile-section">
      <h2 class="section-title">Смена пароля</h2>
      <form action="{{ route('password.update') }}" method="POST" class="profile-form">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="form-label">Текущий пароль</label>
          <input type="password" name="current_password" 
                 class="form-input @error('current_password') input-error @enderror" />
          @error('current_password') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label class="form-label">Новый пароль</label>
          <input type="password" name="password" 
                 class="form-input @error('password') input-error @enderror" />
          @error('password') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label class="form-label">Подтвердите пароль</label>
          <input type="password" name="password_confirmation" class="form-input" />
        </div>

        <button type="submit" class="save-btn">
          Обновить пароль
        </button>
      </form>
    </section>

    <!-- Удаление аккаунта -->
    <section class="profile-section danger-section">
      <h2 class="section-title text-red-400">Удаление аккаунта</h2>
      <p class="danger-text">После удаления аккаунта все ваши данные будут безвозвратно удалены.</p>
      
      <form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" id="delete-account-btn" class="delete-btn">
          Удалить аккаунт
        </button>
      </form>
    </section>
  </div>
</div>

<style>
  .profile-edit-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
    color: #E6E6E6;
  }

  .profile-header {
    margin-bottom: 2.5rem;
  }

  .profile-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #FAFAFF;
  }

  .success-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background-color: rgba(74, 222, 128, 0.15);
    color: #4ADE80;
    border-radius: 0.5rem;
    font-size: 0.9rem;
  }

  .profile-sections {
    display: flex;
    flex-direction: column;
    gap: 3rem;
  }

  .profile-section {
    background-color: #181818;
    border-radius: 0.75rem;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  }

  .danger-section {
    border: 1px solid rgba(239, 68, 68, 0.3);
  }

  .section-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: #FAFAFF;
  }

  .profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  .avatar-upload {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
  }

  .avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    background-color: #252525;
    border: 3px solid #333;
  }

  .avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: bold;
    color: #FAFAFF;
    background: linear-gradient(135deg, #1DB954 0%, #191414 100%);
  }

  .avatar-upload-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    background-color: #333;
    color: #FAFAFF;
    border-radius: 0.5rem;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
  }

  .avatar-upload-btn:hover {
    background-color: #444;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .form-label {
    font-size: 0.95rem;
    font-weight: 500;
    color: #B3B3B3;
  }

  .form-input, .form-textarea {
    background-color: #252525;
    border: 1px solid #333;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    color: #FAFAFF;
    font-size: 1rem;
    transition: all 0.2s;
    width: 100%;
    max-width: 400px;
  }

  .form-textarea {
    min-height: 100px;
    resize: vertical;
  }

  .form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: #1DB954;
    box-shadow: 0 0 0 2px rgba(29, 185, 84, 0.2);
  }

  .input-error {
    border-color: #EF4444;
  }

  .error-message {
    color: #EF4444;
    font-size: 0.85rem;
    margin-top: 0.25rem;
  }

  .save-btn {
    align-self: flex-start;
    padding: 0.75rem 1.5rem;
    background-color: #1DB954;
    color: white;
    border: none;
    border-radius: 2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 0.5rem;
  }

  .save-btn:hover {
    background-color: #1ed760;
    transform: translateY(-1px);
  }

  .danger-text {
    color: #B3B3B3;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
  }

  .delete-btn {
    padding: 0.75rem 1.5rem;
    background-color: rgba(239, 68, 68, 0.1);
    color: #EF4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 2rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
  }

  .delete-btn:hover {
    background-color: rgba(239, 68, 68, 0.2);
  }

  @media (max-width: 768px) {
    .profile-edit-container {
      padding: 1rem;
    }
    
    .profile-section {
      padding: 1.5rem;
    }
    
    .form-input, .form-textarea {
      max-width: 100%;
    }
  }
</style>

<script>
  document.getElementById('delete-account-btn').addEventListener('click', function() {
    if (confirm('Вы уверены, что хотите удалить свой аккаунт? Это действие нельзя отменить.')) {
      document.getElementById('delete-account-form').submit();
    }
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar-input');
    const avatarPreview = document.getElementById('avatar-preview');
    
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (avatarPreview.tagName === 'IMG') {
                        avatarPreview.src = e.target.result;
                    } else {
                        // Если это div с инициалами, заменяем на img
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.className = 'avatar-image';
                        newImg.id = 'avatar-preview';
                        avatarPreview.parentNode.replaceChild(newImg, avatarPreview);
                    }
                }
                
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Обработчик удаления аккаунта
    document.getElementById('delete-account-btn')?.addEventListener('click', function() {
        if (confirm('Вы уверены, что хотите удалить свой аккаунт? Это действие нельзя отменить.')) {
            document.getElementById('delete-account-form').submit();
        }
    });
});
</script>
@endsection