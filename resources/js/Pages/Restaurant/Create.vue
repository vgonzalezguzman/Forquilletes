<template>
    <Layout :user="user" class="flex flex-col w-full h-full ">
        <div class="flex flex-col items-center justify-center pt-0 w-full h-full p-3">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h1 class="flex text-3xl justify-center items-center font-semibold p-3">Afegeix un nou restaurant</h1>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="flex items-center h-full w-full justify-center relative">
                        <div class="flex flex-col items-center justify-center relative w-full h-40">
                            <input aria-label="Imatge del perfil" id="profile_image" type="file" accept="image/*"
                                @change="handleAvatarChange"
                                class="absolute w-full h-full inset-0 opacity-0 cursor-pointer" />
                            <img class="w-full h-full border object-contain" :src="imageUrl" alt="User Avatar" />
                            <div id="profile_image_overlay"
                                class="absolute inset-0 pointer-events-none flex items-center justify-center bg-white bg-opacity-50 opacity-0 transition-opacity">
                                <svg class="svg-snoweb svg-theme-light h-10 w-10" viewBox="0 0 100 100"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path class="svg-fill-primary"
                                        d="M22,78a4,4,0,0,1,4-4H74a4,4,0,0,1,0,8H26A4,4,0,0,1,22,78ZM35.2,36.8a3.9,3.9,0,0,1,0-5.6l12-12a3.9,3.9,0,0,1,5.6,0l12,12a4,4,0,1,1-5.6,5.6L54,31.6V62a4,4,0,0,1-8,0V31.6l-5.2,5.2A3.9,3.9,0,0,1,35.2,36.8Z"
                                        fill-rule="evenodd" />
                                </svg>
                                <span class="ml-2">Pujar imatge</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full justify-center">
                    <p v-if="!imageIsValid" class="text-red-600 text-xs italic">La imatge de perfil no és vàlida</p>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-name">
                            Nom del restaurant
                        </label>
                        <input v-model="name"
                            :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !nameIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': nameIsValid }"
                            id="grid-name" type="text" placeholder="El Gran Sol">
                        <p v-if="!nameIsValid" class="text-red-600 text-xs italic">El nom no és vàlid.</p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="description"
                            class="block text-sm font-medium leading-6 text-gray-900">Descripció</label>
                        <div class="mt-2">
                            <textarea id="description" name="description" rows="3" v-model="description"
                                placeholder="Escriu una petita descripció del restaurant."
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            for="multiple_files">
                            Imatges per la galeria
                        </label>
                        <input @change="handleGalleryChange"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            id="multiple_files" type="file" accept="image/*" multiple>
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    <input :class="{ 'cursor-not-allowed': !isValidForm, 'cursor-pointer': isValidForm }" type="submit"
                        @click.prevent="uploadData"
                        class="font-semibold accent py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        value="Resgistra't">
                </div>
            </form>

            <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="bg-white rounded-lg shadow-xl p-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold" id="modal-title">Creació d'usuari</h3>
                            <button v-if="responseIsError === true" @click="closeModal"
                                class="text-gray-500 hover:text-gray-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <button v-if="responseIsError === false" @click="redirectHome"
                                class="text-gray-500 hover:text-gray-700">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm text-gray-700">{{ serverResponse }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import { ref, computed } from 'vue';
import axios from 'axios';

defineProps({
    user: Object,
    restaurant: Object
});

const name = ref('');
const defaultImageUrl = 'https://img.icons8.com/fluency/144/restaurant-building.png';
const imageUrl = ref(defaultImageUrl);
const description = ref('');
const avatar = ref(null);
const gallery = ref([]);
const showModal = ref(false);
const serverResponse = ref('');
const responseIsError = ref(false);

const isValidForm = computed(() => {
    return nameIsValid.value && imageIsValid.value;
});

const imageIsValid = computed(() => {
    return avatar.value !== null;
});

const nameIsValid = computed(() => {
    return name.value.trim() !== '';
});

const closeModal = () => {
    showModal.value = false;
};

const showResponseModal = () => {
    showModal.value = true;
};

const handleAvatarChange = (event) => {
    const selectedFile = event.target.files[0];
    avatar.value = selectedFile;
    if (selectedFile) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageUrl.value = e.target.result;
        };
        reader.readAsDataURL(selectedFile);
    }
};

const handleGalleryChange = (event) => {
    const selectedFiles = Array.from(event.target.files);
    gallery.value = selectedFiles;
};

const uploadData = async () => {
    console.log([name.value, avatar.value, description.value, gallery.value]);
    console.log(isValidForm.value);
    console.log([imageIsValid.value, nameIsValid.value]);
};

const redirectHome = () => {
    closeModal();
    window.location.href = `/login`;
};
</script>

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
    background-color: #FD4D79;
}

#profile_image:hover~#profile_image_overlay {
    opacity: 100;
}
</style>