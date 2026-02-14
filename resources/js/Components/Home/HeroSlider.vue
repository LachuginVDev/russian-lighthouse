<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

interface SlideItem {
    id: number;
    imageUrl: string;
    alt?: string;
    link?: string;
}

const props = defineProps<{
    slides?: SlideItem[];
    intervalMs?: number;
}>();

const page = usePage();
const slidesFromShared = (page.props.slides as SlideItem[] | undefined) ?? [];

const list = computed(() => (props.slides?.length ? props.slides : slidesFromShared));
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
                    <component
                        :is="slide.link ? 'a' : 'div'"
                        :href="slide.link"
                        :target="slide.link?.startsWith('http') ? '_blank' : undefined"
                        :rel="slide.link?.startsWith('http') ? 'noopener' : undefined"
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
                    </component>
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
