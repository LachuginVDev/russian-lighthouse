@extends('layouts.app')

@section('title', "Дискография — все альбомы группы «Русский Маяк»")
@section('description', "Полная дискография группы «Русский Маяк»: альбомы о силе духа, доме и передовой. Слушайте песни, которые звучат в госпиталях и в зоне СВО.")
@section('canonical_path', "/albums")
@section('og_type', "website")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/albums.js'])
@endsection

@section('content')
  <x-page-header
    eyebrow="Дискография"
    title="Все альбомы"
    subtitle="Каждый альбом «Русского Маяка» — это часть истории: от первых песен о доме до записей, рождённых в поездках на передовую."
    current="Альбомы"
  />

  <section class="section">
    <div class="container">
      <div class="listing-toolbar">
        <div class="tag-list" role="tablist" aria-label="Фильтр по году" data-filters>
          <button class="tag is-active" type="button" role="tab" aria-selected="true" data-filter="all">Все годы</button>
          @foreach ($years as $year)
            <button class="tag" type="button" role="tab" aria-selected="false" data-filter="{{ $year }}">{{ $year }}</button>
          @endforeach
        </div>
        <span class="listing-count" data-count-label="альбомов">{{ $albums->count() }} альбомов</span>
      </div>

      <div class="grid grid--3" data-listing="albums">
        @forelse ($albums as $album)
          @php $cover = \App\Support\MediaUrl::make($album->cover_path); @endphp
          <article class="card" data-category="{{ $album->year }}">
            @if ($cover)
              <a class="card__media" href="{{ route('albums.show', $album) }}" style="background-image: url('{{ $cover }}')" aria-label="{{ $album->title }}"></a>
            @else
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
            @endif
            <div class="card__body">
              <span class="card__meta">
                @if ($album->status === \App\Enums\AlbumStatus::ComingSoon)
                  <span class="badge badge--live">{{ $album->badge_label ?: 'Скоро' }}</span>
                @elseif ($album->badge_label)
                  <span class="badge badge--gold">{{ $album->badge_label }}</span>
                @endif
                {{ $album->year }} · {{ $album->type->label() }}
              </span>
              <h2 class="card__title">{{ $album->title }}</h2>
              <p class="card__text">{{ $album->excerpt }}</p>
              <a class="card__link" href="{{ route('albums.show', $album) }}">Подробнее <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
            </div>
          </article>
        @empty
          <p>Альбомы скоро появятся.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
