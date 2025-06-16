<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1db954;
            --primary-hover: #1ed760;
            --bg: #121212;
            --card-bg: #181818;
            --text: #ffffff;
            --text-secondary: #b3b3b3;
            --error: #f15e6c;
            --input-bg: rgba(255,255,255,0.07);
            --input-border: rgba(255,255,255,0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 70% 30%, rgba(29, 185, 84, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        .register-container {
            width: 100%;
            max-width: 440px;
            padding: 48px 40px;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .register-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1db954, #1e3a8a);
        }

        .register-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .register-logo {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1db954, #1e3a8a);
            border-radius: 12px;
            color: white;
            font-size: 20px;
            font-weight: 700;
        }

        .register-title {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px;
            background: linear-gradient(90deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .register-subtitle {
            color: var(--text-secondary);
            font-size: 15px;
            line-height: 1.5;
            max-width: 320px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            color: var(--text);
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(29, 185, 84, 0.2);
            background: rgba(255,255,255,0.1);
        }

        .form-input::placeholder {
            color: rgba(255,255,255,0.3);
        }

        .error-message {
            color: var(--error);
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .error-message::before {
            content: '!';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background: var(--error);
            color: white;
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
        }

        .register-button {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            border: none;
            border-radius: 500px;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .register-button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(29, 185, 84, 0.3);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 15px;
            color: var(--text-secondary);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .login-link a:hover {
            color: var(--primary-hover);
        }

        .login-link a:hover::after {
            width: 100%;
        }

        .wave-decoration {
            position: absolute;
            bottom: -5%;
            left: -10%;
            width: 120%;
            height: 200px;
            background: linear-gradient(135deg, rgba(29, 185, 84, 0.08), rgba(30, 58, 138, 0.08));
            mask-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 1200 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' opacity='.25' fill='%23000000'/%3E%3Cpath d='M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z' opacity='.5' fill='%23000000'/%3E%3Cpath d='M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z' fill='%23000000'/%3E%3C/svg%3E");
            mask-repeat: repeat-x;
            mask-size: 1200px 120px;
            z-index: -1;
            opacity: 0.6;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 40px 24px;
                border-radius: 12px;
            }
            
            .register-title {
                font-size: 24px;
            }
            
            .register-subtitle {
                font-size: 14px;
            }
            
            .form-input {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="register-logo">♪</div>
            <h1 class="register-title">Создать аккаунт</h1>
            <p class="register-subtitle">Присоединяйтесь к музыкальному сообществу и откройте для себя мир безграничной музыки</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Введите ваше имя">
                @if ($errors->has('name'))
                    <span class="error-message">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="example@mail.com">
                @if ($errors->has('email'))
                    <span class="error-message">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Не менее 8 символов">
                @if ($errors->has('password'))
                    <span class="error-message">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Повторите ваш пароль">
                @if ($errors->has('password_confirmation'))
                    <span class="error-message">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <button type="submit" class="register-button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Зарегистрироваться
            </button>
        </form>

        <div class="login-link">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
        </div>
    </div>

    <div class="wave-decoration"></div>
</body>
</html>