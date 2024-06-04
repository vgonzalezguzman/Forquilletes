<script setup>
import Layout from '@/Components/Layout.vue';
import { ref } from 'vue';

const props = defineProps({
    restaurants: Object,
    user: Object
});
const user = props.user;
const restaurants = props.restaurants;
</script>

<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <Map class="w-full full" :restaurants="restaurants"></Map>
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