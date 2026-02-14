<script setup lang="ts">
/**
 * Hero-блок с информацией о группе (название, краткое описание, призыв к действию).
 */
defineProps<{
    title?: string;
    subtitle?: string;
    description?: string;
    ctaText?: string;
    ctaHref?: string;
}>();
</script>

<template>
    <section class="bg-white py-16 dark:bg-gray-900 md:py-24">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                {{ title ?? 'Russian Lighthouse' }}
            </h1>
            <p
                v-if="subtitle"
                class="mt-3 text-lg text-amber-600 dark:text-amber-400"
            >
                {{ subtitle }}
            </p>
            <p
                class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300"
            >
                {{ description ?? 'Сайт музыкальной группы. Новости, сборы, медиа и миссия.' }}
            </p>
            <div v-if="ctaText && ctaHref" class="mt-10">
                <a
                    :href="ctaHref"
                    class="inline-flex rounded-md bg-amber-600 px-6 py-3 text-base font-medium text-white shadow hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                >
                    {{ ctaText }}
                </a>
            </div>
        </div>
    </section>
</template>
