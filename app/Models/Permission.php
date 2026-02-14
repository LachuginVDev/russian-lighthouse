<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    /** Гость: просмотр страниц */
    public const string VIEW_PAGES = 'view_pages';

    /** Гость: чтение новостей */
    public const string READ_NEWS = 'read_news';

    /** Гость: просмотр сборов */
    public const string VIEW_FUNDRAISERS = 'view_fundraisers';

    /** Гость: совершение пожертвований */
    public const string MAKE_DONATIONS = 'make_donations';

    /** Гость: прослушивание медиа */
    public const string LISTEN_MEDIA = 'listen_media';

    /** Админ: управление контентом */
    public const string MANAGE_CONTENT = 'manage_content';

    /** Админ: управление сборами */
    public const string MANAGE_FUNDRAISERS = 'manage_fundraisers';

    /** Админ: управление SEO */
    public const string MANAGE_SEO = 'manage_seo';

    /** Админ: управление медиа */
    public const string MANAGE_MEDIA = 'manage_media';

    /** Админ: просмотр статистики пожертвований */
    public const string VIEW_DONATION_STATS = 'view_donation_stats';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
