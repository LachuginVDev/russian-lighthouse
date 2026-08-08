@extends('layouts.app')

@section('title', $item->meta_title ?: ($item->title.' — новости «Русского Маяка»'))
@section('description', $item->meta_description ?: ($item->excerpt ?: ''))
@section('canonical_path', "/news/{$item->slug}")
@section('og_type', "article")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/news-single.js'])
@endsection

@section('content')
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "NewsArticle",
      "headline": @json($item->title),
      "datePublished": @json(optional($item->published_at)->toDateString()),
      "author": { "@@type": "Person", "name": @json($item->author_name ?: 'Редакция') },
      "publisher": { "@@type": "Organization", "name": "Русский Маяк" }
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

    <div class="tag-list" data-reveal>
      @foreach ($item->tags as $tag)
        <span class="tag">{{ $tag->name }}</span>
      @endforeach
      <span class="tag">{{ $item->category->label() }}</span>
    </div>

    <header class="article__header" data-reveal>
      <h1>{{ $item->title }}</h1>
      <p class="lead">{{ $item->excerpt }}</p>
      <div class="article__meta">
        <span>{{ $item->published_at?->format('d.m.Y') }}</span>
        @if ($item->reading_time)<span>{{ $item->reading_time }}</span>@endif
        @if ($item->author_name)
          <span class="author-chip" aria-label="Автор">
            <span class="author-chip__initials">{{ $item->author_initials }}</span>
            <span>
              <strong>{{ $item->author_name }}</strong>
              @if ($item->author_role)<small>{{ $item->author_role }}</small>@endif
            </span>
          </span>
        @endif
      </div>
    </header>

    <div class="article__layout">
      <aside class="article__toc" data-toc data-reveal>
        <p class="eyebrow">Содержание</p>
      </aside>
      <article class="article__body" data-reveal>
        {!! $item->body !!}
      </article>
    </div>
  </div>
</section>
@endsection
