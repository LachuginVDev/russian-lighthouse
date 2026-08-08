<header class="header" data-header>
  <div class="container header__inner">
    <a class="header__logo" href="{{ route('home') }}#top" aria-label="Русский Маяк — на главную">
      <span class="header__logo-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24"><use href="#icon-beacon" /></svg>
      </span>
      Русский Маяк
    </a>

    <nav class="header__nav" aria-label="Основная навигация">
      <a class="header__link" href="{{ route('home') }}#about">О группе</a>
      <a class="header__link" href="{{ route('albums.index') }}">Музыка</a>
      <a class="header__link" href="{{ route('videos.index') }}">Видео</a>
      <a class="header__link" href="{{ route('photos.index') }}">Фото</a>
      <a class="header__link" href="{{ route('news.index') }}">Новости</a>
      <a class="header__link" href="{{ route('concerts.index') }}">Афиша</a>
      <a class="header__link" href="{{ route('home') }}#contacts">Контакты</a>
    </nav>

    <div class="header__actions">
      <a class="btn btn--primary btn--sm" href="{{ route('home') }}#fundraising">
        <svg aria-hidden="true"><use href="#icon-heart" /></svg>
        Поддержать
      </a>
      <button class="header__burger" type="button" data-nav-toggle aria-expanded="false" aria-controls="mobile-nav" aria-label="Открыть меню">
        <svg aria-hidden="true" data-nav-toggle-icon><use href="#icon-burger" /></svg>
      </button>
    </div>
  </div>
</header>

<nav class="mobile-nav" id="mobile-nav" data-mobile-nav aria-label="Мобильная навигация">
  <a class="mobile-nav__link" href="{{ route('home') }}#about" data-nav-link>О группе</a>
  <a class="mobile-nav__link" href="{{ route('albums.index') }}" data-nav-link>Музыка</a>
  <a class="mobile-nav__link" href="{{ route('videos.index') }}" data-nav-link>Видео</a>
  <a class="mobile-nav__link" href="{{ route('photos.index') }}" data-nav-link>Фото</a>
  <a class="mobile-nav__link" href="{{ route('news.index') }}" data-nav-link>Новости</a>
  <a class="mobile-nav__link" href="{{ route('concerts.index') }}" data-nav-link>Афиша</a>
  <a class="mobile-nav__link" href="{{ route('home') }}#fundraising" data-nav-link>Помощь</a>
  <a class="mobile-nav__link" href="{{ route('home') }}#contacts" data-nav-link>Контакты</a>
</nav>
