@extends('layouts.app')

@section('title', 'Отчёты о помощи — Русский Маяк')
@section('description', 'Открытые отчёты о благотворительных сборах и расходах группы «Русский Маяк».')
@section('canonical_path', '/reports')
@section('og_type', 'website')

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/static.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Прозрачность"
    title="Отчёты о помощи"
    subtitle="Публикуем, на что направлены собранные средства: оборудование, гуманитарные грузы, поддержка госпиталей."
    current="Отчёты"
  />

  <section class="section">
    <div class="container">
      <div class="grid grid--2">
        <article class="card" data-reveal>
          <div class="card__body">
            <span class="card__meta"><time datetime="2026-06-05">5 июня 2026</time></span>
            <h2 class="card__title">Отчёт: сбор на реабилитационное оборудование</h2>
            <p class="card__text">Собрано 2 000 000 ₽. Средства направлены на закупку тренажёров и расходных материалов для госпиталя.</p>
            <a class="card__link" href="{{ route('home') }}#fundraising">
              К текущему сбору <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
            </a>
          </div>
        </article>

        <article class="card" data-reveal>
          <div class="card__body">
            <span class="card__meta"><time datetime="2026-03-18">18 марта 2026</time></span>
            <h2 class="card__title">Отчёт: гуманитарный конвой</h2>
            <p class="card__text">Закупка медикаментов и тёплых вещей. Полный список позиций и суммы — в детальном отчёте (этап CMS).</p>
            <a class="card__link" href="{{ route('photos.show', 'gumanitarnyy-konvoy') }}">
              Фоторепортаж <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg>
            </a>
          </div>
        </article>
      </div>
    </div>
  </section>
@endsection
