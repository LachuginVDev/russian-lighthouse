<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Concert;
use App\Models\News;
use App\Models\PhotoReport;
use App\Models\SiteSetting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    public function robots(): Response
    {
        $settings = SiteSetting::current();
        $sitemap = rtrim(config('app.url'), '/').'/sitemap.xml';

        if ($settings->is_development_mode) {
            $body = implode("\n", [
                'User-agent: *',
                'Disallow: /',
                '',
                '# Режим разработки включён в настройках сайта — индексация отключена.',
            ]);
        } else {
            $body = implode("\n", [
                'User-agent: *',
                'Allow: /',
                'Disallow: /admin',
                'Disallow: /api',
                '',
                'Sitemap: '.$sitemap,
            ]);
        }

        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    public function sitemap(): Response
    {
        $xml = Cache::remember('seo.sitemap.xml', now()->addHour(), function () {
            if (SiteSetting::current()->is_development_mode) {
                return $this->emptyUrlset();
            }

            $urls = [
                ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
                ['loc' => route('albums.index'), 'changefreq' => 'weekly', 'priority' => '0.8'],
                ['loc' => route('videos.index'), 'changefreq' => 'weekly', 'priority' => '0.7'],
                ['loc' => route('photos.index'), 'changefreq' => 'weekly', 'priority' => '0.7'],
                ['loc' => route('news.index'), 'changefreq' => 'daily', 'priority' => '0.8'],
                ['loc' => route('concerts.index'), 'changefreq' => 'weekly', 'priority' => '0.8'],
                ['loc' => route('pages.privacy'), 'changefreq' => 'yearly', 'priority' => '0.3'],
                ['loc' => route('pages.reports'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ];

            foreach (Album::query()->published()->orderBy('sort_order')->get(['slug', 'updated_at']) as $album) {
                $urls[] = [
                    'loc' => route('albums.show', $album->slug),
                    'lastmod' => $album->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            foreach (PhotoReport::query()->published()->orderByDesc('published_at')->get(['slug', 'updated_at']) as $report) {
                $urls[] = [
                    'loc' => route('photos.show', $report->slug),
                    'lastmod' => $report->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ];
            }

            foreach (News::query()->published()->orderByDesc('published_at')->get(['slug', 'updated_at']) as $item) {
                $urls[] = [
                    'loc' => route('news.show', $item->slug),
                    'lastmod' => $item->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.7',
                ];
            }

            foreach (Concert::query()->published()->orderByDesc('starts_at')->get(['slug', 'updated_at']) as $concert) {
                $urls[] = [
                    'loc' => route('concerts.show', $concert->slug),
                    'lastmod' => $concert->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }

            return $this->buildUrlset($urls);
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    /**
     * @param  list<array{loc: string, lastmod?: string|null, changefreq?: string, priority?: string}>  $urls
     */
    private function buildUrlset(array $urls): string
    {
        $items = '';

        foreach ($urls as $url) {
            $items .= '<url>';
            $items .= '<loc>'.e($url['loc']).'</loc>';
            if (! empty($url['lastmod'])) {
                $items .= '<lastmod>'.e($url['lastmod']).'</lastmod>';
            }
            if (! empty($url['changefreq'])) {
                $items .= '<changefreq>'.e($url['changefreq']).'</changefreq>';
            }
            if (! empty($url['priority'])) {
                $items .= '<priority>'.e($url['priority']).'</priority>';
            }
            $items .= '</url>';
        }

        return '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            .$items
            .'</urlset>';
    }

    private function emptyUrlset(): string
    {
        return '<?xml version="1.0" encoding="UTF-8"?>'
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
    }
}
