@extends('layouts.app')

@section('title', $report->meta_title ?: ($report->title.' — фоторепортаж'))
@section('description', $report->meta_description ?: ($report->excerpt ?: ''))
@section('canonical_path', "/photos/{$report->slug}")
@section('og_type', "article")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/photo-report.js'])
@endsection

@section('content')
<section class="section section--top-offset">
  <div class="container">
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
      <ol class="breadcrumbs__list">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('photos.index') }}">Фото</a></li>
        <li class="breadcrumbs__item" aria-current="page">{{ $report->title }}</li>
      </ol>
    </nav>

    <header data-reveal>
      <span class="badge badge--gold">{{ $report->category->label() }}</span>
      <h1 style="margin-top: var(--space-4)">{{ $report->title }}</h1>
      <p class="lead">{{ $report->lead ?: $report->excerpt }}</p>
      <p class="card__meta">{{ $report->report_date?->format('d.m.Y') }}</p>
    </header>

    <div class="photo-gallery" data-gallery data-reveal style="margin-top: var(--space-8)">
      @foreach ($report->photos as $photo)
        <button
          class="photo-gallery__item card__media--placeholder"
          type="button"
          aria-label="{{ $photo->alt ?: $photo->caption }}"
        >
          <svg aria-hidden="true"><use href="#icon-camera" /></svg>
          @if ($photo->caption)<span class="visually-hidden">{{ $photo->caption }}</span>@endif
        </button>
      @endforeach
    </div>
  </div>
</section>
@endsection
