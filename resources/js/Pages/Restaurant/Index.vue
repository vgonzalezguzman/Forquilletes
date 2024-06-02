<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center w-full h-full p-3">
            <div class="flex flex-col w-1/3 h-full items-center text-center">
                <img :src="functionFormatUrl(restaurant.avatar)" :alt="restaurant.name" class="w-full h-80">
                <div class="w-full">
                    <h1 class="text-3xl font-semibold p-3">{{ restaurant.name }}</h1>
                    <p class="text-lg">{{ restaurant.description }}</p>
                    <ImageGallery class="py-3"></ImageGallery>
                </div>
                <Map class="w-full h-1/6" :restaurants="restaurant"></Map>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import Map from '@/Components/Map.vue';
import ImageGallery from '@/Components/ImageGallery.vue';

defineProps({
    user: Object,
    restaurant: Object
});

function functionFormatUrl(url) {
    return '/storage/' + url;
}
</script>