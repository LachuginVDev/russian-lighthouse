<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    id: number;
    fundraiser: {
        title: string;
        description?: string;
        goal?: number;
        raised?: number;
    } | null;
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="Сбор" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            <Head :title="fundraiser?.title ?? 'Сбор'" />
            <Link :href="route('fundraisers.index')" class="text-sm text-amber-600 hover:text-amber-500 dark:text-amber-400">
                ← К списку сборов
            </Link>
            <template v-if="fundraiser">
                <h1 class="mt-4 text-3xl font-bold text-gray-900 dark:text-white">{{ fundraiser.title }}</h1>
                <div v-if="fundraiser.raised != null && fundraiser.goal != null" class="mt-6">
                    <ProgressBar
                        :value="fundraiser.raised"
                        :max="fundraiser.goal"
                        :label="`Собрано ${fundraiser.raised} из ${fundraiser.goal}`"
                    />
                </div>
                <div v-if="fundraiser.description" class="mt-6 text-gray-600 dark:text-gray-300" v-html="fundraiser.description" />
                <section class="mt-10">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Поддержать</h2>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Форма пожертвования будет подключена к бэкенду.</p>
                </section>
            </template>
            <p v-else class="mt-8 text-gray-500 dark:text-gray-400">Сбор не найден.</p>
        </div>
    </PublicLayout>
</template>
