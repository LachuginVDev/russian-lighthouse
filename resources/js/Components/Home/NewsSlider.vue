<script setup lang="ts">
/**
 * Слайдер новостей/анонсов. Горизонтальный скролл карточек.
 */
interface NewsItem {
    id: number;
    title: string;
    excerpt?: string;
    date?: string;
    href?: string;
}

defineProps<{
    items?: NewsItem[];
    title?: string;
}>();

const placeholderItems: NewsItem[] = [
    { id: 1, title: 'Новость или анонс', excerpt: 'Краткое описание.', date: '' },
];
</script>

<template>
    <section class="bg-gray-50 py-16 dark:bg-gray-800 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                {{ title ?? 'Новости и анонсы' }}
            </h2>
            <div class="flex snap-x snap-mandatory gap-4 overflow-x-auto pb-4 scroll-smooth">
                <article
                    v-for="item in (items?.length ? items : placeholderItems)"
                    :key="item.id"
                    class="min-w-[280px] max-w-[320px] snap-start rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900"
                >
                    <time
                        v-if="item.date"
                        class="text-sm text-gray-500 dark:text-gray-400"
                    >
                        {{ item.date }}
                    </time>
                    <h3 class="mt-1 font-semibold text-gray-900 dark:text-white">
                        {{ item.title }}
                    </h3>
                    <p
                        v-if="item.excerpt"
                        class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2"
                    >
                        {{ item.excerpt }}
                    </p>
                    <a
                        v-if="item.href"
                        :href="item.href"
                        class="mt-3 inline-block text-sm font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400"
                    >
                        Подробнее →
                    </a>
                </article>
            </div>
        </div>
    </section>
</template>
