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
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Соцсети</h2>
                <div v-if="$page.props.social_links?.length" class="flex flex-wrap gap-4">
                    <a
                        v-for="(link, i) in $page.props.social_links"
                        :key="i"
                        :href="link.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-3 transition hover:border-amber-500 hover:shadow dark:border-gray-700 dark:bg-gray-800"
                    >
                        <img v-if="link.image" :src="link.image" :alt="link.title" class="h-8 w-8 rounded object-cover" />
                        <span class="font-medium text-gray-900 dark:text-white">{{ link.title }}</span>
                    </a>
                </div>
                <p v-else class="text-gray-500 dark:text-gray-400">Добавьте ссылки в админке: Админка → Контент → Соцсети.</p>
            </section>
            <section>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Форма обратной связи</h2>
                <ContactForm />
            </section>
        </div>
    </PublicLayout>
</template>
