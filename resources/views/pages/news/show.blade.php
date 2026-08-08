@extends('layouts.app')

@section('title', $item->meta_title ?: ($item->title.' — новости «Русского Маяка»'))
@section('description', $item->meta_description ?: ($item->excerpt ?: ''))
@section('canonical_path', "/news/{$item->slug}")
@section('og_type', "article")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/news-single.js'])
@endsection

@section('content')
@php
  preg_match_all('/<h2[^>]*\bid=["\']([^"\']+)["\'][^>]*>(.*?)<\/h2>/is', $item->body ?? '', $tocMatches, PREG_SET_ORDER);
  $tocItems = collect($tocMatches)->map(fn ($m) => [
      'id' => $m[1],
      'title' => trim(html_entity_decode(strip_tags($m[2]))),
  ]);

  $playerHtml = '';
  if ($item->embeddedTrack) {
      $track = $item->embeddedTrack;
      $title = e($track->title);
      $artist = e($track->artist);
      $src = e($track->audio_path);
      $duration = e($track->duration);
      $playerHtml = <<<HTML
<div class="article__player-embed" data-player>
  <div class="player__stage">
    <div class="player__cover" data-player-cover>
      <div class="player__cover-img" role="img" aria-label="Обложка «{$title}»"></div>
    </div>
    <div class="player__track-info">
      <span class="player__track-title" data-player-title>{$title}</span>
      <span class="player__track-artist" data-player-artist>{$artist}</span>
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
    <button class="player__track is-active" type="button" role="listitem" data-track data-src="{$src}" data-title="{$title}" data-artist="{$artist}" data-duration="{$duration}">
      <span class="player__track-index">●</span>
      <span class="player__track-name"><strong>{$title}</strong><span>{$artist}</span></span>
      <span class="player__track-duration">{$duration}</span>
    </button>
  </div>
</div>
HTML;
  }

  $bodyHtml = $item->body ?? '';
  if ($playerHtml !== '' && str_contains($bodyHtml, '<!-- embedded-player -->')) {
      $bodyHtml = str_replace('<!-- embedded-player -->', $playerHtml, $bodyHtml);
  } elseif ($playerHtml !== '') {
      $bodyHtml .= $playerHtml;
  }
@endphp

<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "NewsArticle",
      "headline": @json($item->title),
      "datePublished": @json(optional($item->published_at)->toDateString()),
      "author": { "@@type": "Person", "name": @json($item->author_name ?: 'Редакция') },
      "publisher": { "@@type": "Organization", "name": "Русский Маяк" },
      "keywords": @json($item->tags->pluck('name')->implode(', '))
    }
  </script>

<section class="section section--top-offset">
  <div class="container">
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
      <ol class="breadcrumbs__list">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('news.index') }}">Новости</a></li>
        <li class="breadcrumbs__item" aria-current="page">{{ $item->title }}</li>
      </ol>
    </nav>

    @if ($item->tags->isNotEmpty())
      <div class="tag-list" data-reveal>
        @foreach ($item->tags as $tag)
          <span class="tag">{{ $tag->name }}</span>
        @endforeach
      </div>
    @endif

    <h1 style="margin-top: var(--space-4)" data-reveal>{{ $item->title }}</h1>

    <div class="article-meta" data-reveal>
      @if ($item->author_name)
        <div class="author-chip">
          <span class="author-chip__avatar" aria-hidden="true">{{ $item->author_initials ?: mb_substr($item->author_name, 0, 1) }}</span>
          <span>
            <span class="author-chip__name">{{ $item->author_name }}</span><br />
            @if ($item->author_role)
              <span class="author-chip__role">{{ $item->author_role }}</span>
            @endif
          </span>
        </div>
      @endif
      @if ($item->published_at)
        <span class="article-meta__item">
          <svg aria-hidden="true"><use href="#icon-calendar" /></svg>
          {{ $item->published_at->locale('ru')->translatedFormat('j F Y') }}
        </span>
      @endif
      @if ($item->reading_time)
        <span class="article-meta__item">Чтение: {{ $item->reading_time }}</span>
      @endif
    </div>

    <div class="article__cover" style="margin-top: var(--space-8)" data-reveal></div>

    <div class="article__layout">
      <article class="article__body" data-reveal>
        {!! $bodyHtml !!}

        @if ($item->tags->isNotEmpty())
          <div class="article__tags">
            <div class="tag-list">
              @foreach ($item->tags as $tag)
                <a class="tag" href="{{ route('news.index') }}">{{ $tag->name }}</a>
              @endforeach
            </div>
          </div>
        @endif
      </article>

      @if ($tocItems->isNotEmpty())
        <aside class="toc" data-toc aria-label="Содержание статьи">
          <span class="toc__heading">Содержание</span>
          <nav>
            <ul class="toc__list">
              @foreach ($tocItems as $tocItem)
                <li>
                  <a class="toc__link" href="#{{ $tocItem['id'] }}" data-toc-link>{{ $tocItem['title'] }}</a>
                </li>
              @endforeach
            </ul>
          </nav>
        </aside>
      @endif
    </div>

    @if (isset($related) && $related->isNotEmpty())
      <div class="article__related">
        <div class="section-head">
          <p class="eyebrow">Новости</p>
          <h2>Похожие новости</h2>
        </div>
        <div class="grid grid--3">
          @foreach ($related as $relatedItem)
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta">
                  @if ($relatedItem->published_at)
                    <time datetime="{{ $relatedItem->published_at->toDateString() }}">{{ $relatedItem->published_at->locale('ru')->translatedFormat('j F Y') }}</time>
                  @endif
                  · {{ $relatedItem->category->label() }}
                </span>
                <h3 class="card__title">{{ $relatedItem->title }}</h3>
                <a class="card__link" href="{{ route('news.show', $relatedItem) }}">Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
