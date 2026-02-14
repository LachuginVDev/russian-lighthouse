<script setup lang="ts">
/**
 * Блок медиа: видео и/или музыка. Слоты или пропсы под будущий контент.
 */
interface MediaVideo {
    id: number;
    title?: string;
    url: string;
    thumbnail?: string;
}

interface MediaTrack {
    id: number;
    title: string;
    duration?: string;
    url?: string;
}

defineProps<{
    title?: string;
    videos?: MediaVideo[];
    tracks?: MediaTrack[];
}>();
</script>

<template>
    <section class="bg-gray-50 py-16 dark:bg-gray-800 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                {{ title ?? 'Медиа' }}
            </h2>
            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Видео -->
                <div>
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-white">
                        Видео
                    </h3>
                    <div
                        v-if="videos?.length"
                        class="space-y-4"
                    >
                        <div
                            v-for="v in videos"
                            :key="v.id"
                            class="aspect-video overflow-hidden rounded-lg bg-gray-200 dark:bg-gray-700"
                        >
                            <a
                                v-if="v.url"
                                :href="v.url"
                                target="_blank"
                                rel="noopener"
                                class="flex h-full items-center justify-center bg-gray-800 text-white hover:bg-gray-700"
                            >
                                <span class="text-sm">{{ v.title ?? 'Смотреть' }}</span>
                            </a>
                            <div
                                v-else
                                class="flex h-full items-center justify-center text-gray-500"
                            >
                                Плейсхолдер видео
                            </div>
                        </div>
                    </div>
                    <div
                        v-else
                        class="aspect-video rounded-lg border border-dashed border-gray-300 bg-gray-100 dark:border-gray-600 dark:bg-gray-700"
                    >
                        <div class="flex h-full items-center justify-center text-gray-500 dark:text-gray-400">
                            Видео скоро появится
                        </div>
                    </div>
                </div>
                <!-- Музыка -->
                <div>
                    <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-white">
                        Музыка
                    </h3>
                    <div
                        v-if="tracks?.length"
                        class="space-y-2 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-900"
                    >
                        <div
                            v-for="t in tracks"
                            :key="t.id"
                            class="flex items-center justify-between rounded py-2 px-3 hover:bg-gray-50 dark:hover:bg-gray-800"
                        >
                            <span class="font-medium text-gray-900 dark:text-white">{{ t.title }}</span>
                            <span v-if="t.duration" class="text-sm text-gray-500">{{ t.duration }}</span>
                        </div>
                    </div>
                    <div
                        v-else
                        class="rounded-lg border border-dashed border-gray-300 bg-gray-100 py-12 text-center text-gray-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400"
                    >
                        Треки скоро появится
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
