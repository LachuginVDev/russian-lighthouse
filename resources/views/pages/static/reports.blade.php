@extends('layouts.app')

@section('title', ($page->meta_title ?? null) ?: 'Отчёты о помощи — Русский Маяк')
@section('description', ($page->meta_description ?? null) ?: 'Отчёты о благотворительных сборах и помощи группы «Русский Маяк».')
@section('canonical_path', '/reports')
@section('og_type', 'website')

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/static.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Прозрачность"
    :title="$page->title ?? 'Отчёты о помощи'"
    subtitle="Публикуем итоги сборов и поездок."
    current="Отчёты"
  />

  <section class="section">
    <div class="container" style="max-width: 48rem">
      @if ($page?->body)
        <article class="article__body" data-reveal>
          {!! $page->body !!}
        </article>
      @endif

      <div class="grid grid--1" style="margin-top: var(--space-8)">
        @forelse ($reports as $report)
          <article class="card" data-reveal>
            <div class="card__body">
              <span class="card__meta">{{ $report->published_at?->format('d.m.Y') }}</span>
              <h2 class="card__title">{{ $report->title }}</h2>
              <div class="card__text">{!! $report->body !!}</div>
            </div>
          </article>
        @empty
          <p>Отчёты появятся после завершения сборов.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
