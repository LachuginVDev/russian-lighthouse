<script setup lang="ts">
/**
 * Блок текущих (активных) сборов. Сетка карточек со ссылкой на сбор.
 */
interface Fundraiser {
    id: number;
    title: string;
    excerpt?: string;
    goal?: string;
    raised?: string;
    progress?: number;
    href?: string;
}

defineProps<{
    items?: Fundraiser[];
    title?: string;
}>();
</script>

<template>
    <section class="bg-white py-16 dark:bg-gray-900 md:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                {{ title ?? 'Текущие сборы' }}
            </h2>
            <div
                v-if="items?.length"
                class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
            >
                <a
                    v-for="item in items"
                    :key="item.id"
                    :href="item.href ?? '#'"
                    class="group flex flex-col rounded-lg border border-gray-200 bg-gray-50 p-5 transition hover:border-amber-500 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-amber-500"
                >
                    <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400">
                        {{ item.title }}
                    </h3>
                    <p
                        v-if="item.excerpt"
                        class="mt-2 flex-1 text-sm text-gray-600 dark:text-gray-300 line-clamp-2"
                    >
                        {{ item.excerpt }}
                    </p>
                    <div v-if="item.progress != null" class="mt-4">
                        <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                            <div
                                class="h-2 rounded-full bg-amber-500 transition-all"
                                :style="{ width: `${Math.min(100, item.progress)}%` }"
                            />
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <span v-if="item.raised">{{ item.raised }}</span>
                            <span v-if="item.goal"> из {{ item.goal }}</span>
                        </p>
                    </div>
                </a>
            </div>
            <p
                v-else
                class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-12 text-center text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400"
            >
                Сейчас нет активных сборов.
            </p>
        </div>
    </section>
</template>
