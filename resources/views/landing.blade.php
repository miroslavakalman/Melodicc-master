<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Melodic — музыкальный сервис нового поколения</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap" rel="stylesheet">
  <style>
    /* Общий сброс и переменные */
    :root {
      --primary: #1DB954;
      --dark: #191414;
      --light: #FFFFFF;
      --gray: #B3B3B3;
      --gradient: linear-gradient(135deg, var(--primary), var(--dark));
    }
    
    * { 
      margin:0; 
      padding:0; 
      box-sizing:border-box; 
    }
    
    html, body {
      height:100%;
      scroll-behavior: smooth;
      font-family: 'Montserrat', sans-serif;
      color: var(--light);
      background: var(--dark);
      overflow-x: hidden;
    }

    /* Навигация */
    .nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 2rem 4rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 100;
      mix-blend-mode: difference;
    }
    
    .nav-logo {
      font-size: 1.5rem;
      font-weight: 900;
      text-decoration: none;
      color: var(--light);
    }
    
    .nav-links {
      display: flex;
      gap: 2rem;
    }
    
    .nav-link {
      color: var(--light);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }
    
    .nav-link:hover {
      color: var(--primary);
    }
    
    .nav-cta {
      background: var(--light);
      color: var(--dark);
      padding: 0.75rem 1.5rem;
      border-radius: 2rem;
      font-weight: 700;
      transition: all 0.3s;
    }
    
    .nav-cta:hover {
      background: var(--primary);
      color: var(--light);
      transform: translateY(-2px);
    }

    /* Каждый экранный блок */
    section {
      width:100%;
      min-height:100vh;
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      text-align:center;
      padding: 6rem 2rem;
      position: relative;
      overflow: hidden;
    }
    
    .section-content {
      max-width: 1200px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }

    /* Герой */
    #hero {
      background: var(--gradient);
    }
    
    #hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('/images/hero-noise.png') repeat;
      opacity: 0.05;
      pointer-events: none;
      z-index: 1;
    }
    
    #hero h1 {
      font-size: 6rem;
      margin-bottom: 1.5rem;
      font-weight: 900;
      line-height: 1;
      background: linear-gradient(to right, var(--light), var(--primary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeIn 1s ease forwards 0.3s;
    }
    
    #hero p {
      font-size: 1.5rem;
      max-width: 600px;
      margin: 0 auto 3rem;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeIn 1s ease forwards 0.6s;
    }
    
    .hero-cta {
      display: inline-block;
      padding: 1rem 2.5rem;
      background: var(--light);
      color: var(--dark);
      border-radius: 3rem;
      font-weight: 700;
      text-decoration: none;
      font-size: 1.25rem;
      transition: all 0.3s;
      opacity: 0;
      transform: translateY(20px);
      animation: fadeIn 1s ease forwards 0.9s;
    }
    
    .hero-cta:hover {
      background: var(--primary);
      color: var(--light);
      transform: translateY(-5px) scale(1.05);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .hero-image-grid {
      position: absolute;
      width: 100%;
      height: 100%;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(3, 1fr);
      gap: 1rem;
      padding: 2rem;
      opacity: 0.7;
    }
    
    .hero-image {
      background-size: cover;
      background-position: center;
      border-radius: 0.5rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5);
      transition: all 0.5s ease;
    }
    
    .hero-image:nth-child(1) {
      grid-column: 1 / 2;
      grid-row: 1 / 3;
      transform: rotate(-5deg) translateY(50px);
      animation: float 8s ease-in-out infinite;
    }
    
    .hero-image:nth-child(2) {
      grid-column: 2 / 3;
      grid-row: 2 / 4;
      transform: rotate(3deg) translateY(30px);
      animation: float 6s ease-in-out infinite 1s;
    }
    
    .hero-image:nth-child(3) {
      grid-column: 3 / 4;
      grid-row: 1 / 3;
      transform: rotate(2deg) translateY(70px);
      animation: float 7s ease-in-out infinite 0.5s;
    }
    
    /* Преимущества */
    .advantage-section {
      background: rgba(0,0,0,0.5);
    }
    
    .advantage-section:nth-child(even) {
      background: linear-gradient(to right, rgba(0,0,0,0.8), rgba(29,185,84,0.1));
    }
    
    .advantage-section:nth-child(odd) {
      background: linear-gradient(to left, rgba(0,0,0,0.8), rgba(29,185,84,0.1));
    }
    
    .advantage-container {
      display: flex;
      align-items: center;
      gap: 4rem;
      max-width: 1200px;
    }
    
    .advantage-container.reverse {
      flex-direction: row-reverse;
    }
    
    .advantage-images {
      flex: 1;
      position: relative;
      min-height: 400px;
    }
    
    .stacked-image {
      position: absolute;
      border-radius: 0.5rem;
      box-shadow: 0 15px 40px rgba(0,0,0,0.4);
      transition: all 0.5s ease;
    }
    
    .stacked-image:nth-child(1) {
      width: 70%;
      height: 70%;
      top: 0;
      left: 0;
      z-index: 3;
      transform: rotate(-3deg);
    }
    
    .stacked-image:nth-child(2) {
      width: 65%;
      height: 65%;
      bottom: 0;
      right: 0;
      z-index: 2;
      transform: rotate(5deg);
    }
    
    .stacked-image:nth-child(3) {
      width: 60%;
      height: 60%;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(2deg);
      z-index: 1;
      opacity: 0.7;
    }
    
    .advantage-text {
      flex: 1;
      text-align: left;
    }
    
    .advantage-text h2 {
      font-size: 3rem;
      margin-bottom: 1.5rem;
      color: var(--primary);
    }
    
    .advantage-text p {
      font-size: 1.25rem;
      line-height: 1.6;
      margin-bottom: 2rem;
      color: var(--gray);
    }
    
    /* CTA */
    #cta {
      background: linear-gradient(135deg, var(--primary), var(--dark));
      text-align: center;
    }
    
    #cta h2 {
      font-size: 3.5rem;
      margin-bottom: 2rem;
      font-weight: 900;
    }
    
    #cta p {
      font-size: 1.5rem;
      max-width: 700px;
      margin: 0 auto 3rem;
      color: var(--gray);
    }
    
    .cta-buttons {
      display: flex;
      gap: 1.5rem;
      justify-content: center;
    }
    
    .cta-button {
      display: inline-block;
      padding: 1.25rem 2.5rem;
      border-radius: 3rem;
      font-weight: 700;
      text-decoration: none;
      font-size: 1.25rem;
      transition: all 0.3s;
    }
    
    .cta-primary {
      background: var(--light);
      color: var(--dark);
    }
    
    .cta-primary:hover {
      background: var(--primary);
      color: var(--light);
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .cta-secondary {
      background: transparent;
      color: var(--light);
      border: 2px solid var(--light);
    }
    
    .cta-secondary:hover {
      background: var(--light);
      color: var(--dark);
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    /* Анимации */
    @keyframes fadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0) rotate(-5deg);
      }
      50% {
        transform: translateY(-20px) rotate(5deg);
      }
    }
    
    /* Адаптивность */
    @media (max-width: 1024px) {
      .advantage-container {
        flex-direction: column;
        gap: 2rem;
      }
      
      .advantage-images {
        min-height: 300px;
        width: 100%;
      }
      
      .advantage-text {
        text-align: center;
      }
    }
    
    @media (max-width: 768px) {
      #hero h1 {
        font-size: 4rem;
      }
      
      .nav {
        padding: 1.5rem;
      }
      
      .nav-links {
        display: none;
      }
      
      .advantage-text h2 {
        font-size: 2rem;
      }
      
      #cta h2 {
        font-size: 2.5rem;
      }
    }
  </style>
