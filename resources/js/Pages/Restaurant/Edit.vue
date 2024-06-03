<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <p>edit restaurant</p>
        <button @click.prevent="editRestaurant">Boton</button>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    restaurant: Object,
    gallery: Array,
    contacts: Array
});

const user = ref(props.user);
const restaurant = ref(props.restaurant);
const gallery = ref(props.gallery);
const contacts = ref(props.contacts);

function functionFormatUrl(url) {
    return '/storage/' + url;
}

const editRestaurant = () => {
    console.log(user.value);
    console.log(restaurant.value);
    console.log(gallery.value);
    console.log(contacts.value);
}
</script>