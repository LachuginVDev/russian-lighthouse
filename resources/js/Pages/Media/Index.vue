<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="Медиа" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <Head title="Медиа" />
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Медиа</h1>
            <section class="mb-12">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Видео</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Видео (встроенные или загруженные) — заглушка.</p>
            </section>
            <section class="mb-12">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Аудио</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Аудио-плеер — заглушка.</p>
            </section>
            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Галерея</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Галерея — заглушка.</p>
            </section>
        </div>
    </PublicLayout>
</template>
