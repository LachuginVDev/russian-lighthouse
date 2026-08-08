@extends('layouts.app')

@section('title', "Новости — Русский Маяк")
@section('description', "Новости группы «Русский Маяк»: поездки в госпитали и зону СВО, релизы, концерты и благотворительные сборы.")
@section('canonical_path', "/news")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/news.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Новости"
    title="События и поездки"
    subtitle="Релизы, концерты, поездки в госпитали и отчёты о сборах."
    current="Новости"
  />

  <section class="section">
    <div class="container">
      <div class="listing-toolbar">
        <div class="tag-list" role="tablist" aria-label="Фильтр по теме" data-filters>
          <button class="tag is-active" type="button" role="tab" aria-selected="true" data-filter="all">Все</button>
          @foreach (\App\Enums\NewsCategory::cases() as $category)
            <button class="tag" type="button" role="tab" aria-selected="false" data-filter="{{ $category->value }}">{{ $category->label() }}</button>
          @endforeach
        </div>
        <span class="listing-count" data-count-label="новостей">{{ $news->count() }}</span>
      </div>

      <div class="grid grid--3" data-listing="news">
        @forelse ($news as $item)
          <article class="card" data-category="{{ $item->category->value }}">
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta">{{ $item->published_at?->format('d.m.Y') }} · {{ $item->category->label() }}</span>
              <h2 class="card__title">{{ $item->title }}</h2>
              <p class="card__text">{{ $item->excerpt }}</p>
              <a class="card__link" href="{{ route('news.show', $item) }}">Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
            </div>
          </article>
        @empty
          <p>Новостей пока нет.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
