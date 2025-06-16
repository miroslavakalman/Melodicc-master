@extends('layouts.app')

<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: #121212;
        color: #fff;
    }

    .upload-modal {
        max-width: 600px;
        margin: 2rem auto;
        background: #181818;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.6);
        padding: 2rem;
        color: #eee;
    }

    .upload-modal h2 {
        margin-bottom: 1.5rem;
        font-size: 1.75rem;
        color: #fff;
        text-align: center;
    }

    .upload-modal label {
        font-weight: 600;
        margin-bottom: .5rem;
        display: block;
        color: #ccc;
    }

    .upload-modal input[type="text"],
    .upload-modal select,
    .upload-modal textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 1.5rem;
        background: #2a2a2a;
        border: 1px solid #333;
        border-radius: 6px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .mode-switch {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding: 8px;
        background: #2a2a2a;
        border-radius: 50px;
    }

    .mode-switch label {
        position: relative;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 50px;
        transition: all 0.3s;
        margin: 0;
    }

    .mode-switch input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .mode-switch input[type="radio"]:checked + span {
        color: #1DB954;
        font-weight: 600;
    }

    .custom-file {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .custom-file .filename {
        padding: 12px;
        background: #2a2a2a;
        color: #ccc;
        border: 1px solid #333;
        border-radius: 6px;
        min-height: 46px;
        line-height: 1.5;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        align-items: center;
    }

    .custom-file input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    #add-track-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1.5rem;
        background: #1DB954;
        color: #fff;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    button[type="submit"] {
        width: 100%;
        padding: 14px;
        background: #1DB954;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
        transition: all 0.3s;
    }

    .track-entry {
        padding: 1rem;
        background: #252525;
        border-radius: 6px;
        margin-bottom: 1rem;
        border-left: 3px solid #1DB954;
    }

    .alert {
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }

    .bg-green-600 {
        background-color: #1DB954;
    }

    .bg-red-600 {
        background-color: #EF4444;
    }

    .text-danger {
        color: #EF4444;
        font-size: 0.875rem;
        margin-top: -1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }
</style>


@section('content')
<div class="upload-modal">
    <h2>Загрузка трека или альбома</h2>

    @if(session('success') || session('error'))
        <div class="alert {{ session('success') ? 'bg-green-600' : 'bg-red-600' }}">
            {{ session('success') ?? session('error') }}
        </div>
    @endif

    <form action="{{ route('tracks.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
        @csrf

        <!-- Режим загрузки -->
        <div class="mode-switch">
            <label>
                <input type="radio" name="mode" value="single" checked id="mode-single">
                <span>Сингл</span>
            </label>
            <label>
                <input type="radio" name="mode" value="album" id="mode-album">
                <span>Альбом</span>
            </label>
        </div>

        <!-- Блок для сингла -->
        <div id="block-single">
            <div class="form-group">
                <label>Название трека *</label>
                <input type="text" name="title" value="{{ old('title') }}" required>
            </div>

            <div class="form-group">
                <label>Жанр *</label>
                <select name="genre_ids[]" multiple required>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Аудиофайл *</label>
                <div class="custom-file">
                    <div class="filename">Выберите файл</div>
                    <input type="file" name="track" accept=".mp3,.wav,.ogg" required>
                </div>
            </div>

            <div class="form-group">
                <label>Обложка</label>
                <div class="custom-file">
                    <div class="filename">Выберите файл</div>
                    <input type="file" name="cover" accept=".jpg,.jpeg,.png">
                </div>
            </div>
        </div>

        <!-- Блок для альбома -->
        <div id="block-album" style="display:none;">
            <div class="form-group">
                <label>Название альбома *</label>
                <input type="text" name="album_title" required>
            </div>

            <div class="form-group">
                <label>Жанр альбома *</label>
                <select name="album_genre_ids[]" multiple required>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="tracks-wrapper">
                <div class="track-entry">
                    <div class="form-group">
                        <label>Трек #1: название *</label>
                        <input type="text" name="track_titles[]" required>
                    </div>
                    <div class="form-group">
                        <label>Трек #1: файл *</label>
                        <div class="custom-file">
                            <div class="filename">Выберите файл</div>
                            <input type="file" name="tracks[]" accept=".mp3,.wav,.ogg" required>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="add-track-btn">+ Добавить трек</button>

            <div class="form-group">
                <label>Обложка альбома</label>
                <div class="custom-file">
                    <div class="filename">Выберите файл</div>
                    <input type="file" name="album_cover" accept=".jpg,.jpeg,.png">
                </div>
            </div>
        </div>

        <button type="submit" id="submit-btn">Загрузить</button>
    </form>
</div>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Элементы DOM
    const singleBlock = document.getElementById('block-single');
    const albumBlock = document.getElementById('block-album');
    const modeRadios = document.querySelectorAll('input[name="mode"]');
    const form = document.getElementById('upload-form');
    const submitBtn = document.getElementById('submit-btn');
    const addTrackBtn = document.getElementById('add-track-btn');
    const tracksWrapper = document.getElementById('tracks-wrapper');
    
    // Переключение между режимами
    modeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'single') {
                singleBlock.style.display = 'block';
                albumBlock.style.display = 'none';
            } else {
                singleBlock.style.display = 'none';
                albumBlock.style.display = 'block';
            }
        });
    });

    // Добавление треков в альбом
    let trackCount = 1;
    
    addTrackBtn.addEventListener('click', function() {
        trackCount++;
        const newTrack = document.createElement('div');
        newTrack.className = 'track-entry';
        newTrack.innerHTML = `
            <div class="form-group">
                <label>Трек #${trackCount}: название *</label>
                <input type="text" name="track_titles[]" placeholder="Название трека" required>
            </div>

            <div class="form-group">
                <label>Трек #${trackCount}: файл *</label>
                <div class="custom-file">
                    <div class="filename">Выберите файл</div>
                    <input type="file" name="tracks[]" accept=".mp3,.wav,.ogg" required>
                </div>
            </div>
        `;
        tracksWrapper.appendChild(newTrack);
        
        // Настройка обработчика для нового file input
        setupFileInput(newTrack.querySelector('input[type="file"]'));
    });

    // Обработка выбора файлов
    function setupFileInput(input) {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Выберите файл';
            this.previousElementSibling.textContent = fileName;
        });
    }

    // Инициализация всех file inputs
    document.querySelectorAll('.custom-file input[type="file"]').forEach(input => {
        setupFileInput(input);
    });

    // Проверка формы перед отправкой
    form.addEventListener('submit', function(e) {
        const mode = document.querySelector('input[name="mode"]:checked').value;
        let isValid = true;
        
        // Сбросим красные границы
        document.querySelectorAll('input, select').forEach(el => {
            el.style.borderColor = '';
        });
        
        if (mode === 'single') {
            const inputs = document.querySelectorAll('#block-single [required]');
            inputs.forEach(input => {
                if (!input.value) {
                    input.style.borderColor = 'red';
                    isValid = false;
                }
            });
        } else {
            const inputs = document.querySelectorAll('#block-album [required]');
            inputs.forEach(input => {
                // Для файлов проверяем files.length
                if (input.type === 'file') {
                    if (input.files.length === 0) {
                        input.style.borderColor = 'red';
                        isValid = false;
                    }
                } else if (!input.value) {
                    input.style.borderColor = 'red';
                    isValid = false;
                }
            });
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Заполните все обязательные поля!');
            return false;
        }
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Загрузка...';
    });
});
</script>
