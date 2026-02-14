<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Панель" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Панель
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p class="mb-4">Вы вошли в систему.</p>
                        <p v-if="$page.props.auth?.user?.role_id === 2" class="text-sm text-gray-600 dark:text-gray-400">
                            <a
                                href="/admin"
                                class="font-medium text-amber-600 hover:text-amber-500 dark:text-amber-400"
                            >
                                → Открыть админку (Filament)
                            </a>
                            — управление постами, категориями, тегами и др.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
