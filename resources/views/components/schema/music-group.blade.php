@php
  $settings = \App\Models\SiteSetting::current();
  $sameAs = array_values(array_filter([
    $settings->vk_url,
    $settings->telegram_url,
    $settings->youtube_url,
  ]));
@endphp
<script type="application/ld+json">
  {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'MusicGroup',
    'name' => 'Русский Маяк',
    'url' => rtrim(config('app.url'), '/').'/',
    'genre' => 'Патриотическая музыка',
    'description' => $settings->about_lead
      ?: 'Музыкальная группа, сочетающая творчество с волонтёрской деятельностью: концерты в госпиталях, поездки в зону СВО и благотворительные сборы для военнослужащих.',
    'sameAs' => $sameAs,
    'email' => $settings->email,
    'telephone' => $settings->phone,
  ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
</script>
