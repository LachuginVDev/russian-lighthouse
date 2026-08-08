@extends('layouts.app')

@section('title', $page->meta_title ?: ($page->title.' — Русский Маяк'))
@section('description', $page->meta_description ?: 'Политика обработки персональных данных официального сайта музыкальной группы «Русский Маяк».')
@section('canonical_path', '/privacy')
@section('og_type', 'website')

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/static.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Документы"
    :title="$page->title"
    subtitle="Как мы обрабатываем и защищаем персональные данные посетителей сайта."
    current="Конфиденциальность"
  />

  <section class="section">
    <div class="container" style="max-width: 48rem">
      <article class="article__body" data-reveal>
        {!! $page->body !!}
      </article>
    </div>
  </section>
@endsection
