@extends('layouts.app')

@section('title', "Концерт «Свет для героев» — Русский Маяк")
@section('description', "Благотворительный концерт «Свет для героев»: 14 сентября, Москва, Live Arena. Все средства от продажи части билетов пойдут на закупку реабилитационного оборудования.")
@section('canonical_path', "/concerts/svet-dlya-geroev")
@section('og_type', "article")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/concert-single.js'])
@endsection

@section('content')
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Event",
      "name": "Концерт «Свет для героев»",
      "startDate": "2026-09-14T19:00",
      "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
      "eventStatus": "https://schema.org/EventScheduled",
      "location": {
        "@@type": "Place",
        "name": "Live Arena",
        "address": "Москва"
      },
      "performer": { "@@type": "MusicGroup", "name": "Русский Маяк" }
    }
  </script>

<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Главная", "item": "https://russkiy-mayak.ru/" },
        { "@@type": "ListItem", "position": 2, "name": "Концерты", "item": "https://russkiy-mayak.ru/concerts" },
        { "@@type": "ListItem", "position": 3, "name": "Свет для героев" }
      ]
    }
  </script>

<section class="section section--top-offset">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
          <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('concerts.index') }}">Концерты</a></li>
            <li class="breadcrumbs__item" aria-current="page">Свет для героев</li>
          </ol>
        </nav>

        <div class="tag-list" data-reveal>
          <span class="tag">Концерты</span>
          <span class="tag">Благотворительность</span>
        </div>

        <h1 style="margin-top: var(--space-4)" data-reveal>Благотворительный концерт «Свет для героев»</h1>

        <div class="article-meta" data-reveal>
          <div class="author-chip">
            <span class="author-chip__avatar" aria-hidden="true">РМ</span>
            <span>
              <span class="author-chip__name">Организатор: Фонд «Русский Маяк»</span><br />
              <span class="author-chip__role">Событие</span>
            </span>
          </div>
          <span class="article-meta__item"><svg aria-hidden="true"><use href="#icon-calendar" /></svg> 14 сентября 2026</span>
          <span class="article-meta__item">Чтение: 3 минуты</span>
        </div>

        <div class="requisite-card" style="margin-top: var(--space-6); max-width: 32rem" data-reveal>
          <div class="requisite-card__head">
            <span class="requisite-card__icon"><svg aria-hidden="true"><use href="#icon-calendar" /></svg></span>
            <h2 class="requisite-card__title">О мероприятии</h2>
          </div>
          <div class="requisite-card__row">
            <span class="requisite-card__label">Дата</span>
            <span class="requisite-card__value">14 сентября 2026</span>
          </div>
          <div class="requisite-card__row">
            <span class="requisite-card__label">Время</span>
            <span class="requisite-card__value">19:00</span>
          </div>
          <div class="requisite-card__row">
            <span class="requisite-card__label">Место</span>
            <span class="requisite-card__value">Live Arena, Москва</span>
          </div>
          <div class="requisite-card__row">
            <span class="requisite-card__label">Статус</span>
            <span class="requisite-card__value">Билеты в продаже</span>
          </div>
          <a class="btn btn--primary btn--block" href="/#fundraising" style="margin-top: var(--space-4)">Купить билет</a>
        </div>

        <div class="article__cover" style="margin-top: var(--space-8)" data-reveal></div>

        <div class="article__layout">
          <article class="article__body" data-reveal>
            <h2 id="o-koncerte">О концерте</h2>
            <p>
              «Свет для героев» — ежегодный благотворительный концерт «Русского Маяка», который в этом году
              пройдёт на сцене Live Arena в Москве. Часть выручки от продажи билетов и все средства со
              специальной благотворительной зоны пойдут на закупку реабилитационного оборудования для военных
              госпиталей.
            </p>
            <blockquote>
              «Этот концерт мы играем не для сцены — мы играем для тех, кто сейчас в госпиталях и на передовой.
              Каждый билет — это чей-то шанс на выздоровление», — говорит лидер группы.
            </blockquote>

            <figure class="article__figure">
              <div class="article__figure-media" aria-hidden="true"></div>
              <figcaption class="article__figure-caption">Live Arena — площадка на 6000 зрителей в центре Москвы.</figcaption>
            </figure>

            <h2 id="programma">Программа вечера</h2>
            <ul>
              <li>Выступление группы «Русский Маяк» — новый альбом и хиты прошлых лет</li>
              <li>Специальные гости — приглашённые артисты благотворительной сцены</li>
              <li>Благотворительная зона с сувенирами и историями бойцов, которым уже помогли</li>
            </ul>

            <h2 id="zapis">Запись прошлого концерта</h2>
            <p>Чтобы почувствовать атмосферу, послушайте запись выступления с прошлогоднего концерта «Свет для героев».</p>

            <div class="article__player-embed" data-player>
              <div class="player__stage">
                <div class="player__cover" data-player-cover>
                  <div class="player__cover-img" role="img" aria-label="Обложка записи концерта «Свет для героев» 2025"></div>
                </div>
                <div class="player__track-info">
                  <span class="player__track-title" data-player-title>Маяк (Live, 2025)</span>
                  <span class="player__track-artist" data-player-artist>Русский Маяк · Live Arena</span>
                </div>
                <div class="player__wave" aria-hidden="true" data-player-wave></div>
                <div class="player__controls">
                  <button class="player__control player__control--play" type="button" data-player-play aria-label="Воспроизвести">
                    <svg aria-hidden="true" data-player-play-icon><use href="#icon-play" /></svg>
                  </button>
                </div>
                <div class="player__seek">
                  <span data-player-current>0:00</span>
                  <span class="player__seek-track" data-player-seek>
                    <span class="player__seek-fill" data-player-seek-fill></span>
                    <input class="player__seek-input" type="range" min="0" max="100" value="0" aria-label="Перемотка записи" data-player-seek-input />
                  </span>
                  <span data-player-duration>0:00</span>
                </div>
              </div>
              <div class="player__list" role="list" aria-label="Запись" data-player-list>
                <button class="player__track is-active" type="button" role="listitem" data-track data-src="/audio/mayak-live-2025.mp3" data-title="Маяк (Live, 2025)" data-artist="Русский Маяк" data-duration="4:32">
                  <span class="player__track-index">●</span>
                  <span class="player__track-name"><strong>Маяк (Live, 2025)</strong><span>Свет для героев, 2025</span></span>
                  <span class="player__track-duration">4:32</span>
                </button>
              </div>
            </div>

            <h2 id="biletyi">Билеты и поддержка</h2>
            <p>
              Часть мест доступна по благотворительному тарифу: разница в стоимости идёт напрямую в фонд закупки
              оборудования. Если вы не сможете прийти, вы можете поддержать сбор напрямую в разделе
              <a href="/#fundraising">«Благотворительные сборы»</a>.
            </p>

            <div class="article__tags">
              <div class="tag-list">
                <a class="tag" href="{{ route('concerts.index') }}">Концерты</a>
                <a class="tag" href="{{ route('concerts.index') }}">Благотворительность</a>
              </div>
            </div>
          </article>

          <aside class="toc" data-toc aria-label="Содержание статьи">
            <span class="toc__heading">Содержание</span>
            <nav>
              <ul class="toc__list">
                <li><a class="toc__link" href="#o-koncerte" data-toc-link>О концерте</a></li>
                <li><a class="toc__link" href="#programma" data-toc-link>Программа вечера</a></li>
                <li><a class="toc__link" href="#zapis" data-toc-link>Запись прошлого концерта</a></li>
                <li><a class="toc__link" href="#biletyi" data-toc-link>Билеты и поддержка</a></li>
              </ul>
            </nav>
          </aside>
        </div>

        <div class="article__related">
          <div class="section-head">
            <p class="eyebrow">Афиша</p>
            <h2>Другие мероприятия</h2>
          </div>
          <div class="events-list">
            <div class="event-row">
              <div class="event-row__date"><span class="event-row__day">27</span><span class="event-row__month">сен</span></div>
              <div>
                <h3 class="event-row__title">Концерт в госпитале Ростова</h3>
                <p class="event-row__place">Ростов-на-Дону</p>
              </div>
              <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', 'svet-dlya-geroev') }}">Подробнее</a>
            </div>
            <div class="event-row">
              <div class="event-row__date"><span class="event-row__day">03</span><span class="event-row__month">окт</span></div>
              <div>
                <h3 class="event-row__title">Акустический концерт «Домой»</h3>
                <p class="event-row__place">Санкт-Петербург, ДК Ленсовета</p>
              </div>
              <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', 'svet-dlya-geroev') }}">Подробнее</a>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
