<script setup lang="ts">
/**
 * Слайдер новостей: по 4 карточки в слайде, адаптив (1/2/4 колонки), переключение стрелками.
 */
import { ref, computed } from 'vue';

interface NewsItem {
    id: number;
    title: string;
    excerpt?: string | null;
    date?: string | null;
    href?: string | null;
    image?: string | null;
}

const props = withDefaults(
    defineProps<{
        items?: NewsItem[];
        title?: string;
    }>(),
    { items: () => [] }
);

const placeholderItems: NewsItem[] = [
    { id: 1, title: 'Новость или анонс', excerpt: 'Краткое описание.', date: '' },
];

const list = computed(() =>
    props.items?.length ? props.items : placeholderItems
);

const ITEMS_PER_SLIDE = 4;
const slides = computed(() => {
    const arr = list.value;
    const result: NewsItem[][] = [];
    for (let i = 0; i < arr.length; i += ITEMS_PER_SLIDE) {
        result.push(arr.slice(i, i + ITEMS_PER_SLIDE));
    }
    return result.length ? result : [[]];
});

const currentSlide = ref(0);
const totalSlides = computed(() => slides.value.length);

function goPrev() {
    currentSlide.value =
        currentSlide.value > 0 ? currentSlide.value - 1 : totalSlides.value - 1;
}
function goNext() {
    currentSlide.value =
        currentSlide.value < totalSlides.value - 1 ? currentSlide.value + 1 : 0;
}
</script>

<template>
    <section class="bg-gray-50 py-16 dark:bg-gray-800 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                        {{ title ?? 'Новости и анонсы' }}
                    </h2>
                    <a
                        :href="route('news.index')"
                        class="text-sm font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400"
                    >
                        Все новости
                    </a>
                </div>
                <div
                    v-if="totalSlides > 1"
                    class="flex shrink-0 gap-2"
                >
                    <button
                        type="button"
                        class="rounded-full bg-white p-2 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:ring-gray-600 dark:hover:bg-gray-600"
                        aria-label="Предыдущий слайд"
                        @click="goPrev"
                    >
                        <span class="sr-only">Назад</span>
                        ‹
                    </button>
                    <button
                        type="button"
                        class="rounded-full bg-white p-2 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50 dark:bg-gray-700 dark:ring-gray-600 dark:hover:bg-gray-600"
                        aria-label="Следующий слайд"
                        @click="goNext"
                    >
                        <span class="sr-only">Вперёд</span>
                        ›
                    </button>
                </div>
            </div>

            <div class="relative mt-8 overflow-hidden">
                <div
                    class="flex transition-transform duration-300 ease-out"
                    :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
                >
                    <div
                        v-for="(slideItems, slideIndex) in slides"
                        :key="slideIndex"
                        class="w-full shrink-0"
                    >
                        <div
                            class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
                        >
                            <article
                                v-for="item in slideItems"
                                :key="item.id"
                                class="flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900"
                            >
                                <a
                                    v-if="item.href"
                                    :href="item.href"
                                    class="block flex-1"
                                >
                                    <div
                                        v-if="item.image"
                                        class="aspect-video w-full bg-gray-200 dark:bg-gray-700"
                                    >
                                        <img
                                            :src="item.image"
                                            :alt="item.title"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="p-4">
                                        <time
                                            v-if="item.date"
                                            class="text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ item.date }}
                                        </time>
                                        <h3 class="mt-1 font-semibold text-gray-900 dark:text-white line-clamp-2">
                                            {{ item.title }}
                                        </h3>
                                        <p
                                            v-if="item.excerpt"
                                            class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2"
                                        >
                                            {{ item.excerpt }}
                                        </p>
                                        <span
                                            class="mt-3 inline-block text-sm font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400"
                                        >
                                            Подробнее →
                                        </span>
                                    </div>
                                </a>
                                <template v-else>
                                    <div
                                        v-if="item.image"
                                        class="aspect-video w-full bg-gray-200 dark:bg-gray-700"
                                    >
                                        <img
                                            :src="item.image"
                                            :alt="item.title"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="p-4">
                                        <time
                                            v-if="item.date"
                                            class="text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ item.date }}
                                        </time>
                                        <h3 class="mt-1 font-semibold text-gray-900 dark:text-white line-clamp-2">
                                            {{ item.title }}
                                        </h3>
                                        <p
                                            v-if="item.excerpt"
                                            class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2"
                                        >
                                            {{ item.excerpt }}
                                        </p>
                                    </div>
                                </template>
                            </article>
                        </div>
                    </div>
                </div>
                <div
                    v-if="totalSlides > 1"
                    class="mt-4 flex justify-center gap-1.5"
                >
                    <button
                        v-for="idx in totalSlides"
                        :key="idx"
                        type="button"
                        class="h-2 w-2 rounded-full transition-colors"
                        :class="idx - 1 === currentSlide
                            ? 'bg-amber-600'
                            : 'bg-gray-300 dark:bg-gray-600'"
                        :aria-label="`Слайд ${idx}`"
                        @click="currentSlide = idx - 1"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
