<template>
    <Layout :user="user" class="flex flex-col w-full h-full ">
        <div class="flex flex-col items-center w-full h-full p-3 overflow-y-auto">
            <div class="flex flex-col w-1/3 h-full items-center text-center ">
                <img :src="functionFormatUrl(restaurant.avatar)" :alt="restaurant.name" class="w-full h-80">
                <div class="w-full">
                    <h1 class="text-3xl font-semibold p-3">{{ restaurant.name }}</h1>
                    <p class="text-lg">{{ restaurant.description }}</p>
                    <a :href="'/restaurant/edit/' + restaurant.id" v-if="user.id === restaurant.uploader"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg  focus:ring-4 focus:outline-none accent">
                        Editar
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                    <ImageGallery class="py-3"></ImageGallery>
                    <div class="w-full h-1/3">
                        <Map class="w-full h-full" :restaurants="restaurant"></Map>
                    </div>
                </div>
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

<style scoped>
div.overflow-y-auto {
    max-height: 100%;
}

.accent {
    background-color: #FD4D79;
}
</style>
