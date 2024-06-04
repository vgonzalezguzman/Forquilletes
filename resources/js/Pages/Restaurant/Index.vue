<template>
    <Layout :user="user" class="flex flex-col w-full h-full ">
        <div class="flex flex-col items-center w-full h-full p-3 overflow-y-auto">
            <div class="flex flex-col w-full lg:w-1/3 justify-center items-center bg-white p-3 mb-24">
                <img :src="functionFormatUrl(restaurant.avatar)" :alt="restaurant.name" class="w-full h-80">
                <div class="flex flex-col w-full justify-center items-center">
                    <h1 class="text-3xl font-semibold p-3">{{ restaurant.name }}</h1>
                    <p class="text-lg">{{ restaurant.description }}</p>
                    <a :href="'/restaurant/edit/' + restaurant.id" v-if="user.id === restaurant.uploader || user.id === restaurant.owner"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg  focus:ring-4 focus:outline-none accent">
                        Editar
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                    <ImageGallery :gallery="gallery" class="py-3"></ImageGallery>

                    <div class="py-3">
                        <p>Informació:</p>
                        <p v-if="restaurant.owner">Propietari: {{ owner.name }}</p>
                        <p v-else>Sembla que aquest restaurant no té un propietari assignat.</p>
                        <p v-if="restaurant.email">Correu: {{ restaurant.email }}</p>
                        <p v-else>Sembla que el restaurant no té una direcció de correu assignada.</p>
                        <p v-if="restaurant.phone">Nº de telèfon: {{ restaurant.phone }}</p>
                        <p v-else>Sembla que el restaurant no té un telèfon assignat.</p>
                        <p v-if="restaurant.website">Pàgina: <a :href="restaurant.website">{{ restaurant.website }}</a></p>
                        <p v-else>Sembla que el restaurant no té una pàgina assignada.</p>
                        <p>Creat: {{ formatDate(restaurant.created_at) }}</p>
                        <p>Actualitzat: {{ formatDate(restaurant.updated_at) }}</p>
                        <p>Direcció: {{ restaurant.address }}</p>
                    </div>                    
                    <div class="w-full h-44">
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
    restaurant: Object,
    gallery: Array,
    owner: Object
});

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric'};
    return new Intl.DateTimeFormat('ca', options).format(date);
}

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
