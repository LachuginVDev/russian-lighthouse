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
    image?: string;
}

interface Pagination {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

defineProps<{
    posts: Post[];
    pagination?: Pagination;
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
                    :image="post.image"
                />
            </div>
            <div v-else class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-16 text-center dark:border-gray-600 dark:bg-gray-800">
                <p class="text-gray-500 dark:text-gray-400">Пока нет публикаций.</p>
                <p class="mt-2 text-sm text-gray-400 dark:text-gray-500">Добавьте посты в админке: Админка → Блог → Посты.</p>
            </div>
            <div v-if="pagination && pagination.last_page > 1" class="mt-10 flex justify-center gap-2">
                <a
                    v-for="p in pagination.last_page"
                    :key="p"
                    :href="`/news?page=${p}`"
                    class="rounded px-3 py-1 text-sm"
                    :class="p === pagination.current_page ? 'bg-amber-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300'"
                >
                    {{ p }}
                </a>
            </div>
        </div>
    </PublicLayout>
</template>
