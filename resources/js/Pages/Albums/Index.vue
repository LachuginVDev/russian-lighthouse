<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';
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

const props = defineProps<{
    albums: Album[];
    canLogin?: boolean;
    canRegister?: boolean;
}>();

const openedAlbum = ref<Album | null>(null);
const currentIndex = ref(0);

const currentPhoto = computed(() => {
    const album = openedAlbum.value;
    if (!album || !album.photos.length) return null;
    const i = Math.max(0, Math.min(currentIndex.value, album.photos.length - 1));
    return album.photos[i];
});

function openAlbum(album: Album) {
    if (!album.photos.length) return;
    openedAlbum.value = album;
    currentIndex.value = 0;
}

function closeGallery() {
    openedAlbum.value = null;
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
    <PublicLayout title="Фотоальбомы" :can-login="canLogin" :can-register="canRegister">
        <Head title="Фотоальбомы" />
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Фотоальбомы</h1>
            <div v-if="albums?.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <button
                    v-for="album in albums"
                    :key="album.id"
                    type="button"
                    class="group block text-left"
                    :disabled="!album.photos?.length"
                    @click="openAlbum(album)"
                >
                    <div
                        class="aspect-[4/3] overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700"
                    >
                        <img
                            v-if="album.cover"
                            :src="album.cover"
                            :alt="album.title"
                            class="h-full w-full object-cover transition group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center text-gray-400 dark:text-gray-500"
                        >
                            Нет фото
                        </div>
                    </div>
                    <p class="mt-2 font-medium text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400">
                        {{ album.title }}
                    </p>
                    <p v-if="album.photos?.length" class="text-sm text-gray-500 dark:text-gray-400">
                        {{ album.photos.length }} {{ album.photos.length === 1 ? 'фото' : 'фото' }}
                    </p>
                </button>
            </div>
            <p
                v-else
                class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-12 text-center text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400"
            >
                Пока нет альбомов. Добавьте в админке: Контент → Фотоальбомы.
            </p>
        </div>

        <!-- Галерея (лайтбокс с листанием) -->
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
                        class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/20 p-3 text-white hover:bg-white/30"
                        aria-label="Назад"
                        @click.stop="prev"
                    >
                        ‹
                    </button>
                    <div class="flex max-h-full max-w-full flex-col items-center">
                        <img
                            v-if="currentPhoto"
                            :src="currentPhoto.image"
                            :alt="currentPhoto.caption ?? openedAlbum.title"
                            class="max-h-[70vh] max-w-full object-contain"
                        />
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
                        class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/20 p-3 text-white hover:bg-white/30"
                        aria-label="Вперёд"
                        @click.stop="next"
                    >
                        ›
                    </button>
                </div>
            </div>
        </Teleport>
    </PublicLayout>
</template>
