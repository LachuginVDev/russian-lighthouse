<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('vk_url')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('hero_eyebrow')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('about_eyebrow')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_lead')->nullable();
            $table->text('about_body')->nullable();
            $table->unsignedInteger('stat_years')->default(0);
            $table->unsignedInteger('stat_concerts')->default(0);
            $table->unsignedInteger('stat_trips')->default(0);
            $table->string('default_og_image')->nullable();
            $table->string('card_number')->nullable();
            $table->string('recipient')->nullable();
            $table->string('inn')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bik')->nullable();
            $table->string('qr_image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->unsignedSmallInteger('year')->nullable();
            $table->string('type')->default('album');
            $table->string('status')->default('published');
            $table->string('cover_path')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('genre')->nullable();
            $table->string('duration_label')->nullable();
            $table->string('vk_url')->nullable();
            $table->string('youtube_music_url')->nullable();
            $table->string('badge_label')->nullable();
            $table->boolean('is_featured_home')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('artist')->default('Русский Маяк');
            $table->string('duration')->nullable();
            $table->string('audio_path')->nullable();
            $table->string('cover_path')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_featured_home')->default(false);
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->string('title');
            $table->string('category')->default('concerts');
            $table->string('type_label')->nullable();
            $table->string('duration_label')->nullable();
            $table->string('embed_url');
            $table->string('thumbnail_path')->nullable();
            $table->boolean('is_featured_home')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('photo_reports', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->text('lead')->nullable();
            $table->string('category')->default('trips');
            $table->string('cover_path')->nullable();
            $table->date('report_date')->nullable();
            $table->boolean('is_featured_home')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_report_id')->constrained()->cascadeOnDelete();
            $table->string('image_path')->nullable();
            $table->string('alt')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_featured_home')->default(false);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->string('category')->default('trips');
            $table->longText('body')->nullable();
            $table->string('cover_path')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->string('author_initials')->nullable();
            $table->string('reading_time')->nullable();
            $table->foreignId('embedded_track_id')->nullable()->constrained('tracks')->nullOnDelete();
            $table->boolean('is_featured_home')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('news_tag', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['news_id', 'tag_id']);
        });

        Schema::create('fundraisings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('lead')->nullable();
            $table->string('status')->default('open');
            $table->unsignedBigInteger('goal_amount')->default(0);
            $table->unsignedBigInteger('current_amount')->default(0);
            $table->boolean('is_featured_home')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('concerts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('badge_type')->default('other');
            $table->string('status')->default('upcoming');
            $table->string('ticket_status_label')->nullable();
            $table->string('ticket_url')->nullable();
            $table->string('cover_path')->nullable();
            $table->longText('body')->nullable();
            $table->text('excerpt')->nullable();
            $table->foreignId('embedded_track_id')->nullable()->constrained('tracks')->nullOnDelete();
            $table->foreignId('fundraising_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_featured_home')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('fundraising_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->boolean('consent')->default(false);
            $table->string('ip')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('concerts');
        Schema::dropIfExists('fundraisings');
        Schema::dropIfExists('news_tag');
        Schema::dropIfExists('news');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('photos');
        Schema::dropIfExists('photo_reports');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('tracks');
        Schema::dropIfExists('albums');
        Schema::dropIfExists('site_settings');
    }
};
