<script setup lang="ts">
import AppNav from '@/Components/AppNav.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <Head :title="title" />
    <div class="flex min-h-screen flex-col bg-gray-50 dark:bg-gray-900">
        <header class="sticky top-0 z-10">
            <AppNav :can-login="canLogin" :can-register="canRegister" />
        </header>
        <main class="flex-1">
            <slot />
        </main>
    </div>
</template>
