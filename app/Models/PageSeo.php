<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageSeo extends Model
{
    protected $table = 'page_seo';

    protected $fillable = [
        'page_slug',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    public const string SLUG_HOME = 'home';

    public const string SLUG_ABOUT = 'about';

    public const string SLUG_FUNDRAISERS = 'fundraisers';

    public const string SLUG_MEDIA = 'media';

    public const string SLUG_CONTACTS = 'contacts';

    public static function getForPage(string $slug): ?self
    {
        return Cache::remember(
            'page_seo:' . $slug,
            now()->addHour(),
            fn () => self::query()->where('page_slug', $slug)->first()
        );
    }
}
