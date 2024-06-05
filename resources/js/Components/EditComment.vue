<script setup>
import GalleryInput from '@/Components/GalleryInput.vue';
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    comment: Object,
    closeEditCommentModal: {
        type: Function,
        required: true
    }
});

const comment = ref(props.comment);

const gallery = ref(comment.value.images);
const responseIsError = ref(false);
const isGalleryModalVisible = ref(false);
const imageToDelete = ref([]);

const confirmDelete = (index) => {
    if (index >= 0 && index < gallery.value.length) {
        const imageId = gallery.value[index].id;
        imageToDelete.value.push(imageId);
        gallery.value.splice(index, 1);
    } else {
        console.error(`Invalid index: ${index}`);
    }
};

const showGalleryModal = () => {
    isGalleryModalVisible.value = true;
};

const closeGalleryModal = () => {
    isGalleryModalVisible.value = false;
};

const title = ref(comment.value.title);
const description = ref(comment.value.description);
const rating = ref(comment.value.rating);

const galleryToUpload = ref([]);

const handleGalleryChange = (event) => {
    const selectedFiles = Array.from(event.target.files);
    galleryToUpload.value = selectedFiles;
};

const updateComment = async () => {
    try {
        const formData = new FormData();
        formData.append('cId', comment.value.id);
        formData.append('title', title.value);
        formData.append('description', description.value);
        formData.append('rating', rating.value);

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

        const response = await axios.post('/restaurant/comment/update', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        openResultModal();
        console.log(response);
    } catch (error) {
        openErrorModal();
        console.error(error);
    }
};

const closeEditCommentModal = () => {
    props.closeEditCommentModal();
}

const isValidForm = computed(() => {
    return titleIsValid.value && descriptionIsValid.value && ratingIsValid.value;
});

const titleIsValid = computed(() => {
    return title.value !== '';
});

const descriptionIsValid = computed(() => {
    return description.value.trim() !== '';
});

const ratingIsValid = computed(() => {
    return rating.value > 0;
});

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
    window.location.href = `/restaurant/show/${comment.value.restaurant_id}`;
};
</script>

<template>
    <transition name="modal">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50 overflow-auto"
            v-bind="$attrs">
            <div
                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full m-2">
                <div class="bg-white p-4">
                    <form>
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                for="grid-title">
                                Títol breu per a resumir la teva expieriència
                            </label>
                            <input v-model="title"
                                :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !titleIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': titleIsValid }"
                                id="grid-title" type="text" placeholder="El Gran Sol">
                            <p v-if="!titleIsValid" class="text-red-600 text-xs italic">El títol no és vàlid.</p>
                        </div>
                        <div class="w-full px-3">
                            <label for="description"
                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Descripció</label>
                            <div class="mt-2">
                                <textarea id="description" name="description" rows="3" v-model="description"
                                    placeholder="Escriu una petita descripció de la teva experiència."
                                    :class="{ 'shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !descriptionIsValid, 'shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': descriptionIsValid }">
                                </textarea>
                                <p v-if="!descriptionIsValid" class="text-red-600 text-xs italic">La descripció no és
                                    vàlida.
                                </p>
                            </div>
                        </div>
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold" for="rating">
                                Valoració
                            </label>
                            <div class="flex space-x-2">
                                <template v-for="i in 5">
                                    <input type="radio" :id="'star' + i" :value="i" v-model="rating" class="hidden" />
                                    <label :for="'star' + i" class="cursor-pointer aria-inactive-star-element"
                                        :class="{ 'aria-star-element': i <= rating }">
                                        ★
                                    </label>
                                </template>
                            </div>
                            <p v-if="!ratingIsValid" class="text-red-600 text-xs italic">La Valoració no és vàlid.</p>
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

                        <div class="flex items-center m-3 justify-center">
                            <button @click.prevent="showGalleryModal"
                                class="font-semibold accent py-2 px-4 w-2/3 lg:w-1/3 rounded focus:outline-none focus:shadow-outline">Obrir
                                galeria</button>
                        </div>

                        <div class="flex w-full justify-end px-3">
                            <input :disabled="!isValidForm"
                                :class="{ 'cursor-not-allowed': !isValidForm, 'cursor-pointer': isValidForm }"
                                type="submit" @click.prevent="updateComment"
                                class="font-semibold accent py-2 px-4 mr-5 rounded focus:outline-none focus:shadow-outline"
                                value="Guardar">
                            <button @click="closeEditCommentModal" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm accent-button">
                                Tancar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>

    <GalleryInput :images="gallery" v-if="isGalleryModalVisible" :closeModal="closeGalleryModal"
        :confirmDelete="confirmDelete" />

    <transition name="modal">
        <div v-if="isErrorModalVisible"
            class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Error
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    El comentari no s'ha pogut modificar.
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
        <div v-if="isResultModalVisible"
            class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Comentari modificat
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Comentari modificat correctament.
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

#profile_image:hover~#profile_image_overlay {
    opacity: 100;
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}

.aria-inactive-star-element {
    color: #707783;
}

.aria-star-element {
    color: #9e6d00;
}

.modal-enter,
.modal-leave-to {
    opacity: 0;
}

input[type="radio"]:checked+label {
    color: #9e6d00;
    /* Tailwind's yellow-400 color */
}
</style>
