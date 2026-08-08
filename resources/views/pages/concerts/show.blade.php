@extends('layouts.app')

@section('title', $concert->meta_title ?: ($concert->title.' — концерт'))
@section('description', $concert->meta_description ?: ($concert->excerpt ?: ''))
@section('canonical_path', "/concerts/{$concert->slug}")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/concert-single.js'])
@endsection

@section('content')
@php
  $eventAddress = collect([$concert->city, $concert->address])->filter()->implode(', ');
@endphp
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Event",
      "name": @json($concert->title),
      "startDate": @json(optional($concert->starts_at)->toIso8601String()),
      "eventStatus": "https://schema.org/EventScheduled",
      "location": {
        "@@type": "Place",
        "name": @json($concert->venue),
        "address": @json($eventAddress)
      }
    }
  </script>

<section class="section section--top-offset">
  <div class="container">
    <nav class="breadcrumbs" aria-label="Хлебные крошки">
      <ol class="breadcrumbs__list">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('concerts.index') }}">Концерты</a></li>
        <li class="breadcrumbs__item" aria-current="page">{{ $concert->title }}</li>
      </ol>
    </nav>

    <header data-reveal>
      <span class="badge badge--gold">{{ $concert->badge_type->label() }}</span>
      <h1 style="margin-top: var(--space-4)">{{ $concert->title }}</h1>
      <p class="lead">{{ $concert->excerpt }}</p>
      <div class="album-hero__meta">
        <span>{{ $concert->starts_at->format('d.m.Y H:i') }}</span>
        @if ($concert->city)<span>{{ $concert->city }}</span>@endif
        @if ($concert->venue)<span>{{ $concert->venue }}</span>@endif
        @if ($concert->ticket_status_label)<span>{{ $concert->ticket_status_label }}</span>@endif
      </div>
      @if ($concert->ticket_url)
        <p style="margin-top: var(--space-4)">
          <a class="btn btn--primary" href="{{ $concert->ticket_url }}">Билеты</a>
        </p>
      @endif
    </header>

    @if ($concert->body)
      <article class="article__body" data-reveal style="margin-top: var(--space-8)">
        {!! $concert->body !!}
      </article>
    @endif
  </div>
</section>
@endsection
