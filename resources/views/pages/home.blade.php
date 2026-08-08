@extends('layouts.app')

@section('title', "Русский Маяк — официальный сайт музыкальной группы")
@section('description', "Русский Маяк — музыкальная группа, которая пишет песни о силе духа, ездит с концертами в госпитали и зону СВО, помогает военнослужащим. Слушайте музыку, следите за новостями и поддержите благотворительные сборы.")
@section('canonical_path', "/")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/main.js'])
@endsection

@section('content')
  <x-schema.music-group />

<!-- ================= HERO ================= -->
    <section class="hero" id="top" aria-label="Приветствие">
      <div class="hero__media" aria-hidden="true" data-hero-parallax>
        <div class="hero__media-layer" data-hero-img></div>
      </div>
      <div class="hero__beam" aria-hidden="true"></div>
      <canvas
        class="hero__particles"
        aria-hidden="true"
        data-particles
        data-particles-origin="[data-hero-beacon-origin]"
        data-particles-count="52"
        data-particles-spread="160"
      ></canvas>
      <div class="hero__overlay" aria-hidden="true"></div>

      <div class="container hero__inner">
        <div class="hero__content">
          <p class="eyebrow hero__eyebrow" data-reveal>{{ $settings->hero_eyebrow ?: 'Музыка. Память. Единство.' }}</p>
          <h1 class="hero__title" data-split-text>{{ $settings->hero_title ?: 'Русский Маяк' }}</h1>
          <p class="lead hero__subtitle" data-reveal>
            {{ $settings->hero_subtitle ?: 'Мы пишем песни о силе духа и едем туда, где эта сила нужна больше всего — в госпитали и в зону проведения СВО.' }}
          </p>
          <div class="hero__actions" data-reveal>
            <a class="btn btn--primary" href="#music">
              <svg aria-hidden="true"><use href="#icon-play" /></svg>
              Слушать музыку
            </a>
            <a class="btn btn--outline" href="#fundraising">Поддержать сбор</a>
          </div>
        </div>

        <div class="hero__visual" aria-hidden="true">
          <div class="hero__beacon">
            <span class="hero__beacon-rays"></span>
            <svg class="hero__beacon-svg" viewBox="0 0 240 360" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="heroBeaconTower" x1="120" y1="80" x2="120" y2="330" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#2a3348"/>
                  <stop offset="1" stop-color="#12161f"/>
                </linearGradient>
                <linearGradient id="heroBeaconLantern" x1="120" y1="48" x2="120" y2="96" gradientUnits="userSpaceOnUse">
                  <stop stop-color="#ffe7a8"/>
                  <stop offset="1" stop-color="#e6c67c"/>
                </linearGradient>
                <radialGradient id="heroBeaconHalo" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(120 68) rotate(90) scale(54)">
                  <stop stop-color="#ffe7a8" stop-opacity="0.85"/>
                  <stop offset="1" stop-color="#e6c67c" stop-opacity="0"/>
                </radialGradient>
              </defs>
              <ellipse cx="120" cy="328" rx="78" ry="14" fill="#0a0c10" opacity="0.55"/>
              <path d="M62 318h116l-10 18H72l-10-18Z" fill="#1a2030" stroke="#3a445c" stroke-width="1.5"/>
              <path d="M78 318V148h84v170H78Z" fill="url(#heroBeaconTower)" stroke="#4a5670" stroke-width="1.5"/>
              <path d="M78 200h84M78 248h84" stroke="#e6c67c" stroke-opacity="0.35" stroke-width="1.5"/>
              <path d="M96 148v170M144 148v170" stroke="#ffffff" stroke-opacity="0.06" stroke-width="10"/>
              <rect x="70" y="132" width="100" height="18" rx="2" fill="#1c2436" stroke="#5a6784" stroke-width="1.5"/>
              <path d="M88 132V98h64v34H88Z" fill="#161c2a" stroke="#6b7a99" stroke-width="1.5"/>
              <circle cx="120" cy="68" r="54" fill="url(#heroBeaconHalo)"/>
              <circle class="hero__beacon-origin" data-hero-beacon-origin cx="120" cy="72" r="10" fill="url(#heroBeaconLantern)"/>
              <path d="M98 98h44l-8-18H106l-8 18Z" fill="#2a3348" stroke="#7a879f" stroke-width="1.2"/>
              <path d="M104 80h32v18h-32V80Z" fill="#0f131c" stroke="#e6c67c" stroke-opacity="0.55" stroke-width="1.2"/>
              <path d="M112 80v18M128 80v18" stroke="#e6c67c" stroke-opacity="0.4"/>
              <path d="M100 64h40l-6-16H106l-6 16Z" fill="#243049" stroke="#c9b07a" stroke-width="1.2"/>
              <path d="M120 36v12" stroke="#ffe7a8" stroke-width="2" stroke-linecap="round"/>
              <circle cx="120" cy="34" r="3.5" fill="#ffe7a8"/>
            </svg>
          </div>
        </div>
      </div>

      <span class="hero__scroll">Листайте вниз</span>
    </section>

    <!-- ================= О ГРУППЕ ================= -->
    <section class="section" id="about" aria-labelledby="about-title">
      <div class="container about__grid">
        <div class="about__media" data-reveal>
          <div class="about__media-placeholder">
            <svg aria-hidden="true"><use href="#icon-camera" /></svg>
          </div>
          <span class="badge badge--gold about__badge">С 2016 года на сцене</span>
        </div>

        <div class="about__body">
          <p class="eyebrow" data-reveal>О группе</p>
          <h2 id="about-title" data-reveal>История, рождённая в поездках к&nbsp;тем, кто защищает страну</h2>
          <p class="lead" data-reveal>
            «Русский Маяк» начинался как небольшой музыкальный проект друзей — но после первой поездки с
            концертом в военный госпиталь всё изменилось. Мы поняли: наши песни нужны не только на сцене
            большого зала, но и в палатах, где выздоравливают бойцы, и у блиндажей, куда мы привозим музыку и
            слова поддержки.
          </p>
          <p data-reveal>
            Сегодня группа сочетает концертную деятельность с постоянной волонтёрской работой: мы ездим в зону
            СВО, выступаем перед военнослужащими, помогаем госпиталям и организуем благотворительные сборы.
            Каждый альбом — это часть нашей миссии: рассказывать правду, поддерживать тех, кто на передовой, и
            объединять людей вокруг общего дела.
          </p>

          <div class="about__stats" data-reveal>
            <div class="about__stat">
              <span class="about__stat-value" data-count="{{ $settings->stat_years }}">0</span>
              <span class="about__stat-label">Лет на сцене</span>
            </div>
            <div class="about__stat">
              <span class="about__stat-value" data-count="{{ $settings->stat_concerts }}">0</span>
              <span class="about__stat-label">Концертов</span>
            </div>
            <div class="about__stat">
              <span class="about__stat-value" data-count="{{ $settings->stat_trips }}">0</span>
              <span class="about__stat-label">Поездок в госпитали и зону СВО</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= МУЗЫКАЛЬНЫЙ ПЛЕЕР ================= -->
    <section class="section section--muted" id="music" aria-labelledby="music-title">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow" data-reveal>Музыка</p>
          <h2 id="music-title" data-reveal>Слушайте песни, которые звучат там, где должна быть тишина</h2>
        </div>

        <div class="player" data-reveal data-player>
          <div class="player__stage">
            <div class="player__cover" data-player-cover>
              <div class="player__cover-img" role="img" aria-label="Обложка альбома «Позывной Надежда»"></div>
            </div>

            <div class="player__track-info">
              <span class="player__track-title" data-player-title>Позывной Надежда</span>
              <span class="player__track-artist" data-player-artist>Русский Маяк</span>
            </div>

            <div class="player__wave" aria-hidden="true" data-player-wave></div>

            <div class="player__controls">
              <button class="player__control" type="button" data-player-prev aria-label="Предыдущий трек">
                <svg aria-hidden="true"><use href="#icon-prev" /></svg>
              </button>
              <button class="player__control player__control--play" type="button" data-player-play aria-label="Воспроизвести">
                <svg aria-hidden="true" data-player-play-icon><use href="#icon-play" /></svg>
              </button>
              <button class="player__control" type="button" data-player-next aria-label="Следующий трек">
                <svg aria-hidden="true"><use href="#icon-next" /></svg>
              </button>
            </div>

            <div class="player__seek">
              <span data-player-current>0:00</span>
              <span class="player__seek-track" data-player-seek>
                <span class="player__seek-fill" data-player-seek-fill></span>
                <input class="player__seek-input" type="range" min="0" max="100" value="0" aria-label="Перемотка трека" data-player-seek-input />
              </span>
              <span data-player-duration>0:00</span>
            </div>
          </div>

          <div class="player__list" role="list" aria-label="Плейлист" data-player-list>
            <button class="player__track is-active" type="button" role="listitem" data-track data-src="/audio/track-1.mp3" data-title="Позывной Надежда" data-artist="Русский Маяк" data-duration="3:42">
              <span class="player__track-index">01</span>
              <span class="player__track-name"><strong>Позывной Надежда</strong><span>Альбом «Свет с передовой»</span></span>
              <span class="player__track-duration">3:42</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/track-2.mp3" data-title="Маяк" data-artist="Русский Маяк" data-duration="4:05">
              <span class="player__track-index">02</span>
              <span class="player__track-name"><strong>Маяк</strong><span>Альбом «Свет с передовой»</span></span>
              <span class="player__track-duration">4:05</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/track-3.mp3" data-title="Домой" data-artist="Русский Маяк" data-duration="3:18">
              <span class="player__track-index">03</span>
              <span class="player__track-name"><strong>Домой</strong><span>Альбом «Домой»</span></span>
              <span class="player__track-duration">3:18</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/track-4.mp3" data-title="Братство" data-artist="Русский Маяк" data-duration="3:55">
              <span class="player__track-index">04</span>
              <span class="player__track-name"><strong>Братство</strong><span>Альбом «Домой»</span></span>
              <span class="player__track-duration">3:55</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/track-5.mp3" data-title="Письма" data-artist="Русский Маяк" data-duration="4:20">
              <span class="player__track-index">05</span>
              <span class="player__track-name"><strong>Письма</strong><span>Альбом «Позывной»</span></span>
              <span class="player__track-duration">4:20</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= АЛЬБОМЫ ================= -->
    <section class="section" id="albums" aria-labelledby="albums-title">
      <div class="container">
        <div class="section-head section-head--split">
          <div>
            <p class="eyebrow" data-reveal>Дискография</p>
            <h2 id="albums-title" data-reveal>Последние альбомы</h2>
          </div>
          <a class="btn btn--ghost" href="{{ route('albums.index') }}">
            Все альбомы
            <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
          </a>
        </div>

        <div class="grid grid--3">
          <article class="card" data-reveal>
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta">2025 · Альбом</span>
              <h3 class="card__title">Свет с передовой</h3>
              <p class="card__text">Восемь песен, записанных после поездок к бойцам — о надежде, доме и возвращении.</p>
              <a class="card__link" href="{{ route('albums.show', 'svet-s-peredovoy') }}">
                Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
              </a>
            </div>
          </article>

          <article class="card" data-reveal>
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta">2023 · Альбом</span>
              <h3 class="card__title">Домой</h3>
              <p class="card__text">Альбом, посвящённый тем, кто ждёт и тем, кто возвращается.</p>
              <a class="card__link" href="{{ route('albums.show', 'svet-s-peredovoy') }}">
                Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
              </a>
            </div>
          </article>

          <article class="card" data-reveal>
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta">2021 · Альбом</span>
              <h3 class="card__title">Позывной</h3>
              <p class="card__text">Дебютная работа группы, с которой началась дорога в госпитали и на передовую.</p>
              <a class="card__link" href="{{ route('albums.show', 'svet-s-peredovoy') }}">
                Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ================= ВИДЕОГАЛЕРЕЯ ================= -->
    <section class="section section--muted" id="video" aria-labelledby="video-title">
      <div class="container">
        <div class="section-head section-head--split">
          <div>
            <p class="eyebrow" data-reveal>Видео</p>
            <h2 id="video-title" data-reveal>Концерты, поездки, интервью</h2>
          </div>
          <a class="btn btn--ghost" href="{{ route('videos.index') }}">
            Вся видеогалерея
            <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
          </a>
        </div>

        <div class="swiper" data-video-slider>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <button class="video-card" type="button" data-video-trigger data-video-title="Концерт в военном госпитале" data-video-embed="https://www.youtube-nocookie.com/embed/YE7VzlLtp-4?autoplay=1&rel=0" data-reveal>
                <span class="video-card__play"><span class="video-card__play-btn"><svg aria-hidden="true"><use href="#icon-play" /></svg></span></span>
                <span class="video-card__caption">
                  <span class="video-card__title">Концерт в военном госпитале</span>
                  <span class="video-card__meta">Документальный · 6:24</span>
                </span>
              </button>
            </div>
            <div class="swiper-slide">
              <button class="video-card" type="button" data-video-trigger data-video-title="Поездка в зону СВО" data-video-embed="https://www.youtube-nocookie.com/embed/aqz-KE-bpKQ?autoplay=1&rel=0" data-reveal>
                <span class="video-card__play"><span class="video-card__play-btn"><svg aria-hidden="true"><use href="#icon-play" /></svg></span></span>
                <span class="video-card__caption">
                  <span class="video-card__title">Поездка в зону СВО</span>
                  <span class="video-card__meta">Репортаж · 9:12</span>
                </span>
              </button>
            </div>
            <div class="swiper-slide">
              <button class="video-card" type="button" data-video-trigger data-video-title="Live: «Маяк» на большой сцене" data-video-embed="https://www.youtube-nocookie.com/embed/aqz-KE-bpKQ?autoplay=1&rel=0&start=30" data-reveal>
                <span class="video-card__play"><span class="video-card__play-btn"><svg aria-hidden="true"><use href="#icon-play" /></svg></span></span>
                <span class="video-card__caption">
                  <span class="video-card__title">Live: «Маяк» на большой сцене</span>
                  <span class="video-card__meta">Концерт · 4:50</span>
                </span>
              </button>
            </div>
            <div class="swiper-slide">
              <button class="video-card" type="button" data-video-trigger data-video-title="Интервью: почему мы едем на передовую" data-video-embed="https://www.youtube-nocookie.com/embed/YE7VzlLtp-4?autoplay=1&rel=0&start=45" data-reveal>
                <span class="video-card__play"><span class="video-card__play-btn"><svg aria-hidden="true"><use href="#icon-play" /></svg></span></span>
                <span class="video-card__caption">
                  <span class="video-card__title">Интервью: почему мы едем на передовую</span>
                  <span class="video-card__meta">Интервью · 11:03</span>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= ФОТОГАЛЕРЕЯ ================= -->
    <section class="section" id="photo" aria-labelledby="photo-title">
      <div class="container">
        <div class="section-head section-head--split">
          <div>
            <p class="eyebrow" data-reveal>Фотографии</p>
            <h2 id="photo-title" data-reveal>Моменты, которые говорят громче слов</h2>
          </div>
          <a class="btn btn--ghost" href="{{ route('photos.index') }}">
            Все фотоотчёты
            <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
          </a>
        </div>

        <div class="photo-gallery__filters" role="tablist" aria-label="Фильтр фотографий" data-gallery-filters>
          <button class="photo-gallery__filter is-active" type="button" role="tab" aria-selected="true" data-filter="all">Все</button>
          <button class="photo-gallery__filter" type="button" role="tab" aria-selected="false" data-filter="concerts">Концерты</button>
          <button class="photo-gallery__filter" type="button" role="tab" aria-selected="false" data-filter="trips">Поездки</button>
          <button class="photo-gallery__filter" type="button" role="tab" aria-selected="false" data-filter="hospitals">Госпитали</button>
          <button class="photo-gallery__filter" type="button" role="tab" aria-selected="false" data-filter="backstage">Backstage</button>
        </div>

        <div class="photo-gallery" data-gallery>
          <button class="photo-gallery__item" type="button" data-category="concerts" data-reveal aria-label="Открыть фотографию: концерт группы">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="trips" data-reveal aria-label="Открыть фотографию: поездка в зону СВО">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="hospitals" data-reveal aria-label="Открыть фотографию: визит в госпиталь">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="backstage" data-reveal aria-label="Открыть фотографию: backstage">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="concerts" data-reveal aria-label="Открыть фотографию: концерт группы">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="trips" data-reveal aria-label="Открыть фотографию: поездка в зону СВО">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="hospitals" data-reveal aria-label="Открыть фотографию: визит в госпиталь">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-category="concerts" data-reveal aria-label="Открыть фотографию: концерт группы">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
        </div>
      </div>
    </section>

    <!-- ================= НОВОСТИ ================= -->
    <section class="section section--muted" id="news" aria-labelledby="news-title">
      <div class="container">
        <div class="section-head section-head--split">
          <div>
            <p class="eyebrow" data-reveal>Новости</p>
            <h2 id="news-title" data-reveal>Новости группы</h2>
          </div>
          <a class="btn btn--ghost" href="{{ route('news.index') }}">
            Все новости
            <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
          </a>
        </div>

        <div class="grid grid--3">
          <article class="card" data-reveal>
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta"><time datetime="2026-07-12">12 июля 2026</time> · Поездки</span>
              <h3 class="card__title">Новая поездка в госпиталь Ростова</h3>
              <p class="card__text">Мы привезли не только концерт, но и партию медицинского оборудования для реабилитации.</p>
              <a class="card__link" href="{{ route('news.show', 'gospital-rostov') }}">
                Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
              </a>
            </div>
          </article>

          <article class="card" data-reveal>
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta"><time datetime="2026-06-28">28 июня 2026</time> · Релиз</span>
              <h3 class="card__title">Вышел клип на песню «Маяк»</h3>
              <p class="card__text">Съёмки прошли в местах, где мы выступали перед военнослужащими этой весной.</p>
              <a class="card__link" href="{{ route('news.show', 'gospital-rostov') }}">
                Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
              </a>
            </div>
          </article>

          <article class="card" data-reveal>
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta"><time datetime="2026-06-05">5 июня 2026</time> · Благотворительность</span>
              <h3 class="card__title">Собрали 2 млн ₽ на реабилитацию бойцов</h3>
              <p class="card__text">Благодарим каждого, кто откликнулся — отчёт о расходах уже в разделе отчётности.</p>
              <a class="card__link" href="{{ route('news.show', 'gospital-rostov') }}">
                Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <!-- ================= АНОНСЫ МЕРОПРИЯТИЙ ================= -->
    <section class="section" id="events" aria-labelledby="events-title">
      <div class="container">
        <div class="section-head section-head--split">
          <div>
            <p class="eyebrow" data-reveal>Афиша</p>
            <h2 id="events-title" data-reveal>Анонсы мероприятий</h2>
          </div>
          <a class="btn btn--ghost" href="{{ route('concerts.index') }}">
            Все концерты
            <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
          </a>
        </div>

        <div class="events-list" data-reveal>
          <div class="event-row">
            <div class="event-row__date"><span class="event-row__day">14</span><span class="event-row__month">сен</span></div>
            <div>
              <h3 class="event-row__title">Благотворительный концерт «Свет для героев»</h3>
              <p class="event-row__place"><svg aria-hidden="true" style="width:14px;height:14px;display:inline;vertical-align:-2px"><use href="#icon-pin" /></svg> Москва, Live Arena</p>
            </div>
            <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', 'svet-dlya-geroev') }}">Подробнее</a>
          </div>
          <div class="event-row">
            <div class="event-row__date"><span class="event-row__day">27</span><span class="event-row__month">сен</span></div>
            <div>
              <h3 class="event-row__title">Поездка с концертом в госпиталь Ростова</h3>
              <p class="event-row__place"><svg aria-hidden="true" style="width:14px;height:14px;display:inline;vertical-align:-2px"><use href="#icon-pin" /></svg> Ростов-на-Дону</p>
            </div>
            <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', 'svet-dlya-geroev') }}">Подробнее</a>
          </div>
          <div class="event-row">
            <div class="event-row__date"><span class="event-row__day">03</span><span class="event-row__month">окт</span></div>
            <div>
              <h3 class="event-row__title">Акустический концерт «Домой»</h3>
              <p class="event-row__place"><svg aria-hidden="true" style="width:14px;height:14px;display:inline;vertical-align:-2px"><use href="#icon-pin" /></svg> Санкт-Петербург, ДК Ленсовета</p>
            </div>
            <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', 'svet-dlya-geroev') }}">Подробнее</a>
          </div>
          <div class="event-row">
            <div class="event-row__date"><span class="event-row__day">19</span><span class="event-row__month">окт</span></div>
            <div>
              <h3 class="event-row__title">Благотворительная акция сбора гуманитарной помощи</h3>
              <p class="event-row__place"><svg aria-hidden="true" style="width:14px;height:14px;display:inline;vertical-align:-2px"><use href="#icon-pin" /></svg> Краснодар, ДК Металлург</p>
            </div>
            <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', 'svet-dlya-geroev') }}">Подробнее</a>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= БЛАГОТВОРИТЕЛЬНЫЕ СБОРЫ ================= -->
    <section class="section section--muted" id="fundraising" aria-labelledby="fundraising-title">
      <div class="container">
        <div class="fundraising" data-reveal>
          <div class="fundraising__grid">
            <div class="fundraising__gallery" aria-hidden="true">
              <div class="fundraising__photo"></div>
              <div class="fundraising__photo"></div>
              <div class="fundraising__photo"></div>
            </div>

            <div class="fundraising__content">
              <span class="badge badge--live">Сбор открыт</span>
              <p class="eyebrow">Благотворительность</p>
              <h2 id="fundraising-title">{{ $fundraising?->title ?? 'Реабилитационное оборудование для военного госпиталя' }}</h2>
              <p class="lead">
                {{ $fundraising?->lead ?? 'Собираем средства на аппараты для восстановления бойцов после ранений. Каждый рубль идёт напрямую на закупку оборудования — отчёт о расходах публикуется в открытом доступе.' }}
              </p>

              <div class="progress" data-progress data-goal="{{ $fundraising?->goal_amount ?? 4500000 }}" data-current="{{ $fundraising?->current_amount ?? 3180000 }}">
                <div class="progress__meta">
                  <span class="progress__sum"><span data-progress-current="0">0</span> ₽</span>
                  <span class="progress__goal">из {{ number_format($fundraising?->goal_amount ?? 4500000, 0, ',', ' ') }} ₽</span>
                </div>
                <div class="progress__track">
                  <div class="progress__fill" data-progress-fill></div>
                </div>
                <span class="progress__percent" data-progress-percent>0%</span>
              </div>

              <div class="hero__actions">
                <a class="btn btn--primary" href="#requisites">
                  <svg aria-hidden="true"><use href="#icon-heart" /></svg>
                  Поддержать сбор
                </a>
                <a class="fundraising__report-link" href="{{ route('pages.reports') }}">
                  <svg aria-hidden="true"><use href="#icon-document" /></svg>
                  Отчёты о расходах
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= РЕКВИЗИТЫ ================= -->
    <section class="section" id="requisites" aria-labelledby="requisites-title">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow" data-reveal>Реквизиты</p>
          <h2 id="requisites-title" data-reveal>Как перевести помощь</h2>
        </div>

        <div class="requisites-grid">
          <div class="requisite-card" data-reveal>
            <div class="requisite-card__head">
              <span class="requisite-card__icon"><svg aria-hidden="true"><use href="#icon-card" /></svg></span>
              <h3 class="requisite-card__title">Перевод на карту</h3>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">Номер карты</span>
              <span class="requisite-card__value">2200 1234 5678 9010</span>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">Получатель</span>
              <span class="requisite-card__value">Фонд «Русский Маяк»</span>
            </div>
            <button class="requisite-card__copy" type="button" data-copy="2200123456789010">
              <svg aria-hidden="true"><use href="#icon-copy" /></svg>
              Скопировать номер
            </button>
          </div>

          <div class="requisite-card" data-reveal>
            <div class="requisite-card__head">
              <span class="requisite-card__icon"><svg aria-hidden="true"><use href="#icon-document" /></svg></span>
              <h3 class="requisite-card__title">Для юридических лиц</h3>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">ИНН</span>
              <span class="requisite-card__value">7700000000</span>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">Р/с</span>
              <span class="requisite-card__value">40703810000000000000</span>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">БИК</span>
              <span class="requisite-card__value">044525000</span>
            </div>
            <button class="requisite-card__copy" type="button" data-copy="7700000000, Р/с 40703810000000000000, БИК 044525000">
              <svg aria-hidden="true"><use href="#icon-copy" /></svg>
              Скопировать реквизиты
            </button>
          </div>

          <div class="requisite-card" data-reveal>
            <div class="requisite-card__head">
              <span class="requisite-card__icon"><svg aria-hidden="true"><use href="#icon-heart" /></svg></span>
              <h3 class="requisite-card__title">СБП / QR-код</h3>
            </div>
            <p class="requisite-card__value" style="text-align:left">
              Отсканируйте QR-код в приложении банка — сумма перевода не ограничена.
            </p>
            <div class="requisite-card__qr" role="img" aria-label="QR-код для перевода через Систему быстрых платежей">
              <svg viewBox="0 0 100 100" aria-hidden="true">
                <rect width="100" height="100" fill="#fff" />
                <rect x="10" y="10" width="20" height="20" fill="#0a0c10" />
                <rect x="70" y="10" width="20" height="20" fill="#0a0c10" />
                <rect x="10" y="70" width="20" height="20" fill="#0a0c10" />
                <rect x="40" y="10" width="10" height="10" fill="#0a0c10" />
                <rect x="40" y="40" width="20" height="20" fill="#0a0c10" />
                <rect x="70" y="40" width="10" height="10" fill="#0a0c10" />
                <rect x="40" y="70" width="10" height="10" fill="#0a0c10" />
                <rect x="60" y="70" width="10" height="10" fill="#0a0c10" />
                <rect x="80" y="80" width="10" height="10" fill="#0a0c10" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= ПАРТНЕРЫ ================= -->
    <section class="section section--muted partners" id="partners" aria-labelledby="partners-title">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow" data-reveal>Партнёры</p>
          <h2 id="partners-title" data-reveal>Нам доверяют</h2>
        </div>
      </div>

      <div class="partners__marquee-wrap">
        <div class="marquee">
          <ul class="marquee__track">
            <li class="marquee__item">Фонд «Защитник»</li>
            <li class="marquee__item">Военный госпиталь №1</li>
            <li class="marquee__item">Радио «Победа»</li>
            <li class="marquee__item">Ассоциация ветеранов</li>
            <li class="marquee__item">Медиахолдинг «Звезда»</li>
            <li class="marquee__item">Фонд «Своих не бросаем»</li>
            <li class="marquee__item" aria-hidden="true">Фонд «Защитник»</li>
            <li class="marquee__item" aria-hidden="true">Военный госпиталь №1</li>
            <li class="marquee__item" aria-hidden="true">Радио «Победа»</li>
            <li class="marquee__item" aria-hidden="true">Ассоциация ветеранов</li>
            <li class="marquee__item" aria-hidden="true">Медиахолдинг «Звезда»</li>
            <li class="marquee__item" aria-hidden="true">Фонд «Своих не бросаем»</li>
          </ul>
        </div>
      </div>
    </section>

    <!-- ================= КОНТАКТЫ ================= -->
    <section class="section" id="contacts" aria-labelledby="contacts-title">
      <div class="container">
        <div class="section-head">
          <p class="eyebrow" data-reveal>Контакты</p>
          <h2 id="contacts-title" data-reveal>Свяжитесь с нами</h2>
        </div>

        <div class="contacts__grid">
          <div class="contacts__info" data-reveal>
            <div class="contacts__info-item">
              <span class="contacts__info-icon"><svg aria-hidden="true"><use href="#icon-phone" /></svg></span>
              <div>
                <span class="contacts__info-label">Телефон</span>
                <a class="contacts__info-value" href="tel:+79990000000">+7 (999) 000-00-00</a>
              </div>
            </div>
            <div class="contacts__info-item">
              <span class="contacts__info-icon"><svg aria-hidden="true"><use href="#icon-mail" /></svg></span>
              <div>
                <span class="contacts__info-label">Email</span>
                <a class="contacts__info-value" href="mailto:info@russkiy-mayak.ru">info@russkiy-mayak.ru</a>
              </div>
            </div>
            <div class="contacts__info-item">
              <span class="contacts__info-icon"><svg aria-hidden="true"><use href="#icon-pin" /></svg></span>
              <div>
                <span class="contacts__info-label">Офис</span>
                <p class="contacts__info-value">Москва, ул. Примерная, 10</p>
              </div>
            </div>
            <div class="footer__social">
              <a class="footer__social-link" href="https://vk.com/russkiy_mayak" target="_blank" rel="noopener noreferrer" aria-label="Группа во ВКонтакте">
                <svg aria-hidden="true"><use href="#icon-vk" /></svg>
              </a>
              <a class="footer__social-link" href="https://t.me/russkiy_mayak" target="_blank" rel="noopener noreferrer" aria-label="Канал в Telegram">
                <svg aria-hidden="true"><use href="#icon-telegram" /></svg>
              </a>
              <a class="footer__social-link" href="https://youtube.com/@russkiy_mayak" target="_blank" rel="noopener noreferrer" aria-label="Канал на YouTube">
                <svg aria-hidden="true"><use href="#icon-youtube" /></svg>
              </a>
            </div>
          </div>

          <form class="form contacts__panel" data-reveal data-contact-form novalidate>
            <div class="form__row">
              <div class="form__field">
                <label class="form__label" for="name">Ваше имя</label>
                <input class="form__input" type="text" id="name" name="name" autocomplete="name" required />
              </div>
              <div class="form__field">
                <label class="form__label" for="email">Email</label>
                <input class="form__input" type="email" id="email" name="email" autocomplete="email" required />
              </div>
            </div>
            <div class="form__field">
              <label class="form__label" for="message">Сообщение</label>
              <textarea class="form__textarea" id="message" name="message" required></textarea>
            </div>
            <label class="form__consent">
              <input class="form__checkbox" type="checkbox" name="consent" required />
              Я согласен с <a href="{{ route('pages.privacy') }}">политикой обработки персональных данных</a>
            </label>
            <button class="btn btn--primary btn--block" type="submit">Отправить сообщение</button>
            <p class="form__status" role="status" aria-live="polite" data-form-status></p>
          </form>
        </div>
      </div>
    </section>
@endsection
