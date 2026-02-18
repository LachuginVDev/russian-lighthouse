<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Fundraiser {
    id: number;
    title: string;
    excerpt?: string;
    goal?: number;
    raised?: number;
    href?: string;
}

defineProps<{
    items: Fundraiser[];
    canLogin?: boolean;
    canRegister?: boolean;
}>();

const page = usePage();
const seo = computed(() => page.props.page_seo?.fundraisers);
const canonicalUrl = `${page.props.app_url ?? ''}${route('fundraisers.index')}`;
</script>

<template>
    <PublicLayout :title="seo?.meta_title ?? 'Сборы'" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <Head :title="seo?.meta_title ?? 'Сборы'">
                <meta v-if="seo?.meta_description" name="description" :content="seo.meta_description" />
                <link rel="canonical" :href="canonicalUrl" />
                <meta v-if="seo?.meta_title" property="og:title" :content="seo.meta_title" />
                <meta v-if="seo?.meta_description" property="og:description" :content="seo.meta_description" />
                <meta v-if="seo?.og_image" property="og:image" :content="seo.og_image" />
                <meta property="og:url" :content="canonicalUrl" />
                <meta property="og:type" content="website" />
            </Head>
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Текущие сборы</h1>
            <div v-if="items?.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <a
                    v-for="item in items"
                    :key="item.id"
                    :href="item.href ?? route('fundraisers.show', item.id)"
                    class="group block rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900"
                >
                    <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400">
                        {{ item.title }}
                    </h3>
                    <p v-if="item.excerpt" class="mt-2 text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                        {{ item.excerpt }}
                    </p>
                    <div v-if="item.raised != null && item.goal != null" class="mt-4">
                        <ProgressBar
                            :value="item.raised"
                            :max="item.goal"
                            :label="`${item.raised} из ${item.goal}`"
                        />
                    </div>
                </a>
            </div>
            <p v-else class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-12 text-center text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">
                Нет активных сборов.
            </p>
        </div>
    </PublicLayout>
</template>
