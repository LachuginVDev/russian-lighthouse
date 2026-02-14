<script setup lang="ts">
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        value: number;
        max?: number;
        label?: string;
    }>(),
    { max: 100 }
);

const percent = computed(() => Math.min(100, Math.round((props.value / props.max) * 100)));
</script>

<template>
    <div>
        <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
            <div
                class="h-2 rounded-full bg-amber-500 transition-all"
                :style="{ width: `${percent}%` }"
            />
        </div>
        <p v-if="props.label" class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ props.label }}</p>
    </div>
</template>
