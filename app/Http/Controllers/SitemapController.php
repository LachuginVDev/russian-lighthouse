<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $base = rtrim(config('app.url'), '/');

        $urls = [
            ['loc' => $base . '/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $base . route('about', [], false), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => $base . route('news.index', [], false), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => $base . route('fundraisers.index', [], false), 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['loc' => $base . route('media.index', [], false), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => $base . route('albums.index', [], false), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => $base . route('contacts', [], false), 'changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        foreach (Post::query()->published()->get() as $post) {
            $urls[] = [
                'loc' => $base . route('news.show', $post->slug, false),
                'lastmod' => $post->updated_at?->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        foreach (Fundraiser::query()->where('is_active', true)->get() as $f) {
            $urls[] = [
                'loc' => $base . route('fundraisers.show', $f->id, false),
                'lastmod' => $f->updated_at?->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= '  <url><loc>' . htmlspecialchars($u['loc']) . '</loc>';
            if (! empty($u['lastmod'])) {
                $xml .= '<lastmod>' . htmlspecialchars($u['lastmod']) . '</lastmod>';
            }
            $xml .= '<changefreq>' . ($u['changefreq'] ?? 'weekly') . '</changefreq>';
            $xml .= '<priority>' . ($u['priority'] ?? '0.5') . '</priority>';
            $xml .= '</url>' . "\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Charset' => 'UTF-8',
        ]);
    }
}
