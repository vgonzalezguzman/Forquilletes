<script setup>
import { onMounted, defineProps, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    restaurants: {
        type: [Array, Object],
        required: true
    }
});

const mapElement = ref(null);

onMounted(() => {
    const map = L.map(mapElement.value);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

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

    const markerGroup = L.featureGroup(markers).addTo(map);
    map.fitBounds(markerGroup.getBounds());
});
</script>

<template>
    <div ref="mapElement" class="w-full h-full z-10"></div>
</template>

<style scoped></style>