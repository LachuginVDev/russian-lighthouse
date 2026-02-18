<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface MediaItemType {
    id: number;
    type: string;
    title?: string;
    video_url?: string;
    video_file?: string;
    image?: string;
}

const props = defineProps<{
    videoItems?: MediaItemType[];
    imageItems?: MediaItemType[];
    playlists?: { id: number; title: string; items: MediaItemType[] }[];
    canLogin?: boolean;
    canRegister?: boolean;
}>();

function embedUrl(url: string): string {
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
}

const videoList = computed(() => props.videoItems ?? []);
const currentIndex = ref(0);
const currentVideo = computed(() => videoList.value[currentIndex.value] ?? null);

const imageList = computed(() => props.imageItems ?? []);
const lightboxImage = ref<string | null>(null);

const page = usePage();
const seo = computed(() => page.props.page_seo?.media);
const canonicalUrl = `${page.props.app_url ?? ''}${route('media.index')}`;
</script>

<template>
    <PublicLayout :title="seo?.meta_title ?? 'Медиа'" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <Head :title="seo?.meta_title ?? 'Медиа'">
                <meta v-if="seo?.meta_description" name="description" :content="seo.meta_description" />
                <link rel="canonical" :href="canonicalUrl" />
                <meta v-if="seo?.meta_title" property="og:title" :content="seo.meta_title" />
                <meta v-if="seo?.meta_description" property="og:description" :content="seo.meta_description" />
                <meta v-if="seo?.og_image" property="og:image" :content="seo.og_image" />
                <meta property="og:url" :content="canonicalUrl" />
                <meta property="og:type" content="website" />
            </Head>
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Медиа</h1>

            <!-- Мини-плеер -->
            <section class="mb-12">
                <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Видео</h2>
                <div
                    v-if="currentVideo"
                    class="overflow-hidden rounded-lg bg-gray-900 shadow-lg"
                >
                    <div class="aspect-video w-full">
                        <iframe
                            v-if="currentVideo.video_url && embedUrl(currentVideo.video_url)"
                            :src="embedUrl(currentVideo.video_url)"
                            :title="currentVideo.title ?? 'Видео'"
                            class="h-full w-full"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        />
                        <video
                            v-else-if="currentVideo.video_file"
                            controls
                            class="h-full w-full"
                            :src="currentVideo.video_file"
                        >
                            Ваш браузер не поддерживает воспроизведение видео.
                        </video>
                    </div>
                    <p
                        v-if="currentVideo.title"
                        class="bg-gray-800 px-4 py-2 text-sm text-gray-200"
                    >
                        {{ currentVideo.title }}
                    </p>
                </div>
                <div
                    v-else
                    class="flex aspect-video items-center justify-center rounded-lg border border-dashed border-gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-800"
                >
                    <span class="text-gray-500 dark:text-gray-400">Добавьте видео в админке (Контент → Элементы медиа)</span>
                </div>
            </section>

            <!-- Плейлист -->
            <section v-if="videoList.length" class="mb-12">
                <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Плейлист</h2>
                <ul class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    <li
                        v-for="(item, index) in videoList"
                        :key="item.id"
                        class="rounded-lg border transition"
                        :class="index === currentIndex
                            ? 'border-amber-500 bg-amber-50 dark:border-amber-400 dark:bg-amber-900/20'
                            : 'border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-750'"
                    >
                        <button
                            type="button"
                            class="w-full px-4 py-3 text-left text-sm font-medium text-gray-900 dark:text-white"
                            @click="currentIndex = index"
                        >
                            {{ item.title ?? `Видео ${index + 1}` }}
                        </button>
                    </li>
                </ul>
            </section>

            <!-- Галерея изображений -->
            <section v-if="imageList.length">
                <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Галерея</h2>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                    <button
                        v-for="(item, i) in imageList"
                        :key="item.id"
                        type="button"
                        class="aspect-square overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-500"
                        @click="lightboxImage = item.image ?? null"
                    >
                        <img
                            v-if="item.image"
                            :src="item.image"
                            :alt="item.title ?? `Фото ${i + 1}`"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                    </button>
                </div>
            </section>
            <div
                v-else
                class="rounded-lg border border-dashed border-gray-300 bg-gray-100 py-12 text-center text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400"
            >
                Изображений пока нет. Добавьте в админке (Контент → Элементы медиа, тип «Изображение»).
            </div>

            <!-- Лайтбокс -->
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
                    <img
                        :src="lightboxImage"
                        alt="Фото"
                        class="max-h-full max-w-full object-contain"
                    >
                </div>
            </Teleport>
        </div>
    </PublicLayout>
</template>
