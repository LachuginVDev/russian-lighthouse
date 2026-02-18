<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import ProgressBar from '@/Components/ProgressBar.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    id: number;
    fundraiser: {
        title: string;
        description?: string;
        goal?: number;
        raised?: number;
        meta_title?: string;
        meta_description?: string;
        og_image?: string | null;
        canonical_url?: string;
    } | null;
    canLogin?: boolean;
    canRegister?: boolean;
}>();

const donationForm = useForm({
    amount: '' as string | number,
    donor_name: '',
    donor_email: '',
    message: '',
    is_anonymous: false,
});

const successMessage = ref<string | null>(null);

function submitDonation() {
    successMessage.value = null;
    donationForm.post(route('fundraisers.donate', props.id), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = 'Спасибо! Пожертвование учтено.';
            donationForm.reset('amount', 'donor_name', 'donor_email', 'message', 'is_anonymous');
        },
    });
}
</script>

<template>
    <PublicLayout title="Сбор" :can-login="canLogin" :can-register="canRegister">
        <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
            <Head :title="fundraiser?.meta_title ?? fundraiser?.title ?? 'Сбор'">
                <meta v-if="fundraiser?.meta_description" name="description" :content="fundraiser.meta_description" />
                <link v-if="fundraiser?.canonical_url" rel="canonical" :href="fundraiser.canonical_url" />
                <meta v-if="fundraiser?.meta_title ?? fundraiser?.title" property="og:title" :content="fundraiser.meta_title ?? fundraiser.title" />
                <meta v-if="fundraiser?.meta_description" property="og:description" :content="fundraiser.meta_description" />
                <meta v-if="fundraiser?.og_image" property="og:image" :content="fundraiser.og_image" />
                <meta v-if="fundraiser?.canonical_url" property="og:url" :content="fundraiser.canonical_url" />
                <meta property="og:type" content="website" />
            </Head>
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
                <div v-if="fundraiser.description" class="mt-6 text-gray-600 dark:text-gray-300 prose prose-lg dark:prose-invert max-w-none" v-html="fundraiser.description" />
                <section class="mt-10 rounded-lg border border-gray-200 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Поддержать</h2>
                    <form @submit.prevent="submitDonation" class="mt-4 space-y-4">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Сумма (₽) *</label>
                            <input
                                id="amount"
                                v-model.number="donationForm.amount"
                                type="number"
                                min="1"
                                step="1"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            />
                            <p v-if="donationForm.errors.amount" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ donationForm.errors.amount }}</p>
                        </div>
                        <div class="flex items-center">
                            <input
                                id="is_anonymous"
                                v-model="donationForm.is_anonymous"
                                type="checkbox"
                                class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700"
                            />
                            <label for="is_anonymous" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Анонимно</label>
                        </div>
                        <template v-if="!donationForm.is_anonymous">
                            <div>
                                <label for="donor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Имя</label>
                                <input
                                    id="donor_name"
                                    v-model="donationForm.donor_name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                />
                            </div>
                            <div>
                                <label for="donor_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input
                                    id="donor_email"
                                    v-model="donationForm.donor_email"
                                    type="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                />
                            </div>
                        </template>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Сообщение (необязательно)</label>
                            <textarea
                                id="message"
                                v-model="donationForm.message"
                                rows="2"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            />
                        </div>
                        <button
                            type="submit"
                            :disabled="donationForm.processing"
                            class="rounded-md bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 disabled:opacity-50 dark:focus:ring-offset-gray-800"
                        >
                            Отправить
                        </button>
                        <p v-if="successMessage" class="text-sm text-green-600 dark:text-green-400">{{ successMessage }}</p>
                    </form>
                </section>
            </template>
            <p v-else class="mt-8 text-gray-500 dark:text-gray-400">Сбор не найден.</p>
        </div>
    </PublicLayout>
</template>
