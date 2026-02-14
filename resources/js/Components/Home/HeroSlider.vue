<script setup lang="ts">
import type { HomeSettings, SlideItem } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps<{
    slides?: SlideItem[];
    intervalMs?: number;
}>();

const page = usePage();
const slidesFromShared = computed(
    () => (page.props.slides as SlideItem[] | undefined) ?? [],
);
const home = computed(
    () =>
        (page.props.home as HomeSettings | undefined) ?? {
            hero_text_color: 'white',
        },
);

const list = computed(() =>
    props.slides?.length ? props.slides : slidesFromShared.value,
);
const current = ref(0);
let timer: ReturnType<typeof setInterval> | null = null;

const textColorClass = computed(() =>
    home.value.hero_text_color === 'black'
        ? 'text-gray-900'
        : 'text-white',
);

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
                    <a
                        v-if="slide.link"
                        :href="slide.link"
                        :target="slide.link.startsWith('http') ? '_blank' : undefined"
                        :rel="slide.link.startsWith('http') ? 'noopener' : undefined"
                        class="block h-full w-full"
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
                    </a>
                    <div v-else class="block h-full w-full">
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
                </div>
            </template>
            <div
                v-else
                class="h-full w-full bg-gradient-to-br from-amber-900/80 to-gray-900"
            />
        </div>
        <div class="absolute inset-0 bg-black/30" />
        <!-- Заголовок и подзаголовок слева -->
        <div
            v-if="home.hero_title || home.hero_subtitle"
            class="absolute inset-y-0 left-0 flex flex-col justify-center px-8 md:px-12 lg:px-16 max-w-2xl"
        >
            <h1
                v-if="home.hero_title"
                class="text-3xl font-bold tracking-tight drop-shadow-md md:text-4xl lg:text-5xl"
                :class="textColorClass"
            >
                {{ home.hero_title }}
            </h1>
            <p
                v-if="home.hero_subtitle"
                class="mt-3 text-lg md:text-xl drop-shadow-md"
                :class="textColorClass"
            >
                {{ home.hero_subtitle }}
            </p>
        </div>
    </section>
</template>
