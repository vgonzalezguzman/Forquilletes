<template>
    <Layout :user="user" class="flex flex-col w-full h-full ">
        <div class="flex flex-col items-center w-full h-full p-3 overflow-y-auto">
            <div class="flex flex-col w-1/3 h-full items-center text-center ">
                <div class="w-full">
                    <h1 class="text-3xl font-semibold p-3">Afegeix un nou restaurant</h1>
                    <p class="text-lg">TEST</p>
                    <div class="w-full h-1/3">
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import { ref } from 'vue';

defineProps({
    user: Object,
});

const defaultImageUrl = 'https://img.icons8.com/ios-glyphs/120/user--v1.png';
const imageUrl = ref(defaultImageUrl);
const file = ref(null);

const handleImageChange = (event) => {
    const selectedFile = event.target.files[0];
    file.value = selectedFile;
    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
};
</script>

<style scoped></style>
