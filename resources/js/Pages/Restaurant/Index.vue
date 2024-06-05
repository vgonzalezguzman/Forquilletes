<template>
    <Layout :user="user" class="flex flex-col w-full h-full ">
        <div class="flex flex-col items-center w-full h-full p-3 overflow-y-auto">
            <div class="flex flex-col w-full lg:w-1/3 justify-center items-center bg-white p-3 mb-24">
                <img :src="functionFormatUrl(restaurant.avatar)" :alt="restaurant.name" class="w-full h-80">
                <div class="flex flex-col w-full justify-center items-center">
                    <h1 class="text-3xl font-semibold p-3">{{ restaurant.name }}</h1>
                    <p class="text-lg">{{ restaurant.description }}</p>

                    <div class="flex flex-row w-full justify-center">
                        <div v-if="user && (user.id === restaurant.uploader || user.id === restaurant.owner)"
                            class="flex justify-center items-center w-3/6">
                            <a :href="'/restaurant/edit/' + restaurant.id"
                                class="inline-flex items-center align-center justify-center px-3 py-2 text-sm mx-3 font-medium text-center rounded-lg  focus:ring-4 focus:outline-none accent w-full">
                                Editar
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                        <button @click.prevent="showComments()"
                            class="inline-flex items-center align-center justify-center px-3 py-2 text-sm mx-3 font-medium text-center rounded-lg  focus:ring-4 focus:outline-none accent w-3/6">
                            Opinions
                            <div class="flex items-center">
                                <template v-for="star in stars">
                                    <svg class="w-3 h-3 text-yellow-300 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"
                                        v-if="star.filled">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                    <svg class="w-3 h-3 text-gray-300 dark:text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"
                                        v-else>
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                </template>
                            </div>
                        </button>
                    </div>
                    <Comments :user="user" :comments="comments" :closeModal="hideComments" :restaurantId="restaurant.id"
                        class="py-3" v-if="isModalVisible">
                    </Comments>
                    <ImageGallery v-if="gallery.length > 0" :gallery="gallery" class="py-3"></ImageGallery>
                    <div class="py-3">
                        <p>Informació:</p>
                        <p v-if="restaurant.email">Correu: {{ restaurant.email }}</p>
                        <p v-else>Sembla que el restaurant no té una direcció de correu assignada.</p>
                        <p v-if="restaurant.phone">Nº de telèfon: {{ restaurant.phone }}</p>
                        <p v-else>Sembla que el restaurant no té un telèfon assignat.</p>
                        <p v-if="restaurant.website">Pàgina: <a :href="restaurant.website">{{ restaurant.website }}</a>
                        </p>
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
import Comments from '@/Components/Comments.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    user: Object,
    restaurant: Object,
    gallery: Array,
    owner: Object,
    comments: Array
});

const user = ref(props.user);
const restaurant = ref(props.restaurant);
const gallery = ref(props.gallery);
const owner = ref(props.owner);
const comments = ref(props.comments);

const averageRating = computed(() => {
    if (comments.value.length === 0) return 0;

    const totalRating = comments.value.reduce((acc, comment) => {
        return acc + comment.rating;
    }, 0);

    return totalRating / comments.value.length;
});

const stars = computed(() => {
    const roundedRating = Math.round(averageRating.value);
    const stars = [];

    for (let i = 1; i <= 5; i++) {
        stars.push({
            value: i,
            filled: i <= roundedRating
        });
    }

    return stars;
});


function getAverageRatingStars() {
    const roundedRating = Math.round(averageRating.value);
    const stars = [];

    for (let i = 1; i <= 5; i++) {
        stars.push({
            value: i,
            filled: i <= roundedRating
        });
    }

    return stars;
}

const isModalVisible = ref(false);

const showComments = () => {
    isModalVisible.value = true;
};

const hideComments = () => {
    isModalVisible.value = false;
};

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
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
    background-color: #E1C4FF;
}
</style>
