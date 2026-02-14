<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <Head title="Russian Lighthouse" />
    <div class="flex min-h-screen flex-col bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-1 flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Russian Lighthouse
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Сайт музыкальной группы
            </p>

            <div v-if="canLogin" class="mt-8 flex gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:hover:bg-gray-600"
                >
                    Панель
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:hover:bg-gray-600"
                    >
                        Вход
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                    >
                        Регистрация
                    </Link>
                </template>
            </div>
        </div>
    </div>
</template>
