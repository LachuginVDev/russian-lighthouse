<script setup lang="ts">
/**
 * Краткая информация о миссии группы.
 */
defineProps<{
    title?: string;
    text?: string;
    ctaText?: string;
    ctaHref?: string;
}>();
</script>

<template>
    <section class="bg-white py-16 dark:bg-gray-900 md:py-20">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">
                {{ title ?? 'Наша миссия' }}
            </h2>
            <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                {{ text ?? 'Краткое описание миссии и ценностей группы. Здесь будет текст от администратора.' }}
            </p>
            <a
                v-if="ctaText && ctaHref"
                :href="ctaHref"
                class="mt-8 inline-block font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400"
            >
                {{ ctaText }}
            </a>
        </div>
    </section>
</template>
