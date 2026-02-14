<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaItem extends Model
{
    public const string TYPE_VIDEO_URL = 'video_url';

    public const string TYPE_VIDEO_FILE = 'video_file';

    public const string TYPE_IMAGE = 'image';

    protected $fillable = [
        'media_playlist_id',
        'type',
        'title',
        'video_url',
        'video_file',
        'image',
        'sort_order',
    ];

    public function playlist(): BelongsTo
    {
        return $this->belongsTo(MediaPlaylist::class, 'media_playlist_id');
    }
}
