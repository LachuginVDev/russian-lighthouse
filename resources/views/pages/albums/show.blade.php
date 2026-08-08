@extends('layouts.app')

@section('title', "Альбом «Свет с передовой» — Русский Маяк")
@section('description', "«Свет с передовой» — альбом группы «Русский Маяк», записанный после поездок в госпитали и зону СВО. Слушайте треки, читайте историю создания.")
@section('canonical_path', "/albums/svet-s-peredovoy")
@section('og_type', "music.album")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/album.js'])
@endsection

@section('content')
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "MusicAlbum",
      "name": "Свет с передовой",
      "byArtist": { "@@type": "MusicGroup", "name": "Русский Маяк" },
      "datePublished": "2025",
      "genre": "Патриотическая музыка",
      "numTracks": 8
    }
  </script>

<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Главная", "item": "https://russkiy-mayak.ru/" },
        { "@@type": "ListItem", "position": 2, "name": "Дискография", "item": "https://russkiy-mayak.ru/albums" },
        { "@@type": "ListItem", "position": 3, "name": "Свет с передовой" }
      ]
    }
  </script>

<section class="section section--top-offset">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
          <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('albums.index') }}">Дискография</a></li>
            <li class="breadcrumbs__item" aria-current="page">Свет с передовой</li>
          </ol>
        </nav>

        <div class="album-hero">
          <div class="album-hero__cover" data-reveal></div>
          <div data-reveal>
            <span class="badge badge--gold">Новый альбом</span>
            <h1 style="margin-top: var(--space-4)">Свет с передовой</h1>
            <p class="lead" style="margin-top: var(--space-3)">
              Восемь песен, записанных после серии поездок к бойцам — о надежде, доме и возвращении. Каждый трек
              вырос из историй, услышанных в госпиталях и у блиндажей.
            </p>
            <div class="album-hero__meta">
              <span>Год: 2025</span>
              <span>Треков: 8</span>
              <span>Длительность: ≈ 32 минуты</span>
              <span>Жанр: Патриотическая музыка</span>
            </div>
            <div class="album-hero__actions">
              <a class="btn btn--primary" href="#tracklist">
                <svg aria-hidden="true"><use href="#icon-play" /></svg>
                Слушать альбом
              </a>
              <a class="btn btn--outline btn--sm" href="https://vk.com/russkiy_mayak" target="_blank" rel="noopener noreferrer">VK Музыка</a>
              <a class="btn btn--outline btn--sm" href="https://youtube.com/@russkiy_mayak" target="_blank" rel="noopener noreferrer">YouTube Music</a>
            </div>
          </div>
        </div>

        <div id="tracklist" class="player" data-reveal data-player>
          <div class="player__stage">
            <div class="player__cover" data-player-cover>
              <div class="player__cover-img" role="img" aria-label="Обложка альбома «Свет с передовой»"></div>
            </div>

            <div class="player__track-info">
              <span class="player__track-title" data-player-title>Свет</span>
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

          <div class="player__list" role="list" aria-label="Треклист альбома" data-player-list>
            <button class="player__track is-active" type="button" role="listitem" data-track data-src="/audio/svet.mp3" data-title="Свет" data-artist="Русский Маяк" data-duration="3:20">
              <span class="player__track-index">01</span>
              <span class="player__track-name"><strong>Свет</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">3:20</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/pozyvnoy-nadezhda.mp3" data-title="Позывной Надежда" data-artist="Русский Маяк" data-duration="3:42">
              <span class="player__track-index">02</span>
              <span class="player__track-name"><strong>Позывной Надежда</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">3:42</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/pisma.mp3" data-title="Письма без адреса" data-artist="Русский Маяк" data-duration="4:05">
              <span class="player__track-index">03</span>
              <span class="player__track-name"><strong>Письма без адреса</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">4:05</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/bratstvo.mp3" data-title="Братство" data-artist="Русский Маяк" data-duration="3:55">
              <span class="player__track-index">04</span>
              <span class="player__track-name"><strong>Братство</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">3:55</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/domoy.mp3" data-title="Домой" data-artist="Русский Маяк" data-duration="3:18">
              <span class="player__track-index">05</span>
              <span class="player__track-name"><strong>Домой</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">3:18</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/mayak-live.mp3" data-title="Маяк (Live)" data-artist="Русский Маяк" data-duration="4:12">
              <span class="player__track-index">06</span>
              <span class="player__track-name"><strong>Маяк (Live)</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">4:12</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/tishina.mp3" data-title="Тишина после боя" data-artist="Русский Маяк" data-duration="3:47">
              <span class="player__track-index">07</span>
              <span class="player__track-name"><strong>Тишина после боя</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">3:47</span>
            </button>
            <button class="player__track" type="button" role="listitem" data-track data-src="/audio/otschet.mp3" data-title="Обратный отсчёт" data-artist="Русский Маяк" data-duration="3:31">
              <span class="player__track-index">08</span>
              <span class="player__track-name"><strong>Обратный отсчёт</strong><span>Свет с передовой</span></span>
              <span class="player__track-duration">3:31</span>
            </button>
          </div>
        </div>

        <div class="album-body" data-reveal>
          <h2>История создания</h2>
          <p>
            Работа над альбомом началась после весенней поездки в военный госпиталь, где музыканты выступали
            перед бойцами, проходящими реабилитацию. Разговоры с ранеными и медперсоналом легли в основу
            большинства текстов — от «Позывного Надежда» до финальной «Обратный отсчёт».
          </p>
          <p>
            Часть альбома была дописана прямо в поездках: черновик песни «Домой» родился в дороге между
            госпиталем и следующим концертом. Мы хотели, чтобы альбом звучал честно — без пафоса, но с верой в
            то, что музыка способна поддержать даже там, где слов не хватает.
          </p>
        </div>

        <div class="article__related">
          <div class="section-head">
            <p class="eyebrow">Дискография</p>
            <h2>Другие альбомы</h2>
          </div>
          <div class="grid grid--3">
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta">2023 · Альбом</span>
                <h3 class="card__title">Домой</h3>
                <p class="card__text">Альбом, посвящённый тем, кто ждёт, и тем, кто возвращается.</p>
                <a class="card__link" href="{{ route('albums.show', 'svet-s-peredovoy') }}">Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta">2022 · Альбом</span>
                <h3 class="card__title">Братство</h3>
                <p class="card__text">Песни о плече товарища и о том, что настоящая сила — в единстве.</p>
                <a class="card__link" href="{{ route('albums.show', 'svet-s-peredovoy') }}">Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta">2021 · Альбом</span>
                <h3 class="card__title">Позывной</h3>
                <p class="card__text">Дебютная работа группы, с которой началась дорога в госпитали и на передовую.</p>
                <a class="card__link" href="{{ route('albums.show', 'svet-s-peredovoy') }}">Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
@endsection
