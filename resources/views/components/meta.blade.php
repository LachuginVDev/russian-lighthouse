@props([
  'title' => 'Русский Маяк',
  'description' => '',
  'path' => '/',
  'ogType' => 'website',
])

@php
  $canonical = rtrim(config('app.url'), '/') . ($path === '/' ? '/' : $path);
@endphp

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}" />
<meta name="robots" content="index, follow" />
<meta name="theme-color" content="#0a0c10" />
<link rel="canonical" href="{{ $canonical }}" />
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />

<meta property="og:type" content="{{ $ogType }}" />
<meta property="og:locale" content="ru_RU" />
<meta property="og:site_name" content="Русский Маяк" />
<meta property="og:title" content="{{ $title }}" />
<meta property="og:description" content="{{ $description }}" />
<meta property="og:image" content="{{ asset('images/og-cover.jpg') }}" />
<meta property="og:url" content="{{ $canonical }}" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $title }}" />
<meta name="twitter:description" content="{{ $description }}" />
<meta name="twitter:image" content="{{ asset('images/og-cover.jpg') }}" />
