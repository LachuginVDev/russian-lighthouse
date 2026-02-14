<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    id: number;
    post: { title: string; body?: string; date?: string } | null;
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="Новость" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            <Head :title="post?.title ?? 'Новость'" />
            <Link :href="route('news.index')" class="text-sm text-amber-600 hover:text-amber-500 dark:text-amber-400">
                ← К списку новостей
            </Link>
            <template v-if="post">
                <time class="mt-4 block text-sm text-gray-500 dark:text-gray-400">{{ post.date }}</time>
                <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ post.title }}</h1>
                <div class="mt-6 prose dark:prose-invert" v-html="post.body ?? ''" />
            </template>
            <p v-else class="mt-8 text-gray-500 dark:text-gray-400">Публикация не найдена или ещё не загружена.</p>
        </div>
    </PublicLayout>
</template>
