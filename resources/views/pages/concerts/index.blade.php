@extends('layouts.app')

@section('title', "Афиша концертов — Русский Маяк")
@section('description', "Ближайшие и прошедшие концерты группы «Русский Маяк».")
@section('canonical_path', "/concerts")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/concerts.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Афиша"
    title="Концерты"
    subtitle="Благотворительные вечера, акустика в госпиталях и поездки."
    current="Концерты"
  />

  <section class="section">
    <div class="container">
      <h2 class="section-title" style="margin-bottom: var(--space-6)">Скоро</h2>
      <div class="grid grid--3" data-listing="concerts-upcoming">
        @forelse ($upcoming as $concert)
          @php $cover = \App\Support\MediaUrl::make($concert->cover_path); @endphp
          <article class="card">
            @if ($cover)
              <a class="card__media" href="{{ route('concerts.show', $concert) }}" style="background-image: url('{{ $cover }}')" aria-label="{{ $concert->title }}"></a>
            @else
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            @endif
            <div class="card__body">
              <span class="card__meta">
                <span class="badge badge--gold">{{ $concert->badge_type->label() }}</span>
                {{ $concert->starts_at->format('d.m.Y H:i') }}
              </span>
              <h3 class="card__title">{{ $concert->title }}</h3>
              <p class="card__text">{{ $concert->city }}@if($concert->venue) · {{ $concert->venue }}@endif</p>
              <a class="card__link" href="{{ route('concerts.show', $concert) }}">Подробнее <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
            </div>
          </article>
        @empty
          <p>Ближайших концертов пока нет.</p>
        @endforelse
      </div>

      <h2 class="section-title" style="margin: var(--space-10) 0 var(--space-6)">Прошедшие</h2>
      <div class="grid grid--3" data-listing="concerts-past">
        @forelse ($past as $concert)
          <article class="card">
            <div class="card__body">
              <span class="card__meta">{{ $concert->starts_at->format('d.m.Y') }} · {{ $concert->city }}</span>
              <h3 class="card__title">{{ $concert->title }}</h3>
              <a class="card__link" href="{{ route('concerts.show', $concert) }}">Подробнее <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
            </div>
          </article>
        @empty
          <p>Архив пуст.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
