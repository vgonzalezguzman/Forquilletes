<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center w-full p-3">
            <div class="flex flex-col w-full items-center text-center">
                <h1 class="text-3xl font-semibold mb-3">Benvingut, {{ user.name }}.</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-24">
                    <div v-for="restaurant in restaurants" :key="restaurant.id"
                        class="max-w-sm bg-white border border-gray-200 rounded-lg lg:w-full shadow dark:bg-gray-800 dark:border-gray-700">
                        <a :href="'/restaurant/show/' + restaurant.id">
                            <img class="rounded-t-lg object-cover w-full h-48"
                                :src="functionFormatUrl(restaurant.avatar)" :alt="restaurant.name" />
                        </a>
                        <div class="p-5 w-full h-48">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                    {{ restaurant.name }}
                                </h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ restaurant.description }}
                            </p>
                            <a :href="'/restaurant/show/' + restaurant.id"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center rounded-lg  focus:ring-4 focus:outline-none accent">
                                Detalls
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                        <div class="h-48 w-full mt-5">
                            <Map :restaurants="restaurant"></Map>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import Map from '@/Components/Map.vue';

const props = defineProps({
    user: Object,
    restaurants: Array
});

const user = props.user;
const restaurants = props.restaurants;

function functionFormatUrl(url) {
    return '/storage/' + url;
}
</script>

<style scoped>
.svg-rotate {
    transition: transform 0.2s ease;
}

.textColor {
    color: #130019;
}

.background {
    background-color: #FBEEFF;
}

.primary {
    background-color: #B917FC;
}

.secondary {
    background-color: #FD72BB;
}

.accent {
    background-color: #FD4D79;
}
</style>