import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { dirname, join } from 'node:path';

const root = process.cwd();
const ref = join(root, 'docs/html-reference');

const pages = [
  { html: 'index.html', view: 'pages/home.blade.php', vite: 'resources/js/main.js', canonical: '/' },
  { html: 'albums.html', view: 'pages/albums/index.blade.php', vite: 'resources/js/pages/albums.js', canonical: '/albums' },
  { html: 'album.html', view: 'pages/albums/show.blade.php', vite: 'resources/js/pages/album.js', canonical: '/albums/svet-s-peredovoy' },
  { html: 'video.html', view: 'pages/videos/index.blade.php', vite: 'resources/js/pages/video.js', canonical: '/video' },
  { html: 'photos.html', view: 'pages/photos/index.blade.php', vite: 'resources/js/pages/photos.js', canonical: '/photos' },
  { html: 'photo-report.html', view: 'pages/photos/show.blade.php', vite: 'resources/js/pages/photo-report.js', canonical: '/photos/gumanitarnyy-konvoy' },
  { html: 'news.html', view: 'pages/news/index.blade.php', vite: 'resources/js/pages/news.js', canonical: '/news' },
  { html: 'news-single.html', view: 'pages/news/show.blade.php', vite: 'resources/js/pages/news-single.js', canonical: '/news/gospital-rostov' },
  { html: 'concerts.html', view: 'pages/concerts/index.blade.php', vite: 'resources/js/pages/concerts.js', canonical: '/concerts' },
  { html: 'concert-single.html', view: 'pages/concerts/show.blade.php', vite: 'resources/js/pages/concert-single.js', canonical: '/concerts/svet-dlya-geroev' },
];

const urlMap = [
  [/\/index\.html#/g, '/#'],
  [/href="\/index\.html"/g, 'href="{{ route(\'home\') }}"'],
  [/href="\/albums\.html"/g, 'href="{{ route(\'albums.index\') }}"'],
  [/href="\/album\.html"/g, 'href="{{ route(\'albums.show\', \'svet-s-peredovoy\') }}"'],
  [/href="\/video\.html"/g, 'href="{{ route(\'videos.index\') }}"'],
  [/href="\/photos\.html"/g, 'href="{{ route(\'photos.index\') }}"'],
  [/href="\/photo-report\.html"/g, 'href="{{ route(\'photos.show\', \'gumanitarnyy-konvoy\') }}"'],
  [/href="\/news\.html"/g, 'href="{{ route(\'news.index\') }}"'],
  [/href="\/news-single\.html"/g, 'href="{{ route(\'news.show\', \'gospital-rostov\') }}"'],
  [/href="\/concerts\.html"/g, 'href="{{ route(\'concerts.index\') }}"'],
  [/href="\/concert-single\.html"/g, 'href="{{ route(\'concerts.show\', \'svet-dlya-geroev\') }}"'],
  [/href="\/privacy\.html"/g, 'href="{{ route(\'pages.privacy\') }}"'],
  [/href="\/reports\.html"/g, 'href="{{ route(\'pages.reports\') }}"'],
  [/href="\/albums\/[^"]+\.html"/g, 'href="{{ route(\'albums.show\', \'svet-s-peredovoy\') }}"'],
  [/href="\/news\/[^"]+\.html"/g, 'href="{{ route(\'news.show\', \'gospital-rostov\') }}"'],
  [/href="\/concerts\/[^"]+\.html"/g, 'href="{{ route(\'concerts.show\', \'svet-dlya-geroev\') }}"'],
];

function extractAttr(tag, name) {
  return tag.match(new RegExp(`${name}="([^"]*)"`))?.[1] ?? '';
}

function rewriteUrls(html) {
  return urlMap.reduce((out, [re, to]) => out.replace(re, to), html);
}

function convertPage(page) {
  const raw = readFileSync(join(ref, page.html), 'utf8').replace(/\r\n/g, '\n');
  const metaLoad = raw.match(/<load[\s\S]*?src="src\/partials\/meta\.html"[\s\S]*?\/>/);
  const title = metaLoad ? extractAttr(metaLoad[0], 'title') : 'Русский Маяк';
  const description = metaLoad ? extractAttr(metaLoad[0], 'description') : '';
  const ogtype = metaLoad ? extractAttr(metaLoad[0], 'ogtype') : 'website';

  let content = raw;
  const pageHeader = content.match(/<load[\s\S]*?src="src\/partials\/page-header-2\.html"[\s\S]*?\/>/);
  if (pageHeader) {
    const ph = pageHeader[0];
    content = content.replace(
      ph,
      `<x-page-header eyebrow="${extractAttr(ph, 'eyebrow')}" title="${extractAttr(ph, 'title')}" subtitle="${extractAttr(ph, 'subtitle')}" current="${extractAttr(ph, 'current')}" />`
    );
  }

  const mainMatch = content.match(/<main[^>]*>([\s\S]*?)<\/main>/);
  let mainInner = rewriteUrls((mainMatch?.[1] ?? '').trim());

  // Keep detail-page JSON-LD from <head> (MusicGroup — отдельный компонент)
  const head = raw.match(/<head[\s\S]*?<\/head>/)?.[0] ?? raw;
  const schemas = [...head.matchAll(/<script type="application\/ld\+json">[\s\S]*?<\/script>/g)]
    .map((m) => m[0]
      .replaceAll('https://russkiy-mayak.ru/albums.html', 'https://russkiy-mayak.ru/albums')
      .replaceAll('https://russkiy-mayak.ru/news.html', 'https://russkiy-mayak.ru/news')
      .replaceAll('https://russkiy-mayak.ru/concerts.html', 'https://russkiy-mayak.ru/concerts')
      .replaceAll('https://russkiy-mayak.ru/photos.html', 'https://russkiy-mayak.ru/photos')
      // Blade интерпретирует @type/@context как директивы — экранируем
      .replaceAll('"@context"', '"@@context"')
      .replaceAll('"@type"', '"@@type"')
      .replaceAll('"@id"', '"@@id"'))
    .filter((s) => !s.includes('"MusicGroup"') || s.includes('"Event"') || s.includes('"MusicAlbum"') || s.includes('"NewsArticle"'))
    .filter((s) => !(pageHeader && s.includes('BreadcrumbList')));

  // Для Event performer содержит MusicGroup — не отфильтровывать Event
  const schemaBlock = schemas.length
    ? schemas.map((s) => s.trim()).join('\n\n') + '\n\n'
    : '';

  const blade = `@extends('layouts.app')

@section('title', ${JSON.stringify(title)})
@section('description', ${JSON.stringify(description)})
@section('canonical_path', ${JSON.stringify(page.canonical)})
@section('og_type', ${JSON.stringify(ogtype)})

@section('vite')
  @vite(['resources/scss/main.scss', '${page.vite}'])
@endsection

@section('content')
${schemaBlock}${page.html === 'index.html' ? '  <x-schema.music-group />\n\n' : ''}${mainInner}
@endsection
`;

  const outPath = join(root, 'resources/views', page.view);
  mkdirSync(dirname(outPath), { recursive: true });
  writeFileSync(outPath, blade, 'utf8');
  console.log('OK', page.view);
}

for (const page of pages) convertPage(page);
console.log('Done');
