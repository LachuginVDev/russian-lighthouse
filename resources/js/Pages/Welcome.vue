<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import HeroSlider from '@/Components/Home/HeroSlider.vue';
import HeroBlock from '@/Components/Home/HeroBlock.vue';
import NewsSlider from '@/Components/Home/NewsSlider.vue';
import ActiveFundraisers from '@/Components/Home/ActiveFundraisers.vue';
import MediaBlock from '@/Components/Home/MediaBlock.vue';
import MissionBlock from '@/Components/Home/MissionBlock.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <Head title="Russian Lighthouse" />
    <div class="flex min-h-screen flex-col bg-gray-50 dark:bg-gray-900">
        <!-- Шапка с авторизацией -->
        <header class="sticky top-0 z-10 flex justify-end gap-4 border-b border-gray-200 bg-white/90 px-4 py-3 backdrop-blur dark:border-gray-700 dark:bg-gray-900/90">
            <template v-if="$page.props.auth?.user">
                <Link
                    :href="route('dashboard')"
                    class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600"
                >
                    Панель
                </Link>
            </template>
            <template v-else-if="canLogin">
                <Link
                    :href="route('login')"
                    class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600"
                >
                    Вход
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Регистрация
                </Link>
            </template>
        </header>

        <main>
            <HeroSlider />
            <HeroBlock />
            <NewsSlider />
            <ActiveFundraisers />
            <MediaBlock />
            <MissionBlock />
        </main>
    </div>
</template>
