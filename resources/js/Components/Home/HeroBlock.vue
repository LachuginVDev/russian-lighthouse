<script setup lang="ts">
/**
 * Hero-блок (первый экран): слайды с плавной сменой, заголовок/подзаголовок, блок фотоальбомов.
 */
import type { HomeSettings, SlideItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

interface AlbumPhoto {
    id: number;
    image: string;
    caption?: string | null;
}

interface Album {
    id: number;
    title: string;
    cover: string | null;
    photos: AlbumPhoto[];
}

const props = withDefaults(
    defineProps<{
        title?: string;
        subtitle?: string;
        description?: string;
        ctaText?: string;
        ctaHref?: string;
        albums?: Album[];
        slides?: SlideItem[];
        slideIntervalMs?: number;
    }>(),
    { albums: () => [] }
);

const page = usePage();
const slidesFromShared = computed(
    () => (page.props.slides as SlideItem[] | undefined) ?? [],
);
const home = computed(
    () =>
        (page.props.home as HomeSettings | undefined) ?? {
            hero_text_color: 'white',
        },
);
const slideList = computed(() =>
    props.slides?.length ? props.slides : slidesFromShared.value,
);
const currentSlide = ref(0);
let slideTimer: ReturnType<typeof setInterval> | null = null;
const textColorClass = computed(() =>
    home.value.hero_text_color === 'black'
        ? 'text-gray-900'
        : 'text-white',
);

onMounted(() => {
    if (slideList.value.length > 1) {
        slideTimer = setInterval(() => {
            currentSlide.value =
                (currentSlide.value + 1) % slideList.value.length;
        }, props.slideIntervalMs ?? 6000);
    }
});
onUnmounted(() => {
    if (slideTimer) clearInterval(slideTimer);
});

const displayedAlbums = computed(() => (props.albums ?? []).slice(0, 6));

/** Текущий индекс фото в превью для каждого альбома (для автопереключения в сетке). */
const albumPreviewIndex = ref<Record<number, number>>({});

function getAlbumPreviewImage(album: Album): string | null {
    const photos = album.photos ?? [];
    if (!photos.length) return album.cover;
    const i = albumPreviewIndex.value[album.id] ?? 0;
    return photos[Math.min(i, photos.length - 1)]?.image ?? album.cover;
}

const PREVIEW_MIN_DELAY_MS = 7000;
const PREVIEW_MAX_DELAY_MS = 15000;

function pickNextRandomPreview(album: Album): void {
    const photos = album.photos ?? [];
    if (photos.length <= 1) return;
    const current = albumPreviewIndex.value[album.id] ?? 0;
    const otherIndices = photos
        .map((_, idx) => idx)
        .filter((idx) => idx !== current);
    const next =
        otherIndices.length > 0
            ? otherIndices[Math.floor(Math.random() * otherIndices.length)]
            : 0;
    albumPreviewIndex.value = {
        ...albumPreviewIndex.value,
        [album.id]: next,
    };
}

function scheduleNextPreview(album: Album): void {
    const photos = album.photos ?? [];
    if (photos.length <= 1) return;
    const delay =
        PREVIEW_MIN_DELAY_MS +
        Math.random() * (PREVIEW_MAX_DELAY_MS - PREVIEW_MIN_DELAY_MS);
    const id = window.setTimeout(() => {
        albumPreviewTimeouts.current.delete(album.id);
        pickNextRandomPreview(album);
        scheduleNextPreview(album);
    }, delay);
    albumPreviewTimeouts.current.set(album.id, id);
}

const albumPreviewTimeouts = { current: new Map<number, number>() };

onMounted(() => {
    displayedAlbums.value.forEach((album) => {
        albumPreviewIndex.value = {
            ...albumPreviewIndex.value,
            [album.id]: 0,
        };
        scheduleNextPreview(album);
    });
});
onUnmounted(() => {
    albumPreviewTimeouts.current.forEach((id) => clearTimeout(id));
    albumPreviewTimeouts.current.clear();
});

const openedAlbum = ref<Album | null>(null);
const currentIndex = ref(0);

const currentPhoto = computed(() => {
    const album = openedAlbum.value;
    if (!album || !album.photos.length) return null;
    const i = Math.max(0, Math.min(currentIndex.value, album.photos.length - 1));
    return album.photos[i];
});

function openAlbum(album: Album) {
    if (!album.photos?.length) return;
    openedAlbum.value = album;
    currentIndex.value = 0;
    document.body.style.overflow = 'hidden';
}

function closeGallery() {
    openedAlbum.value = null;
    document.body.style.overflow = '';
}

function prev() {
    const album = openedAlbum.value;
    if (!album) return;
    currentIndex.value = currentIndex.value > 0 ? currentIndex.value - 1 : album.photos.length - 1;
}

function next() {
    const album = openedAlbum.value;
    if (!album) return;
    currentIndex.value = currentIndex.value < album.photos.length - 1 ? currentIndex.value + 1 : 0;
}

function onKeydown(e: KeyboardEvent) {
    if (!openedAlbum.value) return;
    if (e.key === 'Escape') closeGallery();
    if (e.key === 'ArrowLeft') prev();
    if (e.key === 'ArrowRight') next();
}

onMounted(() => window.addEventListener('keydown', onKeydown));
onUnmounted(() => window.removeEventListener('keydown', onKeydown));
</script>

<template>
    <section class="bg-white dark:bg-gray-900">
        <!-- Первый экран: слайды с плавной сменой -->
        <div
            v-if="slideList.length"
            class="relative h-[70vh] min-h-[400px] w-full overflow-hidden bg-gray-900"
        >
            <div
                class="absolute inset-0 flex"
                :class="{ 'animate-pulse': !slideList.length }"
            >
                <div
                    v-for="(slide, index) in slideList"
                    :key="slide.id"
                    class="absolute inset-0 flex-shrink-0 transition-opacity duration-1000 ease-in-out"
                    :class="index === currentSlide ? 'opacity-100' : 'opacity-0'"
                >
                    <a
                        v-if="slide.link"
                        :href="slide.link"
                        :target="slide.link.startsWith('http') ? '_blank' : undefined"
                        :rel="slide.link.startsWith('http') ? 'noopener' : undefined"
                        class="block h-full w-full"
                    >
                        <img
                            v-if="slide.imageUrl"
                            :src="slide.imageUrl"
                            :alt="slide.alt ?? ''"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                        <div
                            v-else
                            class="h-full w-full bg-gradient-to-br from-amber-900/80 to-gray-900"
                        />
                    </a>
                    <div v-else class="block h-full w-full">
                        <img
                            v-if="slide.imageUrl"
                            :src="slide.imageUrl"
                            :alt="slide.alt ?? ''"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        />
                        <div
                            v-else
                            class="h-full w-full bg-gradient-to-br from-amber-900/80 to-gray-900"
                        />
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 bg-black/30" />
            <div
                v-if="home.hero_title || home.hero_subtitle"
                class="absolute inset-y-0 left-0 flex max-w-2xl flex-col justify-center px-8 md:px-12 lg:px-16"
            >
                <h1
                    v-if="home.hero_title"
                    class="text-3xl font-bold tracking-tight drop-shadow-md md:text-4xl lg:text-5xl"
                    :class="textColorClass"
                >
                    {{ home.hero_title }}
                </h1>
                <p
                    v-if="home.hero_subtitle"
                    class="mt-3 text-lg drop-shadow-md md:text-xl"
                    :class="textColorClass"
                >
                    {{ home.hero_subtitle }}
                </p>
            </div>
        </div>

        <!-- Фотоальбомы: во всю ширину, без отступов и скруглений, блоки вплотную -->
        <div v-if="displayedAlbums.length" class="w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                <button
                    v-for="album in displayedAlbums"
                    :key="album.id"
                    type="button"
                    class="group relative aspect-[4/3] w-full overflow-hidden bg-gray-200 dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-inset disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="!album.photos?.length"
                    :aria-label="album.photos?.length ? `Открыть альбом: ${album.title}` : 'В альбоме нет фото'"
                    @click="openAlbum(album)"
                >
                    <Transition name="album-preview-fade">
                        <img
                            v-if="album.photos?.length"
                            :key="(albumPreviewIndex[album.id] ?? 0)"
                            :src="getAlbumPreviewImage(album) ?? ''"
                            :alt="album.title"
                            class="h-full w-full object-cover transition duration-300 ease-out group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            v-else
                            key="no-photo"
                            class="flex h-full w-full items-center justify-center text-gray-400 dark:text-gray-500"
                        >
                            Нет фото
                        </div>
                    </Transition>
                    <!-- Подпись внутри картинки внизу, плавно при наведении -->
                    <div
                        class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent px-4 py-3 opacity-0 transition-opacity duration-300 ease-out group-hover:opacity-100"
                    >
                        <p class="text-sm font-medium text-white">
                            {{ album.title }}
                        </p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Галерея: плавная смена фото -->
        <Teleport to="body">
            <div
                v-if="openedAlbum"
                class="fixed inset-0 z-50 flex flex-col bg-black/95"
                role="dialog"
                aria-modal="true"
                aria-label="Просмотр альбома"
            >
                <header class="flex shrink-0 items-center justify-between p-4 text-white">
                    <h2 class="text-lg font-semibold">{{ openedAlbum.title }}</h2>
                    <button
                        type="button"
                        class="rounded p-2 hover:bg-white/10"
                        aria-label="Закрыть"
                        @click="closeGallery"
                    >
                        ✕
                    </button>
                </header>
                <div class="relative flex flex-1 items-center justify-center p-4" @click.self="closeGallery">
                    <button
                        v-if="openedAlbum.photos.length > 1"
                        type="button"
                        class="absolute left-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/20 p-3 text-2xl text-white hover:bg-white/30 sm:left-4"
                        aria-label="Предыдущее фото"
                        @click.stop="prev"
                    >
                        ‹
                    </button>
                    <div
                        class="relative flex max-h-full max-w-full flex-col items-center"
                        :class="openedAlbum.photos.length > 1 ? 'cursor-pointer' : 'cursor-default'"
                        @click.stop="openedAlbum.photos.length > 1 && next()"
                    >
                        <Transition name="album-fade" mode="out-in">
                            <img
                                v-if="currentPhoto"
                                :key="currentIndex"
                                :src="currentPhoto.image"
                                :alt="currentPhoto.caption ?? openedAlbum.title"
                                class="max-h-[70vh] max-w-full select-none object-contain"
                                draggable="false"
                            />
                        </Transition>
                        <p
                            v-if="currentPhoto?.caption"
                            class="mt-3 max-w-2xl text-center text-sm text-gray-300"
                        >
                            {{ currentPhoto.caption }}
                        </p>
                        <p
                            v-if="openedAlbum.photos.length > 1"
                            class="mt-1 text-xs text-gray-500"
                        >
                            {{ currentIndex + 1 }} / {{ openedAlbum.photos.length }}
                        </p>
                    </div>
                    <button
                        v-if="openedAlbum.photos.length > 1"
                        type="button"
                        class="absolute right-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/20 p-3 text-2xl text-white hover:bg-white/30 sm:right-4"
                        aria-label="Следующее фото"
                        @click.stop="next"
                    >
                        ›
                    </button>
                </div>
            </div>
        </Teleport>
    </section>
</template>

<style scoped>
.album-fade-enter-active,
.album-fade-leave-active {
    transition: opacity 0.15s ease;
}
.album-fade-enter-from,
.album-fade-leave-to {
    opacity: 0;
}

.album-preview-fade-enter-active,
.album-preview-fade-leave-active {
    transition: opacity 0.35s ease-in-out;
    position: absolute;
    inset: 0;
}
.album-preview-fade-enter-from,
.album-preview-fade-leave-to {
    opacity: 0;
}
.album-preview-fade-enter-to,
.album-preview-fade-leave-from {
    opacity: 1;
}
</style>
