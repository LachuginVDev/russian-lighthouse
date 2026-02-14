<script setup lang="ts">
/**
 * Переиспользуемая карточка: заголовок, описание, опциональная ссылка и дата.
 */
defineProps<{
    title: string;
    excerpt?: string;
    date?: string;
    href?: string;
}>();
</script>

<template>
    <article
        class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900"
    >
        <time v-if="date" class="text-sm text-gray-500 dark:text-gray-400">{{ date }}</time>
        <h3 class="mt-1 font-semibold text-gray-900 dark:text-white">
            <a v-if="href" :href="href" class="hover:text-amber-600 dark:hover:text-amber-400">{{ title }}</a>
            <template v-else>{{ title }}</template>
        </h3>
        <p v-if="excerpt" class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
            {{ excerpt }}
        </p>
        <a
            v-if="href"
            :href="href"
            class="mt-3 inline-block text-sm font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400"
        >
            Подробнее →
        </a>
    </article>
</template>
