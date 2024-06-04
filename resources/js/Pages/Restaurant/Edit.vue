<template>
    <Layout :user="user" class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center justify-center pt-0 w-full h-full p-3 overflow-y-auto">
            <div class="flex w-full justify-center items-center mt-80 md:mt-32 lg:mt-4 xl:mt-1 2xl:mt-56">
                <form class="bg-white shadow-md w-full md:5/6 lg:w-1/3 rounded px-8 pt-6 pb-8 mb-24 mt-80">
                    <h1 class="flex text-3xl justify-center items-center font-semibold p-3">Editar restaurant</h1>

                    <div class="flex flex-col -mx-3 mb-6">
                        <div class="flex flex-col -mx-3 mb-6">
                            <div class="flex items-center h-full w-full justify-center relative">
                                <div class="flex flex-col items-center justify-center relative w-full h-40">
                                    <input aria-label="Imatge del perfil" id="profile_image" type="file"
                                        accept="image/*" @change="handleAvatarChange"
                                        class="absolute w-full h-full inset-0 opacity-0 cursor-pointer" />
                                    <img class="w-full h-full border object-contain" :src="imageUrl"
                                        alt="User Avatar" />
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

                        <div class="w-full px-3">
                            <label for="description"
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Descripció</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" v-model="description"
                                    placeholder="Escriu una petita descripció del restaurant."
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
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
                            <button @click.prevent="showGalleryModal"
                                class="font-semibold accent py-2 px-4 w-2/3 lg:w-1/3 rounded focus:outline-none focus:shadow-outline">Obrir
                                galeria</button>
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

                        <div class="w-full px-3 h-64 mb-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-map">
                                Localització del restaurant
                            </label>
                            <MapInput class="appearance-none block w-full  rounded mb-3" :value="mapValue"
                                :update-value="updateMapValue" />
                            <p v-if="!addressIsValid" class="text-red-600 text-xs italic">El nom no és vàlid.</p>
                        </div>

                    </div>
                    <div class="flex items-center justify-center">
                        <input :disabled="!isValidForm"
                            :class="{ 'cursor-not-allowed': !isValidForm, 'cursor-pointer': isValidForm }" type="submit"
                            @click.prevent="showModifyModal"
                            class="font-semibold accent py-2 px-4 mr-5 w-1/3 rounded focus:outline-none focus:shadow-outline"
                            value="Actualitzar">
                        <input type="submit"
                            @click.prevent="showDeleteModal"
                            class="font-semibold cursor-pointer bg-red-500 py-2 px-4 w-1/3 mr-5 rounded focus:outline-none focus:shadow-outline"
                            value="Eliminar">
                    </div>
                </form>
            </div>
        </div>

        <GalleryInput v-if="isGalleryModalVisible" :images="gallery" :confirmDelete="confirmDelete" :closeModal="closeGalleryModal"></GalleryInput>

        <transition name="modal">
            <div v-if="isModalVisible"
                class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Modificar restaurant
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Vols modificar aquest restaurant?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="uploadData" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 accent text-base font-medium sm:ml-3 sm:w-auto sm:text-sm">
                            Modificar
                        </button>
                        <button @click="cancelUpdate" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel·lar
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="modal">
            <div v-if="isResultModalVisible"
                class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Restaurant modificat
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Restaurant modificat correctament.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeResultModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                            Tancar
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="modal">
            <div v-if="isErrorModalVisible"
                class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Error
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        El restaurant no s'ha pogut modificar.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeErrorModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                            Tancar
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="modal">
            <div v-if="deleteRestaurantModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Eliminar restaurant
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Vols eliminar aquest restaurant?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="deleteRestaurant" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 accent text-base font-medium sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button @click="closeDeleteModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel·lar
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="modal">
            <div v-if="deleteRestaurantModalError"
                class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Error
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        No s'ha pogut eliminar el restaurant.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeDeleteModalError" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                            Tancar
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import MapInput from '../../Components/MapInput.vue';
import GalleryInput from '../../Components/GalleryInput.vue';
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    user: Object,
    restaurant: Object,
    gallery: Array,
});

const deleteRestaurantModal = ref(false);

const showDeleteModal = () => {
    deleteRestaurantModal.value = true;
};

const closeDeleteModal = () => {
    deleteRestaurantModal.value = false;
}

