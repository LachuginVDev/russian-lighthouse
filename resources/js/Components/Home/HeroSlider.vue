<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';

/**
 * Слайдер фона главной страницы.
 * Принимает массив слайдов (изображения/URL), автоматическая смена.
 */
interface Slide {
    id: number;
    imageUrl: string;
    alt?: string;
}

const props = defineProps<{
    slides?: Slide[];
    intervalMs?: number;
}>();

const defaultSlides: Slide[] = [
    { id: 1, imageUrl: '', alt: 'Фон 1' },
    { id: 2, imageUrl: '', alt: 'Фон 2' },
];

const list = computed(() => (props.slides?.length ? props.slides : defaultSlides));
const current = ref(0);
let timer: ReturnType<typeof setInterval> | null = null;

onMounted(() => {
    if (list.value.length <= 1) return;
    timer = setInterval(() => {
        current.value = (current.value + 1) % list.value.length;
    }, props.intervalMs ?? 5000);
});

onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>
    <section class="relative h-[70vh] min-h-[400px] w-full overflow-hidden bg-gray-900">
        <div
            class="absolute inset-0 flex transition-transform duration-700 ease-out"
            :class="{ 'animate-pulse': !list.length }"
        >
            <template v-if="list.length">
                <div
                    v-for="(slide, index) in list"
                    :key="slide.id"
                    class="absolute inset-0 flex-shrink-0 transition-opacity duration-700"
                    :class="index === current ? 'opacity-100' : 'opacity-0'"
                >
                    <img
                        v-if="slide.imageUrl"
                        :src="slide.imageUrl"
                        :alt="slide.alt ?? ''"
                        class="h-full w-full object-cover"
                    />
                    <div
                        v-else
                        class="h-full w-full bg-gradient-to-br from-amber-900/80 to-gray-900"
                    />
                </div>
            </template>
            <div
                v-else
                class="h-full w-full bg-gradient-to-br from-amber-900/80 to-gray-900"
            />
        </div>
        <div class="absolute inset-0 bg-black/30" />
    </section>
</template>
