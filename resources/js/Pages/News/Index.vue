<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Card from '@/Components/Card.vue';
import { Head } from '@inertiajs/vue3';

interface Post {
    id: number;
    title: string;
    excerpt?: string;
    date?: string;
    href?: string;
}

defineProps<{
    posts: Post[];
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="Новости" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <Head title="Новости" />
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Новости</h1>
            <div v-if="posts?.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <Card
                    v-for="post in posts"
                    :key="post.id"
                    :title="post.title"
                    :excerpt="post.excerpt"
                    :date="post.date"
                    :href="post.href ?? route('news.show', post.id)"
                />
            </div>
            <p v-else class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-12 text-center text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                Пока нет публикаций.
            </p>
        </div>
    </PublicLayout>
</template>
