<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image'); // массив путей к изображениям
            $table->string('video_url', 500)->nullable()->after('body'); // YouTube, VK и т.д.
            $table->string('video_file')->nullable()->after('video_url'); // локальный файл
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');       // текст/название
            $table->string('url', 500);   // ссылка
            $table->string('image')->nullable(); // картинка или заглушка
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['images', 'video_url', 'video_file']);
        });
        Schema::dropIfExists('social_links');
    }
};
