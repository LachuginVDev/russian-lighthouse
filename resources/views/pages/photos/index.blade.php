@extends('layouts.app')

@section('title', "Фоторепортажи — Русский Маяк")
@section('description', "Фоторепортажи группы «Русский Маяк»: поездки, госпитали, концерты и закулисье.")
@section('canonical_path', "/photos")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/photos.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Фото"
    title="Фоторепортажи"
    subtitle="Кадры с поездок, концертов и встреч в госпиталях."
    current="Фото"
  />

  <section class="section">
    <div class="container">
      <div class="listing-toolbar">
        <div class="tag-list" role="tablist" aria-label="Фильтр" data-filters>
          <button class="tag is-active" type="button" role="tab" aria-selected="true" data-filter="all">Все</button>
          @foreach (\App\Enums\PhotoReportCategory::cases() as $category)
            <button class="tag" type="button" role="tab" aria-selected="false" data-filter="{{ $category->value }}">{{ $category->label() }}</button>
          @endforeach
        </div>
        <span class="listing-count" data-count-label="репортажей">{{ $reports->count() }}</span>
      </div>

      <div class="grid grid--3" data-listing="photos">
        @forelse ($reports as $report)
          <article class="card" data-category="{{ $report->category->value }}">
            <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            <div class="card__body">
              <span class="card__meta">{{ $report->report_date?->format('d.m.Y') }} · {{ $report->category->label() }}</span>
              <h2 class="card__title">{{ $report->title }}</h2>
              <p class="card__text">{{ $report->excerpt }}</p>
              <a class="card__link" href="{{ route('photos.show', $report) }}">Смотреть <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
            </div>
          </article>
        @empty
          <p>Репортажей пока нет.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
