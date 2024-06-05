<script setup>
import Layout from '@/Components/Layout.vue';
import Map from '@/Components/Map.vue';
import { ref, computed } from 'vue';

const props = defineProps({
    user: Object,
    restaurants: Object
});

const user = ref(props.user);
const restaurants = ref(props.restaurants);

const filteredRestaurants = ref(props.restaurants);
const minRating = ref(0);
const maxRating = ref(5);

const applyFilters = () => {
  filteredRestaurants.value = restaurants.value.filter(restaurant => {
    const ratingInRange = restaurant.comments_avg_rating >= minRating.value && restaurant.comments_avg_rating <= maxRating.value;
    return ratingInRange;
  });
};

</script>

<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <div class="flex flex-col w-full h-2/6">
            <div class="flex flex-row w-full justify-center">
                <div class="w-fit p-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-min">
                        Valoració mínima
                    </label>
                    <input type="number" v-model.number="minRating" placeholder="Valoració mínima" aria-label="Valoració mínima"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                </div>
                <div class="w-fit p-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-max">
                        Valoració màxima
                    </label>
                    <input type="number" aria-label="Valoració màxima"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model.number="maxRating" placeholder="Maximum Rating">
                </div>
            </div>
            <div class="flex justify-center pb-3">
                <button @click.prevent="applyFilters" type="submit" aria-label="Aplicar Filtres"
                    class="font-semibold accent py-2 px-4 mr-5 w-3/6 lg:w-1/6 rounded focus:outline-none focus:shadow-outline">Aplicar
                    Filtres</button>
            </div>
        </div>
        <div class="w-full h-4/6">
            <Map class="w-full h-full" :restaurants="filteredRestaurants"></Map>
        </div>
    </Layout>
</template>

<style scoped>
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
    background-color: #E1C4FF;
}
</style>