<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center w-full h-1/3 p-3">
            <div class="flex flex-col items-center text-center">
                <h1 class="text-3xl font-semibold">Benvingut a Forquilletes</h1>
                <p class="text-lg">Preparat per descobrir noves experiències?</p>
                <p class="text-lg">Potser busques que el teu negoci sigui vist?</p>
                <p class="text-lg">O vols compartir la teva experiència amb altres usuaris?</p>
                <h2 class="text-2xl font-semibold">Si la teva resposta és positiva, benvingut!</h2>
            </div>
        </div>
        <div class="flex flex-col items-center w-full h-1/3 p-3">
            <div class="flex flex-col items-center text-center">
                <h1 class="text-3xl font-semibold">Una llista de restaurants que s'actualitza amb els usuaris.</h1>
                <p class="text-lg">Evitaràs tornar-te boig buscant el menú.</p>
                <p class="text-lg">Fotos i opinions per als més escrupolosos.</p>
                <p class="text-lg">No et preocupis si no te'n recordes dels carrers, som el teu mapa!</p>
            </div>
        </div>
        <Map class="w-full h-2/6" :restaurants="restaurants" :mapId="'map-1'"></Map>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import Map from '@/Components/Map.vue';
defineProps({
    user: Object,
    restaurants: Object
});
</script>