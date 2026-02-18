<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroBlock from '@/Components/Home/HeroBlock.vue';
import NewsSlider from '@/Components/Home/NewsSlider.vue';
import ActiveFundraisers from '@/Components/Home/ActiveFundraisers.vue';
import MediaBlock from '@/Components/Home/MediaBlock.vue';
import MissionBlock from '@/Components/Home/MissionBlock.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface AlbumPhoto {
    id: number;
    image: string;
    caption?: string | null;
}
interface Album {
    id: number;
    title: string;
    cover: string | null;
    photos: AlbumPhoto[];
}

const props = defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    albums?: Album[];
}>();

const page = usePage();
const seo = computed(() => page.props.page_seo?.home);
const canonicalUrl = `${page.props.app_url ?? ''}${route('home')}`;
</script>

<template>
    <PublicLayout :title="seo?.meta_title ?? 'Russian Lighthouse'" :can-login="canLogin" :can-register="canRegister">
        <Head :title="seo?.meta_title ?? 'Russian Lighthouse'">
            <meta v-if="seo?.meta_description" name="description" :content="seo.meta_description" />
            <link rel="canonical" :href="canonicalUrl" />
            <meta v-if="seo?.meta_title" property="og:title" :content="seo.meta_title" />
            <meta v-if="seo?.meta_description" property="og:description" :content="seo.meta_description" />
            <meta v-if="seo?.og_image" property="og:image" :content="seo.og_image" />
            <meta property="og:url" :content="canonicalUrl" />
            <meta property="og:type" content="website" />
        </Head>
        <HeroBlock :albums="albums ?? []" />
        <NewsSlider />
        <ActiveFundraisers />
        <MediaBlock />
        <MissionBlock />
    </PublicLayout>
</template>
