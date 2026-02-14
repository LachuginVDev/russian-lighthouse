<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ContactForm from '@/Components/ContactForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="Контакты" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            <Head title="Контакты" />
            <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Контакты</h1>
            <section class="mb-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Контактная информация</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Адрес, телефон, email — из настроек или CMS.</p>
            </section>
            <section class="mb-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Соцсети</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Ссылки на соцсети — заглушка.</p>
            </section>
            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Форма обратной связи</h2>
                <ContactForm />
            </section>
        </div>
    </PublicLayout>
</template>
