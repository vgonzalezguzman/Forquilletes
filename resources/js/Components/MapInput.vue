<template>
    <div class="relative w-full h-full z-10">
        <div class="flex flex-row relative w-full h-1/6 mb-1">
            <input type="text" v-if="props.value" v-model="searchAddress" :disabled="loading"
                placeholder="Buscar una localització" aria-label="Buscar una localització" :value="props.value.address"
                class="appearance-none block w-5/6 bg-gray-200 text-gray-700 border mr-3 border-gray-200 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" />
            <input type="text" v-if="!props.value" v-model="searchAddress" :disabled="loading"
                placeholder="Buscar una localització" aria-label="Buscar una localització"
                class="appearance-none block w-5/6 bg-gray-200 text-gray-700 border mr-3 border-gray-200 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" />
            <button @click.prevent="searchLocation" :disabled="loading" aria-label="Buscar"
                class="flex justify-center font-semibold accent w-1/6 py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <img src="https://img.icons8.com/ios/100/search--v1.png" class="h-full" alt="">
            </button>
        </div>
        <div ref="mapElement" class="w-full h-5/6 relative z-10"></div>
        <div v-if="loading"
            class="absolute inset-0 w-full h-full flex items-center justify-center bg-gray-100 bg-opacity-75 z-50">
            <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 accent-fill"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
            </div>
        </div>
        <div v-if="showErrorModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex justify-center items-center z-50">
            <div class="bg-white rounded-lg w-1/3 p-4">
                <h2 class="text-xl font-semibold mb-4">Error</h2>
                <p class="text-gray-700 mb-4">La sol·licitud ha trigat massa o s'ha produït un error. Si us plau,
                    intenta-ho més tard.
                </p>
                <button @click="closeErrorModal"
                    class="px-4 py-2 accent text-white rounded focus:outline-none">Tancar</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, defineProps, ref, reactive } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import axios from 'axios';

const props = defineProps({
    value: Object,
    updateValue: Function
});

const mapElement = ref(null);
const searchAddress = ref('');
const loading = ref(false);
const showErrorModal = ref(false);
const state = reactive({
    marker: null,
    map: null
});
var greenIcon = L.icon({
    iconUrl: 'https://img.icons8.com/color/96/marker--v1.png',

    iconSize:     [30, 30],
    iconAnchor:   [15, 15], 
    popupAnchor:  [0, 0]
});

onMounted(() => {
    if (props.value) {
        initializeMap(props.value.lat, props.value.lng);
        updateLocation(props.value.lat, props.value.lng, props.value.address);
    } else {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    initializeMap(userLat, userLng);
                },
                error => {
                    console.error("Error getting user location:", error);
                    initializeMap(41.39490497774026, 2.1754966309966473);
                }
            );
        } else {
            initializeMap(41.39490497774026, 2.1754966309966473);
        }
    }
});

const initializeMap = (lat, lng) => {
    state.map = L.map(mapElement.value).setView([lat, lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(state.map);

    state.marker = L.marker([lat, lng], {icon: greenIcon}, { draggable: true }).addTo(state.map);

    state.marker.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng();
        updateLocation(lat, lng);
    });

    state.map.on('click', (e) => {
        const { lat, lng } = e.latlng;
        state.marker.setLatLng([lat, lng]);
        updateLocation(lat, lng);
        reverseGeocode(lat, lng);
    });
};

const searchLocation = async () => {
    if (searchAddress.value.trim() === '') return;

    loading.value = true;
    const source = axios.CancelToken.source();
    setTimeout(() => source.cancel(), 15000);

    try {
        const response = await axios.get('https://nominatim.openstreetmap.org/search', {
            params: {
                q: searchAddress.value,
                format: 'json',
                addressdetails: 1,
                limit: 1
            },
            cancelToken: source.token
        });

        if (response.data.length > 0) {
            const { lat, lon, display_name } = response.data[0];
            state.map.setView([lat, lon], 13);
            state.marker.setLatLng([lat, lon]);
            updateLocation(lat, lon, display_name);
        }
    } catch (error) {
        console.error("Error al buscar la localització:", error);
        showErrorModal.value = true;
    } finally {
        loading.value = false;
    }
};

const reverseGeocode = async (lat, lng) => {
    loading.value = true;
    const source = axios.CancelToken.source();
    setTimeout(() => source.cancel(), 15000);

    try {
        const response = await axios.get('https://nominatim.openstreetmap.org/reverse', {
            params: {
                lat,
                lon: lng,
                format: 'json'
            },
            cancelToken: source.token
        });

        if (response.data) {
            searchAddress.value = response.data.display_name;
            updateLocation(lat, lng, response.data.display_name);
        }
    } catch (error) {
        console.error("Error reverse geocoding:", error);
        showErrorModal.value = true;
    } finally {
        loading.value = false;
    }
};

const updateLocation = (lat, lng, address = searchAddress.value) => {
    props.updateValue({ lat, lng, address });
};

const closeErrorModal = () => {
    showErrorModal.value = false;
};
</script>

<style scoped>
.accent {
    background-color: #E1C4FF;
}

.accent-fill {
    fill: #E1C4FF;
}
</style>
