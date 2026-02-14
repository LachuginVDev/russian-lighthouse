<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Card from '@/Components/Card.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import { Head } from '@inertiajs/vue3';

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
</script>

<template>
    <PublicLayout title="Сборы" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <Head title="Сборы" />
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
