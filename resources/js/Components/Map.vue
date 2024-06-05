<template>
    <div ref="mapElement" class="w-full h-full z-10"></div>
</template>

<script setup>
import { onMounted, watch, defineProps, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { debounce } from 'lodash-es';

const props = defineProps({
    restaurants: {
        type: [Array, Object],
        required: true
    }
});

const mapElement = ref(null);
let map;
let markerGroup;

const initializeMap = () => {
    map = L.map(mapElement.value);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
};

const updateMarkers = () => {
    if (markerGroup) {
        markerGroup.clearLayers();
    }

    let markers;
    if (Array.isArray(props.restaurants)) {
        markers = props.restaurants.map(restaurant =>
            L.marker([restaurant.lat, restaurant.lng])
                .bindPopup(`<b>${restaurant.name}</b><br>${restaurant.description}<br><p class="flex">${getRatingStars(restaurant.comments_avg_rating)}</p><br><a href="/restaurant/show/${restaurant.id}">Més informació</a>`,)
        );
    } else {
        const restaurant = props.restaurants;
        markers = [
            L.marker([restaurant.lat, restaurant.lng])
                .bindPopup(`<b>${restaurant.name}</b><br>${restaurant.description}`)
        ];
    }

    markerGroup = L.featureGroup(markers).addTo(map);
    map.fitBounds(markerGroup.getBounds());
};

onMounted(() => {
    initializeMap();
    updateMarkers();
});

const debouncedUpdateMarkers = debounce(updateMarkers, 300);

watch(() => props.restaurants, debouncedUpdateMarkers, { deep: true });

const getRatingStars = (avgRating) => {
    const stars = [];
    const roundedRating = Math.round(avgRating);

    for (let i = 1; i <= 5; i++) {
        if (i <= roundedRating) {
            stars.push(`<svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                  </svg>`);
        } else {
            stars.push(`<svg class="w-4 h-4 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                      <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                  </svg>`);
        }
    }

    return stars.join('');
};
</script>

<style scoped></style>