</head>
<body>
  <!-- Навигация -->
  <nav class="nav">
    <a href="#" class="nav-logo">MELODIC</a>
    <div class="nav-links">
      <a href="#features" class="nav-link">Возможности</a>
      <a href="#community" class="nav-link">Сообщество</a>
      <a href="#premium" class="nav-link">Premium</a>
      @guest
        <a href="{{ route('register') }}" class="nav-cta">Начать бесплатно</a>
      @else
        <a href="{{ route('home') }}" class="nav-cta">Мой профиль</a>
      @endguest
    </div>
  </nav>

  <!-- 1. Hero -->
  <section id="hero">
    <div class="hero-image-grid">
      <div class="hero-image" style="background-image: url('/images/hero-image-1.jpg')"></div>
      <div class="hero-image" style="background-image: url('/images/hero-image-2.jpg')"></div>
      <div class="hero-image" style="background-image: url('/images/hero-image-3.jpg')"></div>
    </div>
    
    <div class="section-content">
      <h1>Погрузитесь в мир музыки</h1>
      <p>Открывайте, слушайте и делитесь своими музыкальными открытиями с Melodic</p>
      <a href="{{ route('register') }}" class="hero-cta">Начать бесплатно</a>
    </div>
  </section>

  <!-- 2. Advantage #1 -->
  <section class="advantage-section" id="features">
    <div class="advantage-container">
      <div class="advantage-images">
        <div class="stacked-image" style="background-image: url('/images/feature-1-main.jpg')"></div>
        <div class="stacked-image" style="background-image: url('/images/feature-1-alt.jpg')"></div>
        <div class="stacked-image" style="background-image: url('/images/feature-1-bg.jpg')"></div>
      </div>
      <div class="advantage-text">
        <h2>Ваша музыка. Ваш стиль.</h2>
        <p>Загружайте свои треки и альбомы в пару кликов. Настраивайте оформление профиля, создавайте коллекции и делитесь своим творчеством с миром.</p>
        <p>Поддержка всех форматов и качества звука вплоть до Hi-Res Audio.</p>
      </div>
    </div>
  </section>

  <!-- 3. Advantage #2 -->
  <section class="advantage-section">
    <div class="advantage-container reverse">
      <div class="advantage-images">
        <div class="stacked-image" style="background-image: url('/images/feature-2-main.jpg')"></div>
        <div class="stacked-image" style="background-image: url('/images/feature-2-alt.jpg')"></div>
        <div class="stacked-image" style="background-image: url('/images/feature-2-bg.jpg')"></div>
      </div>
      <div class="advantage-text">
        <h2>Умные плейлисты</h2>
        <p>Лайкайте любимые треки и формируйте персональные плейлисты. Наш алгоритм изучает ваши вкусы и предлагает идеальные подборки.</p>
        <p>Создавайте совместные плейлисты с друзьями и коллегами.</p>
      </div>
    </div>
  </section>

  <!-- 4. Advantage #3 -->
  <section class="advantage-section" id="community">
    <div class="advantage-container">
      <div class="advantage-images">
        <div class="stacked-image" style="background-image: url('/images/feature-3-main.jpg')"></div>
        <div class="stacked-image" style="background-image: url('/images/feature-3-alt.jpg')"></div>
        <div class="stacked-image" style="background-image: url('/images/feature-3-bg.jpg')"></div>
      </div>
      <div class="advantage-text">
        <h2>Музыкальное сообщество</h2>
        <p>Открывайте новые жанры и находите вдохновение. Обсуждайте треки с другими меломанами, следите за любимыми исполнителями и будьте в курсе новых релизов.</p>
        <p>Участвуйте в голосованиях и формируйте музыкальные тренды.</p>
      </div>
    </div>
  </section>

  <!-- 5. CTA -->
  <section id="cta">
    <div class="section-content">
      <h2>Готовы начать музыкальное путешествие?</h2>
      <p>Присоединяйтесь к миллионам пользователей Melodic прямо сейчас</p>
      
      <div class="cta-buttons">
        @guest
          <a href="{{ route('register') }}" class="cta-button cta-primary">Зарегистрироваться</a>
          <a href="{{ route('login') }}" class="cta-button cta-secondary">Войти</a>
        @else
          <a href="{{ route('home') }}" class="cta-button cta-primary">Перейти к музыке</a>
        @endguest
      </div>
    </div>
  </section>

  <script>
    // Параллакс эффект для изображений
    document.addEventListener('mousemove', (e) => {
      const heroImages = document.querySelectorAll('.hero-image');
      const x = e.clientX / window.innerWidth;
      const y = e.clientY / window.innerHeight;
      
      heroImages.forEach((img, i) => {
        const speed = (i + 1) * 0.02;
        const xMove = x * speed * 100;
        const yMove = y * speed * 100;
        img.style.transform = `translate(${xMove}px, ${yMove}px) rotate(${i % 2 ? '-' : ''}${speed * 5}deg)`;
      });
      
      const stackedImages = document.querySelectorAll('.stacked-image');
      stackedImages.forEach((img, i) => {
        const speed = (i + 1) * 0.01;
        const xMove = x * speed * 50;
        const yMove = y * speed * 50;
        const currentTransform = img.style.transform.match(/rotate\(([^)]+)\)/) || ['', '0deg'];
        img.style.transform = `translate(calc(-50% + ${xMove}px), calc(-50% + ${yMove}px)) rotate(${currentTransform[1]})`;
      });
    });
    
    // Плавное появление элементов при скролле
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.advantage-container').forEach(container => {
      observer.observe(container);
    });
  </script>
</body>
</html>