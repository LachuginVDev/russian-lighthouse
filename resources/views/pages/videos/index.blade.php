@extends('layouts.app')

@section('title', "Видео — Русский Маяк")
@section('description', "Видеогалерея группы «Русский Маяк»: концерты, поездки, клипы и закулисье.")
@section('canonical_path', "/video")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/video.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Видео"
    title="Видеогалерея"
    subtitle="Концерты, поездки и клипы — смотрите в модальном окне."
    current="Видео"
  />

  <section class="section">
    <div class="container">
      <div class="listing-toolbar">
        <div class="tag-list" role="tablist" aria-label="Фильтр по категории" data-filters>
          <button class="tag is-active" type="button" role="tab" aria-selected="true" data-filter="all">Все</button>
          @foreach (\App\Enums\VideoCategory::cases() as $category)
            <button class="tag" type="button" role="tab" aria-selected="false" data-filter="{{ $category->value }}">{{ $category->label() }}</button>
          @endforeach
        </div>
        <span class="listing-count" data-count-label="видео">{{ $videos->count() }}</span>
      </div>

      <div class="grid grid--3" data-listing="videos">
        @forelse ($videos as $video)
          <article class="card card--video" data-category="{{ $video->category->value }}">
            <button
              class="card__media card__media--placeholder"
              type="button"
              data-video-trigger
              data-video-embed="{{ $video->embed_url }}"
              data-video-title="{{ $video->title }}"
              aria-label="Смотреть: {{ $video->title }}"
            >
              <svg aria-hidden="true"><use href="#icon-play" /></svg>
            </button>
            <div class="card__body">
              <span class="card__meta">{{ $video->type_label }} · {{ $video->duration_label }}</span>
              <h2 class="card__title">{{ $video->title }}</h2>
            </div>
          </article>
        @empty
          <p>Видео скоро появятся.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
