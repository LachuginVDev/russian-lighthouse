@extends('layouts.app')

@section('title', "Гуманитарный конвой в зону СВО — фоторепортаж")
@section('description', "Фоторепортаж о поездке группы «Русский Маяк» с гуманитарным конвоем в зону СВО: концерт для бойцов, передача груза, дорога на передовую.")
@section('canonical_path', "/photos/gumanitarnyy-konvoy")
@section('og_type', "article")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/photo-report.js'])
@endsection

@section('content')
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Главная", "item": "https://russkiy-mayak.ru/" },
        { "@@type": "ListItem", "position": 2, "name": "Фотогалерея", "item": "https://russkiy-mayak.ru/photos" },
        { "@@type": "ListItem", "position": 3, "name": "Гуманитарный конвой в зону СВО" }
      ]
    }
  </script>

<section class="section section--top-offset">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
          <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('photos.index') }}">Фотогалерея</a></li>
            <li class="breadcrumbs__item" aria-current="page">Гуманитарный конвой в зону СВО</li>
          </ol>
        </nav>

        <p class="eyebrow" data-reveal>Фоторепортаж · Поездки</p>
        <h1 data-reveal>Гуманитарный конвой в зону СВО</h1>
        <div class="article-meta" data-reveal>
          <span class="article-meta__item"><svg aria-hidden="true"><use href="#icon-calendar" /></svg> 20 июля 2026</span>
          <span class="article-meta__item"><svg aria-hidden="true"><use href="#icon-camera" /></svg> 8 фотографий</span>
        </div>
        <p class="lead" style="margin-top: var(--space-5)" data-reveal>
          Раз в несколько недель «Русский Маяк» сопровождает гуманитарные конвои: инструменты едут в одной машине
          с медикаментами и амуницией. В этой поездке мы показываем весь путь — от загрузки груза до полевого
          концерта на месте.
        </p>

        <div class="photo-gallery" style="margin-top: var(--space-9)" data-gallery>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 1: загрузка гуманитарного груза">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 2: дорога в зону СВО">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 3: передача груза">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 4: полевой концерт">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 5: бойцы слушают музыку">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 6: разговор после концерта">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 7: обратная дорога">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
          <button class="photo-gallery__item" type="button" data-reveal aria-label="Открыть фотографию 8: закат в пути">
            <span class="photo-gallery__zoom"><svg aria-hidden="true"><use href="#icon-zoom" /></svg></span>
          </button>
        </div>

        <div class="article__related">
          <div class="section-head">
            <p class="eyebrow">Фотогалерея</p>
            <h2>Другие фоторепортажи</h2>
          </div>
          <div class="grid grid--3">
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta"><time datetime="2026-07-12">12 июля 2026</time> · 18 фото</span>
                <h3 class="card__title">Концерт в госпитале Ростова</h3>
                <a class="card__link" href="{{ route('photos.show', 'gumanitarnyy-konvoy') }}">Смотреть <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta"><time datetime="2026-06-14">14 июня 2026</time> · 32 фото</span>
                <h3 class="card__title">«Свет для героев»: концерт в Москве</h3>
                <a class="card__link" href="{{ route('photos.show', 'gumanitarnyy-konvoy') }}">Смотреть <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta"><time datetime="2026-05-08">8 мая 2026</time> · 27 фото</span>
                <h3 class="card__title">Встреча с бойцами на передовой</h3>
                <a class="card__link" href="{{ route('photos.show', 'gumanitarnyy-konvoy') }}">Смотреть <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
@endsection
