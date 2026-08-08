@extends('layouts.app')

@section('title', "Новая поездка в госпиталь Ростова — новости «Русского Маяка»")
@section('description', "Отчёт о поездке группы «Русский Маяк» в военный госпиталь Ростова: концерт для бойцов, передача медицинского оборудования и разговоры о том, что помогает восстанавливаться.")
@section('canonical_path', "/news/gospital-rostov")
@section('og_type', "article")

@section('vite')
  @vite(['resources/scss/main.scss', 'resources/js/pages/news-single.js'])
@endsection

@section('content')
<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "NewsArticle",
      "headline": "Новая поездка в госпиталь Ростова",
      "datePublished": "2026-07-12",
      "author": { "@@type": "Person", "name": "Дарья Соколова" },
      "publisher": { "@@type": "Organization", "name": "Русский Маяк" },
      "keywords": "Поездки, Госпитали, Благотворительность"
    }
  </script>

<script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "BreadcrumbList",
      "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Главная", "item": "https://russkiy-mayak.ru/" },
        { "@@type": "ListItem", "position": 2, "name": "Новости", "item": "https://russkiy-mayak.ru/news" },
        { "@@type": "ListItem", "position": 3, "name": "Новая поездка в госпиталь Ростова" }
      ]
    }
  </script>

