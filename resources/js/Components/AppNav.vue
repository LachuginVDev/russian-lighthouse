<script setup lang="ts">
import type { HomeSettings } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { useTheme } from '@/composables/useTheme';
import { computed } from 'vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();

const { theme, toggle } = useTheme();
const page = usePage();
const home = computed(() => (page.props.home as HomeSettings | undefined));
const logoUrl = computed(() => home.value?.logo ?? null);
</script>

<template>
    <nav class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-white/90 px-4 py-3 backdrop-blur dark:border-gray-700 dark:bg-gray-900/90">
        <div class="flex flex-wrap items-center gap-6">
            <Link
                :href="route('home')"
                class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white"
                aria-label="На главную"
            >
                <img
                    v-if="logoUrl"
                    :src="logoUrl"
                    alt="Логотип"
                    class="h-8 w-8 shrink-0 rounded object-contain"
                />
            </Link>
            <div class="flex gap-1">
                <Link
                    :href="route('home')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Главная
                </Link>
                <Link
                    :href="route('about')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    О группе
                </Link>
                <Link
                    :href="route('news.index')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Новости
                </Link>
                <Link
                    :href="route('fundraisers.index')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Сборы
                </Link>
                <Link
                    :href="route('media.index')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Медиа
                </Link>
                <Link
                    :href="route('albums.index')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Фотоальбомы
                </Link>
                <Link
                    :href="route('contacts')"
                    class="rounded px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                >
                    Контакты
                </Link>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button
                type="button"
                :aria-label="theme === 'dark' ? 'Светлая тема' : 'Тёмная тема'"
                class="rounded p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
                @click="toggle"
            >
                <span v-if="theme === 'dark'" class="text-lg" title="Светлая тема">☀️</span>
                <span v-else class="text-lg" title="Тёмная тема">🌙</span>
            </button>
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
        </div>
    </nav>
</template>
