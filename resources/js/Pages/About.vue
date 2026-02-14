<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="О группе" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">О группе</h1>
            <section class="mt-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Описание</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Краткое описание группы. Контент будет из админки или базы.
                </p>
            </section>
            <section class="mt-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Фото</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Блок фото — заглушка.</p>
            </section>
            <section class="mt-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Видео</h2>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Видео-блок — заглушка.</p>
            </section>
            <section class="mt-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">История</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    История группы. Текст будет из CMS.
                </p>
            </section>
        </div>
    </PublicLayout>
</template>
