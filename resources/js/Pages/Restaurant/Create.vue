<template>
    <Layout :user="user" class="flex flex-col w-full h-full ">
        <div class="flex flex-col items-center justify-center pt-0 w-full h-full p-3 overflow-y-auto">
            <div class="flex mt-80 md:mt-32 lg:mt-4 xl:mt-56">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-24 mt-96">
                    <h1 class="flex text-3xl justify-center items-center font-semibold p-3">Afegeix un nou restaurant
                    </h1>

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
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Descripció</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" v-model="description"
                                    placeholder="Escriu una petita descripció de la teva experiència."
                                    :class="{ 'shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !descriptionIsValid, 'shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': descriptionIsValid }">
                                </textarea>
                                <p v-if="!descriptionIsValid" class="text-red-600 text-xs italic">La descripció no és vàlida.
                                </p>
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

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-email">
                                Email
                            </label>
                            <input v-model="email" aria-label="Email"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-email" type="email" placeholder="Email">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-phone">
                                Número de telèfon
                            </label>
                            <input v-model="phone" aria-label="Número de telèfon"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-phone" type="phone" placeholder="Número de telèfon">
                        </div>
                    </div>

                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-website">
                                Pàgina web
                            </label>
                            <input v-model="website" aria-label="Pàgina web"
                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="grid-website" type="website" placeholder="Pàgina web">
                        </div>
                    </div>

                    <div class="flex flex-wrap h-64 -mx-3 mb-12">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-map">
                                Localització del restaurant
                            </label>
                            <MapInput class="appearance-none block w-full  rounded mb-3"
                                :update-value="updateMapValue" />
                            <p v-if="!addressIsValid" class="text-red-600 text-xs italic">El nom no és vàlid.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <input :disabled="!isValidForm"
                            :class="{ 'cursor-not-allowed': !isValidForm, 'cursor-pointer': isValidForm }" type="submit"
                            @click.prevent="uploadData"
                            class="font-semibold accent py-2 px-4 mr-5 rounded focus:outline-none focus:shadow-outline"
                            value="Crear restaurant">
                    </div>
                </form>
            </div>

            <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="bg-white rounded-lg shadow-xl p-8">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold" id="modal-title">Creació de restaurant</h3>
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
import MapInput from '@/Components/MapInput.vue';
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    user: Object
});

const user = ref(props.user);

const defaultImageUrl = 'https://img.icons8.com/fluency/144/restaurant-building.png';
const imageUrl = ref(defaultImageUrl);
const avatar = ref(null);
const gallery = ref([]);
const showModal = ref(false);
const name = ref('');
const description = ref('');
const email = ref('');
const phone = ref('');
const website = ref('');
const serverResponse = ref('');
const responseIsError = ref(false);
const mapValue = ref({ lat: 0, lng: 0, address: '' });

const updateMapValue = (newValue) => {
    mapValue.value = newValue;
};

const isValidForm = computed(() => {
    return nameIsValid.value && descriptionIsValid.value && imageIsValid.value && addressIsValid.value;
});

const imageIsValid = computed(() => {
    return avatar.value !== null;
});

const descriptionIsValid = computed(() => {
    return description.value.trim() !== '';
});

const addressIsValid = computed(() => {
    return mapValue.value.address.trim() !== '';
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
    try {
        const formData = new FormData();
        formData.append('name', name.value);
        formData.append('description', description.value);
        formData.append('email', email.value);
        formData.append('phone', phone.value);
        formData.append('website', website.value);
        formData.append('address', mapValue.value.address);
        formData.append('lat', mapValue.value.lat);
        formData.append('lng', mapValue.value.lng);

        formData.append('eventImg', avatar.value);

        gallery.value.forEach((file, index) => {
            formData.append(`gallery[${index}]`, file);
        });

        const response = await axios.post('/restaurant/create/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        showResponseModal();
        serverResponse.value = "Restaurant creat correctament.";
    } catch (error) {
        responseIsError.value = true;
        showResponseModal();
        serverResponse.value = "Hi ha hagut un problema. Si us plau, torna-ho a intentar més tard.";
    }
};

const redirectHome = () => {
    closeModal();
    window.location.href = `/dashboard`;
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
    background-color: #E1C4FF;
}

#profile_image:hover~#profile_image_overlay {
    opacity: 100;
}
</style>