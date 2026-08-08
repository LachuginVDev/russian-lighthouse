@extends('layouts.app')

@section('title', $album->meta_title ?: "Альбом «{$album->title}» — Русский Маяк")
@section('description', $album->meta_description ?: ($album->excerpt ?: ''))
@section('canonical_path', "/albums/{$album->slug}")
@section('og_type', "music.album")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/album.js'])
@endsection

@section('content')
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "MusicAlbum",
      "name": @json($album->title),
      "byArtist": { "@@type": "MusicGroup", "name": "Русский Маяк" },
      "datePublished": @json((string) $album->year),
      "genre": @json($album->genre),
      "numTracks": {{ $album->tracks->count() }}
    }
  </script>

<section class="section section--top-offset">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
          <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('albums.index') }}">Дискография</a></li>
            <li class="breadcrumbs__item" aria-current="page">{{ $album->title }}</li>
          </ol>
        </nav>

        <div class="album-hero">
          <div class="album-hero__cover" data-reveal></div>
          <div data-reveal>
            @if ($album->badge_label)
              <span class="badge badge--gold">{{ $album->badge_label }}</span>
            @endif
            <h1 style="margin-top: var(--space-4)">{{ $album->title }}</h1>
            <p class="lead" style="margin-top: var(--space-3)">{{ $album->excerpt }}</p>
            <div class="album-hero__meta">
              @if ($album->year)<span>Год: {{ $album->year }}</span>@endif
              <span>Треков: {{ $album->tracks->count() }}</span>
              @if ($album->duration_label)<span>Длительность: {{ $album->duration_label }}</span>@endif
              @if ($album->genre)<span>Жанр: {{ $album->genre }}</span>@endif
            </div>
            <div class="album-hero__actions">
              <a class="btn btn--primary" href="#tracklist">
                <svg aria-hidden="true"><use href="#icon-play" /></svg>
                Слушать альбом
              </a>
              @if ($album->vk_url)
                <a class="btn btn--outline btn--sm" href="{{ $album->vk_url }}" target="_blank" rel="noopener noreferrer">VK Музыка</a>
              @endif
              @if ($album->youtube_music_url)
                <a class="btn btn--outline btn--sm" href="{{ $album->youtube_music_url }}" target="_blank" rel="noopener noreferrer">YouTube Music</a>
              @endif
            </div>
          </div>
        </div>

        <div id="tracklist" class="player" data-reveal data-player>
          <div class="player__stage">
            <div class="player__cover" data-player-cover>
              <div class="player__cover-img" role="img" aria-label="Обложка альбома «{{ $album->title }}»"></div>
            </div>

            <div class="player__track-info">
              <span class="player__track-title" data-player-title>{{ $album->tracks->first()?->title }}</span>
              <span class="player__track-artist" data-player-artist>{{ $album->tracks->first()?->artist }}</span>
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
            @foreach ($album->tracks as $index => $track)
              @php
                $trackSrc = \App\Support\MediaUrl::make($track->audio_path);
                $trackCover = \App\Support\MediaUrl::make($track->cover_path ?: $album->cover_path);
              @endphp
              <button
                class="player__track @if($index === 0) is-active @endif"
                type="button"
                role="listitem"
                data-track
                data-src="{{ $trackSrc }}"
                data-title="{{ $track->title }}"
                data-artist="{{ $track->artist }}"
                data-duration="{{ $track->duration }}"
                data-cover="{{ $trackCover }}"
              >
                <span class="player__track-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                <span class="player__track-name"><strong>{{ $track->title }}</strong><span>{{ $album->title }}</span></span>
                <span class="player__track-duration">{{ $track->duration }}</span>
              </button>
            @endforeach
          </div>
        </div>

        @if ($album->description)
          <div class="album-body" data-reveal>
            <h2>История создания</h2>
            {!! $album->description !!}
          </div>
        @endif
      </div>
    </section>
@endsection
