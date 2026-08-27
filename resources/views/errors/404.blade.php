@extends('layouts.app')

@section('title', 'Страница не найдена — Русский Маяк')
@section('description', 'Запрашиваемая страница не найдена на официальном сайте группы «Русский Маяк».')
@section('canonical_path', '/404')
@section('og_type', 'website')

@section('content')
  <section class="section">
    <div class="container" style="max-width: 40rem; text-align: center">
      <p class="eyebrow" data-reveal>Ошибка 404</p>
      <h1 data-reveal>Страница не найдена</h1>
      <p class="lead" data-reveal>Такой страницы нет или она ещё не опубликована.</p>
      <div class="hero__actions" data-reveal style="justify-content: center">
        <a class="btn btn--primary" href="{{ route('home') }}">На главную</a>
        <a class="btn btn--outline" href="{{ route('news.index') }}">Новости</a>
      </div>
    </div>
  </section>
@endsection
