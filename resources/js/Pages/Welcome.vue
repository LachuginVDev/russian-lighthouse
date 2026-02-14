<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSlider from '@/Components/Home/HeroSlider.vue';
import HeroBlock from '@/Components/Home/HeroBlock.vue';
import NewsSlider from '@/Components/Home/NewsSlider.vue';
import ActiveFundraisers from '@/Components/Home/ActiveFundraisers.vue';
import MediaBlock from '@/Components/Home/MediaBlock.vue';
import MissionBlock from '@/Components/Home/MissionBlock.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>
    <PublicLayout title="Russian Lighthouse" :can-login="canLogin" :can-register="canRegister">
        <HeroSlider />
        <HeroBlock />
        <NewsSlider />
        <ActiveFundraisers />
        <MediaBlock />
        <MissionBlock />
    </PublicLayout>
</template>
