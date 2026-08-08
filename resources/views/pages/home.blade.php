@extends('layouts.app')

@section('title', "Русский Маяк — официальный сайт музыкальной группы")
@section('description', "Русский Маяк — музыкальная группа, которая пишет песни о силе духа, ездит с концертами в госпитали и зону СВО, помогает военнослужащим. Слушайте музыку, следите за новостями и поддержите благотворительные сборы.")
@section('canonical_path', "/")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/main.js'])
@endsection

@section('content')
  @php
    $firstTrack = $featuredTracks->first();
    $firstCover = \App\Support\MediaUrl::make($firstTrack?->cover_path ?: $firstTrack?->album?->cover_path);
    $cardDigits = preg_replace('/\D+/', '', (string) $settings->card_number);
  @endphp

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
        data-particles-mode="field"
        data-particles-count="64"
      ></canvas>
      <div class="hero__overlay" aria-hidden="true"></div>
      <div class="hero__glow" aria-hidden="true" data-hero-glow></div>

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
          @if ($settings->stat_years)
            <span class="badge badge--gold about__badge">С {{ now()->year - (int) $settings->stat_years }} года на сцене</span>
          @endif
        </div>

        <div class="about__body">
          <p class="eyebrow" data-reveal>{{ $settings->about_eyebrow ?: 'О группе' }}</p>
          <h2 id="about-title" data-reveal>{{ $settings->about_title ?: 'История, рождённая в поездках' }}</h2>
          @if ($settings->about_lead)
            <p class="lead" data-reveal>{{ $settings->about_lead }}</p>
          @endif
          @if ($settings->about_body)
            <div data-reveal>{!! $settings->about_body !!}</div>
          @endif

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

        @if ($featuredTracks->isNotEmpty())
          <div class="player" data-reveal data-player>
            <div class="player__stage">
              <div class="player__cover" data-player-cover>
                <div
                  class="player__cover-img"
                  role="img"
                  aria-label="Обложка «{{ $firstTrack->title }}»"
                  @if ($firstCover) style="background-image: url('{{ $firstCover }}')" @endif
                ></div>
              </div>

              <div class="player__track-info">
                <span class="player__track-title" data-player-title>{{ $firstTrack->title }}</span>
                <span class="player__track-artist" data-player-artist>{{ $firstTrack->artist ?: 'Русский Маяк' }}</span>
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
              @foreach ($featuredTracks as $index => $track)
                @php
                  $trackCover = \App\Support\MediaUrl::make($track->cover_path ?: $track->album?->cover_path);
                  $trackSrc = \App\Support\MediaUrl::make($track->audio_path);
                @endphp
                <button
                  class="player__track {{ $index === 0 ? 'is-active' : '' }}"
                  type="button"
                  role="listitem"
                  data-track
                  data-src="{{ $trackSrc }}"
                  data-title="{{ $track->title }}"
                  data-artist="{{ $track->artist ?: 'Русский Маяк' }}"
                  data-duration="{{ $track->duration }}"
                  data-cover="{{ $trackCover }}"
                >
                  <span class="player__track-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                  <span class="player__track-name">
                    <strong>{{ $track->title }}</strong>
                    <span>
                      @if ($track->album)
                        Альбом «{{ $track->album->title }}»
                      @else
                        {{ $track->artist ?: 'Русский Маяк' }}
                      @endif
                    </span>
                  </span>
                  <span class="player__track-duration">{{ $track->duration }}</span>
                </button>
              @endforeach
            </div>
          </div>
        @else
          <p data-reveal>Треки для главной ещё не добавлены. Отметьте треки «На главной» в админке.</p>
        @endif
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
          @forelse ($albums as $album)
            @php $cover = \App\Support\MediaUrl::make($album->cover_path); @endphp
            <article class="card" data-reveal>
              @if ($cover)
                <a class="card__media" href="{{ route('albums.show', $album) }}" style="background-image: url('{{ $cover }}')" aria-label="{{ $album->title }}"></a>
              @else
                <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              @endif
              <div class="card__body">
                <span class="card__meta">{{ $album->year }} · {{ $album->type->label() }}</span>
                <h3 class="card__title">{{ $album->title }}</h3>
                @if ($album->excerpt)
                  <p class="card__text">{{ $album->excerpt }}</p>
                @endif
                <a class="card__link" href="{{ route('albums.show', $album) }}">
                  Слушать альбом <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
                </a>
              </div>
            </article>
          @empty
            <p data-reveal>Альбомы для главной не отмечены в админке.</p>
          @endforelse
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

        @if ($videos->isNotEmpty())
          <div class="swiper" data-video-slider>
            <div class="swiper-wrapper">
              @foreach ($videos as $video)
                @php $thumb = \App\Support\MediaUrl::make($video->thumbnail_path); @endphp
                <div class="swiper-slide">
                  <button
                    class="video-card"
                    type="button"
                    data-video-trigger
                    data-video-title="{{ $video->title }}"
                    data-video-embed="{{ $video->embed_url }}"
                    data-reveal
                    @if ($thumb) style="background-image: url('{{ $thumb }}')" @endif
                  >
                    <span class="video-card__play"><span class="video-card__play-btn"><svg aria-hidden="true"><use href="#icon-play" /></svg></span></span>
                    <span class="video-card__caption">
                      <span class="video-card__title">{{ $video->title }}</span>
                      <span class="video-card__meta">
                        {{ collect([$video->type_label, $video->duration_label])->filter()->implode(' · ') }}
                      </span>
                    </span>
                  </button>
                </div>
              @endforeach
            </div>
          </div>
        @else
          <p data-reveal>Видео для главной не отмечены в админке.</p>
        @endif
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
          @foreach (\App\Enums\PhotoReportCategory::cases() as $category)
            <button class="photo-gallery__filter" type="button" role="tab" aria-selected="false" data-filter="{{ $category->value }}">{{ $category->label() }}</button>
          @endforeach
        </div>

        <div class="photo-gallery" data-gallery>
          @forelse ($featuredPhotos as $photo)
            @php
              $src = \App\Support\MediaUrl::make($photo->image_path);
              $category = $photo->photoReport?->category?->value ?: 'concerts';
              $label = $photo->alt ?: $photo->caption ?: $photo->photoReport?->title ?: 'Фотография';
            @endphp
            @if ($src)
              <button
                class="photo-gallery__item"
                type="button"
                data-category="{{ $category }}"
                data-reveal
                aria-label="Открыть фотографию: {{ $label }}"
                style="background-image: url('{{ $src }}')"
              >
                <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
              </button>
            @endif
          @empty
            <p data-reveal>Фото для главной пока нет. Отметьте фото или фотоотчёты «На главной».</p>
          @endforelse
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
          @forelse ($news as $item)
            @php $cover = \App\Support\MediaUrl::make($item->cover_path); @endphp
            <article class="card" data-reveal>
              @if ($cover)
                <a class="card__media" href="{{ route('news.show', $item) }}" style="background-image: url('{{ $cover }}')" aria-label="{{ $item->title }}"></a>
              @else
                <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              @endif
              <div class="card__body">
                <span class="card__meta">
                  @if ($item->published_at)
                    <time datetime="{{ $item->published_at->toDateString() }}">{{ $item->published_at->locale('ru')->translatedFormat('j F Y') }}</time>
                  @endif
                  · {{ $item->category->label() }}
                </span>
                <h3 class="card__title">{{ $item->title }}</h3>
                @if ($item->excerpt)
                  <p class="card__text">{{ $item->excerpt }}</p>
                @endif
                <a class="card__link" href="{{ route('news.show', $item) }}">
                  Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
                </a>
              </div>
            </article>
          @empty
            <p data-reveal>Новостей пока нет. Добавьте публикацию в админке и отметьте «На главной».</p>
          @endforelse
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
          @forelse ($concerts as $concert)
            <div class="event-row">
              <div class="event-row__date">
                <span class="event-row__day">{{ $concert->starts_at?->format('d') }}</span>
                <span class="event-row__month">{{ $concert->starts_at?->locale('ru')->translatedFormat('M') }}</span>
              </div>
              <div>
                <h3 class="event-row__title">{{ $concert->title }}</h3>
                <p class="event-row__place">
                  <svg aria-hidden="true" style="width:14px;height:14px;display:inline;vertical-align:-2px"><use href="#icon-pin" /></svg>
                  {{ collect([$concert->city, $concert->venue])->filter()->implode(', ') }}
                </p>
              </div>
              <a class="btn btn--outline btn--sm" href="{{ route('concerts.show', $concert) }}">Подробнее</a>
            </div>
          @empty
            <p>Ближайших мероприятий пока нет.</p>
          @endforelse
        </div>
      </div>
    </section>

    <!-- ================= БЛАГОТВОРИТЕЛЬНЫЕ СБОРЫ ================= -->
    <section class="section section--muted" id="fundraising" aria-labelledby="fundraising-title">
      <div class="container">
        @if ($fundraising)
          <div class="fundraising" data-reveal>
            <div class="fundraising__grid">
              <div class="fundraising__gallery" aria-hidden="true">
                <div class="fundraising__photo"></div>
                <div class="fundraising__photo"></div>
                <div class="fundraising__photo"></div>
              </div>

              <div class="fundraising__content">
                <span class="badge badge--live">Сбор {{ mb_strtolower($fundraising->status->label()) }}</span>
                <p class="eyebrow">Благотворительность</p>
                <h2 id="fundraising-title">{{ $fundraising->title }}</h2>
                @if ($fundraising->lead)
                  <p class="lead">{{ $fundraising->lead }}</p>
                @endif

                <div class="progress" data-progress data-goal="{{ $fundraising->goal_amount }}" data-current="{{ $fundraising->current_amount }}">
                  <div class="progress__meta">
                    <span class="progress__sum"><span data-progress-current="0">0</span> ₽</span>
                    <span class="progress__goal">из {{ number_format($fundraising->goal_amount, 0, ',', ' ') }} ₽</span>
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
        @else
          <p data-reveal>Активный сбор на главной не выбран. Создайте сбор и отметьте «На главной».</p>
        @endif
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
              <span class="requisite-card__value">{{ $settings->card_number ?: '—' }}</span>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">Получатель</span>
              <span class="requisite-card__value">{{ $settings->recipient ?: '—' }}</span>
            </div>
            @if ($cardDigits)
              <button class="requisite-card__copy" type="button" data-copy="{{ $cardDigits }}">
                <svg aria-hidden="true"><use href="#icon-copy" /></svg>
                Скопировать номер
              </button>
            @endif
          </div>

          <div class="requisite-card" data-reveal>
            <div class="requisite-card__head">
              <span class="requisite-card__icon"><svg aria-hidden="true"><use href="#icon-document" /></svg></span>
              <h3 class="requisite-card__title">Для юридических лиц</h3>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">ИНН</span>
              <span class="requisite-card__value">{{ $settings->inn ?: '—' }}</span>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">Р/с</span>
              <span class="requisite-card__value">{{ $settings->bank_account ?: '—' }}</span>
            </div>
            <div class="requisite-card__row">
              <span class="requisite-card__label">БИК</span>
              <span class="requisite-card__value">{{ $settings->bik ?: '—' }}</span>
            </div>
            @if ($settings->inn || $settings->bank_account || $settings->bik)
              <button
                class="requisite-card__copy"
                type="button"
                data-copy="ИНН {{ $settings->inn }}, Р/с {{ $settings->bank_account }}, БИК {{ $settings->bik }}"
              >
                <svg aria-hidden="true"><use href="#icon-copy" /></svg>
                Скопировать реквизиты
              </button>
            @endif
          </div>

          <div class="requisite-card" data-reveal>
            <div class="requisite-card__head">
              <span class="requisite-card__icon"><svg aria-hidden="true"><use href="#icon-heart" /></svg></span>
              <h3 class="requisite-card__title">СБП / QR-код</h3>
            </div>
            <p class="requisite-card__value" style="text-align:left">
              Отсканируйте QR-код в приложении банка — сумма перевода не ограничена.
            </p>
            @php $qr = \App\Support\MediaUrl::make($settings->qr_image_path); @endphp
            <div class="requisite-card__qr" role="img" aria-label="QR-код для перевода через Систему быстрых платежей">
              @if ($qr)
                <img src="{{ $qr }}" alt="QR-код для перевода" width="160" height="160" />
              @else
                <p style="padding:1rem;color:var(--color-text-dim)">Загрузите QR в настройках сайта.</p>
              @endif
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

      @if ($partners->isNotEmpty())
        <div class="partners__marquee-wrap">
          <div class="marquee">
            <ul class="marquee__track">
              @foreach ([false, true] as $isClone)
                @foreach ($partners as $partner)
                  <li class="marquee__item" @if ($isClone) aria-hidden="true" @endif>
                    @if ($partner->url)
                      <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer">{{ $partner->name }}</a>
                    @else
                      {{ $partner->name }}
                    @endif
                  </li>
                @endforeach
              @endforeach
            </ul>
          </div>
        </div>
      @else
        <div class="container"><p data-reveal>Партнёры пока не добавлены.</p></div>
      @endif
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
            @if ($settings->phone)
              <div class="contacts__info-item">
                <span class="contacts__info-icon"><svg aria-hidden="true"><use href="#icon-phone" /></svg></span>
                <div>
                  <span class="contacts__info-label">Телефон</span>
                  <a class="contacts__info-value" href="tel:{{ preg_replace('/\D+/', '', $settings->phone) }}">{{ $settings->phone }}</a>
                </div>
              </div>
            @endif
            @if ($settings->email)
              <div class="contacts__info-item">
                <span class="contacts__info-icon"><svg aria-hidden="true"><use href="#icon-mail" /></svg></span>
                <div>
                  <span class="contacts__info-label">Email</span>
                  <a class="contacts__info-value" href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                </div>
              </div>
            @endif
            @if ($settings->address)
              <div class="contacts__info-item">
                <span class="contacts__info-icon"><svg aria-hidden="true"><use href="#icon-pin" /></svg></span>
                <div>
                  <span class="contacts__info-label">Офис</span>
                  <p class="contacts__info-value">{{ $settings->address }}</p>
                </div>
              </div>
            @endif
            <div class="footer__social">
              @if ($settings->vk_url)
                <a class="footer__social-link" href="{{ $settings->vk_url }}" target="_blank" rel="noopener noreferrer" aria-label="Группа во ВКонтакте">
                  <svg aria-hidden="true"><use href="#icon-vk" /></svg>
                </a>
              @endif
              @if ($settings->telegram_url)
                <a class="footer__social-link" href="{{ $settings->telegram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Канал в Telegram">
                  <svg aria-hidden="true"><use href="#icon-telegram" /></svg>
                </a>
              @endif
              @if ($settings->youtube_url)
                <a class="footer__social-link" href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer" aria-label="Канал на YouTube">
                  <svg aria-hidden="true"><use href="#icon-youtube" /></svg>
                </a>
              @endif
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