const deleteRestaurant = async () => {
    try {
        const formData = new FormData();
        formData.append('restaurant', restaurant.value.id);
        formData.append('uploader', restaurant.value.uploader);
        formData.append('owner', restaurant.value.owner);

        const response = await axios.post('/restaurant/delete', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        closeDeleteModal();
        window.location.href = '/dashboard';
        console.log(response);
    } catch (error) {
        deleteRestaurantModalError.value = true;
        console.error(error);
    }
};

const deleteRestaurantModalError = ref(false);

const closeDeleteModalError = () => {
    deleteRestaurantModalError.value = false;
};

const user = ref(props.user);
const restaurant = ref(props.restaurant);
const gallery = ref(props.gallery);

const defaultImageUrl = ref(functionFormatUrl(restaurant.value.avatar));
const imageUrl = ref(defaultImageUrl);
const avatar = ref(null);
const name = ref(restaurant.value.name);
const email = ref(restaurant.value.email);
const phone = ref(restaurant.value.phone);
const website = ref(restaurant.value.website);

const description = ref(restaurant.value.description);
const galleryToUpload = ref([]);

const handleGalleryChange = (event) => {
    const selectedFiles = Array.from(event.target.files);
    galleryToUpload.value = selectedFiles;
};

const mapValue = ref({ lat: restaurant.value.lat, lng: restaurant.value.lng, address: restaurant.value.address });

const updateMapValue = (newValue) => {
    mapValue.value = newValue;
};

const isValidForm = computed(() => {
    return nameIsValid.value && addressIsValid.value;
});


const addressIsValid = computed(() => {
    return mapValue.value.address.trim() !== '';
});

const nameIsValid = computed(() => {
    return name.value.trim() !== '';
});

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

function functionFormatUrl(url) {
    return '/storage/' + url;
}

const uploadData = async () => {
    try {
        const formData = new FormData();
        formData.append('oldId', restaurant.value.id);
        formData.append('uploader', restaurant.value.uploader);
        formData.append('owner', restaurant.value.owner);
        formData.append('oldAvatar', restaurant.value.avatar);
        formData.append('eventImg', avatar.value);
        formData.append('name', name.value);
        formData.append('description', description.value);
        formData.append('email', email.value);
        formData.append('phone', phone.value);
        formData.append('website', website.value);
        formData.append('address', mapValue.value.address);
        formData.append('lat', mapValue.value.lat);
        formData.append('lng', mapValue.value.lng);

        if (imageToDelete.value) {
            imageToDelete.value.forEach((file, index) => {
                formData.append(`imageToDelete[${index}]`, file);
            });
        }

        if (galleryToUpload.value) {
            galleryToUpload.value.forEach((file, index) => {
                formData.append(`galleryToUpload[${index}]`, file);
            });
        }

        const response = await axios.post('/restaurant/update', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        closeModifyModal();
        openResultModal();
        console.log(response);
    } catch (error) {
        openErrorModal()
        console.error(error);
    }
};

const isGalleryModalVisible = ref(false);
const isModalVisible = ref(false);
const imageToDelete = ref([]);

const showGalleryModal = (index) => {
    isGalleryModalVisible.value = true;
};

const closeGalleryModal = () => {
    isGalleryModalVisible.value = false;
};

const confirmDelete = (index) => {
    const imageId = gallery.value[index].id;
    imageToDelete.value.push(imageId);
    gallery.value.splice(index, 1);
};

const isErrorModalVisible = ref(false);

const openErrorModal = () => {
    isErrorModalVisible.value = true;
};

const closeErrorModal = () => {
    isErrorModalVisible.value = false;
};

const isResultModalVisible = ref(false);

const openResultModal = () => {
    isResultModalVisible.value = true;
};

const closeResultModal = () => {
    isResultModalVisible.value = false;
    window.location.href = `/restaurant/show/${restaurant.value.id}`;
};

const showModifyModal = () => {
    isModalVisible.value = true;
};

const cancelUpdate = () => {
    imageToDelete.value = null;
    isModalVisible.value = false;
};

const closeModifyModal = () => {
    isModalVisible.value = false;
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

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}

.modal-enter,
.modal-leave-to

/* .modal-leave-active in <2.1.8 */
    {
    opacity: 0;
}
</style>
