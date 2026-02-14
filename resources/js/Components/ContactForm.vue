<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.post(route('contacts.send'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <form class="space-y-4" @submit.prevent="submit">
        <div>
            <InputLabel for="name" value="Имя" />
            <TextInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-1" :message="form.errors.name" />
        </div>
        <div>
            <InputLabel for="email" value="Email" />
            <TextInput
                id="email"
                v-model="form.email"
                type="email"
                class="mt-1 block w-full"
                required
            />
            <InputError class="mt-1" :message="form.errors.email" />
        </div>
        <div>
            <InputLabel for="message" value="Сообщение" />
            <textarea
                id="message"
                v-model="form.message"
                rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-600 dark:bg-gray-800 dark:text-white"
                required
            />
            <InputError class="mt-1" :message="form.errors.message" />
        </div>
        <PrimaryButton :disabled="form.processing">Отправить</PrimaryButton>
    </form>
</template>
