<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps<{
    id: number;
    post: {
        title: string;
        body?: string;
        date?: string;
        image?: string;
        images?: string[];
        video_url?: string;
        video_file?: string;
        meta_title?: string;
        meta_description?: string;
    } | null;
    canLogin?: boolean;
    canRegister?: boolean;
}>();

const embedUrl = (url: string): string => {
    if (!url) return '';
    try {
        const u = new URL(url);
        if (u.hostname.includes('youtube.com') || u.hostname.includes('youtu.be')) {
            const id = u.hostname === 'youtu.be' ? u.pathname.slice(1) : u.searchParams.get('v');
            return id ? `https://www.youtube.com/embed/${id}` : url;
        }
        if (u.hostname.includes('vk.com') && u.pathname.includes('video')) {
            const m = url.match(/video(-?\d+)_(\d+)/);
            if (m) return `https://vk.com/video_ext.php?oid=${m[1]}&id=${m[2]}&hd=2`;
            return url;
        }
        return url;
    } catch {
        return url;
    }
};

const lightboxImage = ref<string | null>(null);
</script>

<template>
    <PublicLayout title="Новость" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            <Head :title="post?.meta_title ?? post?.title ?? 'Новость'">
                <meta v-if="post?.meta_description" name="description" :content="post.meta_description" />
            </Head>
            <Link :href="route('news.index')" class="text-sm text-amber-600 hover:text-amber-500 dark:text-amber-400">
                ← К списку новостей
            </Link>
            <template v-if="post">
                <time class="mt-4 block text-sm text-gray-500 dark:text-gray-400">{{ post.date }}</time>
                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ post.title }}</h1>
                <img
                    v-if="post.image"
                    :src="post.image"
                    :alt="post.title"
                    class="mt-4 w-full rounded-lg object-cover"
                />
                <div
                    class="mt-6 prose prose-lg prose-gray dark:prose-invert dark:prose-headings:text-white prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-a:text-amber-600 dark:prose-a:text-amber-400 prose-img:rounded-lg max-w-none"
                    v-html="post.body ?? ''"
                />

                <!-- Галерея -->
                <section v-if="post.images?.length" class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Фото</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <button
                            v-for="(img, i) in post.images"
                            :key="i"
                            type="button"
                            class="aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-500"
                            @click="lightboxImage = img"
                        >
                            <img :src="img" :alt="`${post.title} — фото ${i + 1}`" class="h-full w-full object-cover" />
                        </button>
                    </div>
                </section>

                <!-- Видео: ссылка (YouTube/VK) -->
                <section v-if="post.video_url" class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Видео</h2>
                    <div class="aspect-video w-full overflow-hidden rounded-lg bg-black">
                        <iframe
                            v-if="embedUrl(post.video_url)"
                            :src="embedUrl(post.video_url)"
                            title="Видео"
                            class="h-full w-full"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        />
                    </div>
                </section>
                <!-- Видео: локальный файл -->
                <section v-else-if="post.video_file" class="mt-10">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Видео</h2>
                    <div class="overflow-hidden rounded-lg bg-black">
                        <video controls class="w-full" :src="post.video_file">
                            Ваш браузер не поддерживает воспроизведение видео.
                        </video>
                    </div>
                </section>

                <!-- Лайтбокс галереи -->
                <Teleport to="body">
                    <div
                        v-if="lightboxImage"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
                        @click.self="lightboxImage = null"
                    >
                        <button
                            type="button"
                            class="absolute right-4 top-4 text-white hover:text-gray-300"
                            aria-label="Закрыть"
                            @click="lightboxImage = null"
                        >
                            ✕
                        </button>
                        <img :src="lightboxImage" alt="Фото" class="max-h-full max-w-full object-contain" />
                    </div>
                </Teleport>
            </template>
            <p v-else class="mt-8 text-gray-500 dark:text-gray-400">Публикация не найдена или ещё не загружена.</p>
        </div>
    </PublicLayout>
</template>