<section class="section section--top-offset">
      <div class="container">
        <nav class="breadcrumbs" aria-label="Хлебные крошки">
          <ol class="breadcrumbs__list">
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ route('news.index') }}">Новости</a></li>
            <li class="breadcrumbs__item" aria-current="page">Новая поездка в госпиталь Ростова</li>
          </ol>
        </nav>

        <div class="tag-list" data-reveal>
          <span class="tag">Поездки</span>
          <span class="tag">Госпитали</span>
          <span class="tag">Благотворительность</span>
        </div>

        <h1 style="margin-top: var(--space-4)" data-reveal>Новая поездка в госпиталь Ростова</h1>

        <div class="article-meta" data-reveal>
          <div class="author-chip">
            <span class="author-chip__avatar" aria-hidden="true">ДС</span>
            <span>
              <span class="author-chip__name">Дарья Соколова</span><br />
              <span class="author-chip__role">Автор новостей</span>
            </span>
          </div>
          <span class="article-meta__item"><svg aria-hidden="true"><use href="#icon-calendar" /></svg> 12 июля 2026</span>
          <span class="article-meta__item">Чтение: 4 минуты</span>
        </div>

        <div class="article__cover" style="margin-top: var(--space-8)" data-reveal></div>

        <div class="article__layout">
          <article class="article__body" data-reveal>
            <h2 id="nachalo">Как всё начиналось</h2>
            <p>
              В начале июля группа «Русский Маяк» вновь отправилась в Ростов-на-Дону — на этот раз в военный
              госпиталь, где проходят реабилитацию бойцы после ранений. Это уже седьмая подобная поездка коллектива
              в этом году: концерты в госпиталях стали такой же частью работы группы, как студийные записи и
              большие сцены.
            </p>
            <blockquote>
              «Когда играешь в палате, а не в зале на десять тысяч человек, музыка звучит иначе — честнее. Здесь
              нет места для показухи», — поделился лидер группы после концерта.
            </blockquote>

            <figure class="article__figure">
              <div class="article__figure-media" aria-hidden="true"></div>
              <figcaption class="article__figure-caption">Концерт в холле госпиталя собрал более 40 бойцов и медицинского персонала.</figcaption>
            </figure>

            <h2 id="chto-privezli">Что мы привезли</h2>
            <p>
              Помимо концертной программы, группа передала госпиталю партию медицинского оборудования для
              реабилитации, приобретённого на средства благотворительного сбора, объявленного весной. Среди
              переданного — тренажёры для восстановления мелкой моторики и расходные материалы для физиотерапии.
            </p>
            <ul>
              <li>3 тренажёра для восстановления мелкой моторики</li>
              <li>Комплект расходных материалов для физиотерапевтического кабинета</li>
              <li>Партия аудиоустройств для палат долгосрочного лечения</li>
            </ul>

            <h2 id="koncert">Запись концерта</h2>
            <p>
              Один из моментов концерта — акустическое исполнение песни «Позывной Надежда» — мы записали и
              публикуем здесь: именно эту версию бойцы попросили сыграть на бис.
            </p>

            <div class="article__player-embed" data-player>
              <div class="player__stage">
                <div class="player__cover" data-player-cover>
                  <div class="player__cover-img" role="img" aria-label="Обложка записи «Позывной Надежда» (акустика)"></div>
                </div>
                <div class="player__track-info">
                  <span class="player__track-title" data-player-title>Позывной Надежда (акустика)</span>
                  <span class="player__track-artist" data-player-artist>Русский Маяк · live в госпитале</span>
                </div>
                <div class="player__wave" aria-hidden="true" data-player-wave></div>
                <div class="player__controls">
                  <button class="player__control player__control--play" type="button" data-player-play aria-label="Воспроизвести">
                    <svg aria-hidden="true" data-player-play-icon><use href="#icon-play" /></svg>
                  </button>
                </div>
                <div class="player__seek">
                  <span data-player-current>0:00</span>
                  <span class="player__seek-track" data-player-seek>
                    <span class="player__seek-fill" data-player-seek-fill></span>
                    <input class="player__seek-input" type="range" min="0" max="100" value="0" aria-label="Перемотка записи" data-player-seek-input />
                  </span>
                  <span data-player-duration>0:00</span>
                </div>
              </div>
              <div class="player__list" role="list" aria-label="Запись" data-player-list>
                <button class="player__track is-active" type="button" role="listitem" data-track data-src="/audio/pozyvnoy-nadezhda-live.mp3" data-title="Позывной Надежда (акустика)" data-artist="Русский Маяк" data-duration="3:12">
                  <span class="player__track-index">●</span>
                  <span class="player__track-name"><strong>Позывной Надежда (акустика)</strong><span>Live в госпитале Ростова</span></span>
                  <span class="player__track-duration">3:12</span>
                </button>
              </div>
            </div>

            <h2 id="chto-dalshe">Что дальше</h2>
            <p>
              Следующая поездка запланирована на конец августа — на этот раз в госпиталь другого региона. Если вы
              хотите поддержать закупку оборудования для будущих поездок, вы можете присоединиться к
              <a href="/#fundraising">действующему благотворительному сбору</a> уже сегодня.
            </p>

            <div class="article__tags">
              <div class="tag-list">
                <a class="tag" href="{{ route('news.index') }}">Поездки</a>
                <a class="tag" href="{{ route('news.index') }}">Госпитали</a>
                <a class="tag" href="{{ route('news.index') }}">Благотворительность</a>
              </div>
            </div>
          </article>

          <aside class="toc" data-toc aria-label="Содержание статьи">
            <span class="toc__heading">Содержание</span>
            <nav>
              <ul class="toc__list">
                <li><a class="toc__link" href="#nachalo" data-toc-link>Как всё начиналось</a></li>
                <li><a class="toc__link" href="#chto-privezli" data-toc-link>Что мы привезли</a></li>
                <li><a class="toc__link" href="#koncert" data-toc-link>Запись концерта</a></li>
                <li><a class="toc__link" href="#chto-dalshe" data-toc-link>Что дальше</a></li>
              </ul>
            </nav>
          </aside>
        </div>

        <div class="article__related">
          <div class="section-head">
            <p class="eyebrow">Новости</p>
            <h2>Похожие новости</h2>
          </div>
          <div class="grid grid--3">
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta"><time datetime="2026-06-05">5 июня 2026</time> · Благотворительность</span>
                <h3 class="card__title">Собрали 2 млн ₽ на реабилитацию бойцов</h3>
                <a class="card__link" href="{{ route('news.show', 'gospital-rostov') }}">Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta"><time datetime="2026-04-02">2 апреля 2026</time> · Поездки</span>
                <h3 class="card__title">Отчёт о поездке в Краснодар</h3>
                <a class="card__link" href="{{ route('news.show', 'gospital-rostov') }}">Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
            <article class="card">
              <div class="card__media card__media--placeholder"><svg aria-hidden="true"><use href="#icon-camera" /></svg></div>
              <div class="card__body">
                <span class="card__meta"><time datetime="2026-05-03">3 мая 2026</time> · Благотворительность</span>
                <h3 class="card__title">Открыт сбор на реабилитационное оборудование</h3>
                <a class="card__link" href="{{ route('news.show', 'gospital-rostov') }}">Читать <svg aria-hidden="true"><use href="#icon-arrow-right" /></svg></a>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
@endsection
