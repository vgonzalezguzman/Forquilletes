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
                .bindPopup(`<b>${restaurant.name}</b><br>${restaurant.description}`)
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
</script>

<template>
    <div ref="mapElement" class="w-full h-full z-10"></div>
</template>

<style scoped></style>
