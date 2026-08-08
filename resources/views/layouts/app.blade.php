@php
  $metaTitle = trim($__env->yieldContent('title', 'Русский Маяк'));
  $metaDescription = trim($__env->yieldContent('description', ''));
  $metaPath = trim($__env->yieldContent('canonical_path', '/'));
  $metaOgType = trim($__env->yieldContent('og_type', 'website'));
@endphp
<!doctype html>
<html lang="ru">
<head>
  <x-meta
    :title="$metaTitle"
    :description="$metaDescription"
    :path="$metaPath"
    :og-type="$metaOgType"
  />
  @stack('head')
  @hasSection('vite')
    @yield('vite')
  @else
    @vite(['resources/scss/main.scss', 'resources/js/pages/static.js'])
  @endif
</head>
<body>
  <a class="skip-link" href="#main">Перейти к содержимому</a>

  <x-icons />
  <x-site-header />

  <main id="main">
    @yield('content')
  </main>

  <x-site-footer />
</body>
</html>
