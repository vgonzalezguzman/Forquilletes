<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    closeModal: {
        type: Function,
        required: true
    },
    rId: {
        type: Number,
        required: true
    },
    types: {
        type: Object,
        required: true
    },
});

const closeModal = () => {
    props.closeModal();
}
const rId = ref(props.rId);
const types = ref(props.types);

const title = ref('');
const price = ref('');
const selectedType = ref('Primers');

const isValidForm = ref(true);
const nameIsValid = ref(true);
const priceIsValid = ref(true);


const uploadPlat = async () => {
    try {
        const formData = new FormData();
        formData.append('rId', rId.value);
        formData.append('title', title.value);
        formData.append('price', price.value);
        formData.append('type', selectedType.value);

        const response = await axios.post('/plats/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        window.location.href = `/restaurant/show/${props.rId}`;
        console.log(response);
    } catch (error) {
        console.log('error');
        console.error(error);
    }
};

</script>

<template>
    <transition name="modal">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <form class="w-full">
                                <h3 class="text-lg w-2/3 leading-6 font-medium text-gray-900" id="modal-title">
                                    Afegeix un plat
                                </h3>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-title">
                                        Posa-li un nom al plat
                                    </label>
                                    <input v-model="title"
                                        :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !nameIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': nameIsValid }"
                                        id="grid-title" type="text" placeholder="Truita de patates">
                                    <p v-if="!nameIsValid" class="text-red-600 text-xs italic">El nom no és vàlid.
                                    </p>
                                </div>
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-price">
                                        Introdueix un preu
                                    </label>
                                    <input v-model="price"
                                        :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !priceIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': priceIsValid }"
                                        id="grid-price" type="number" placeholder="18,00">
                                    <p v-if="!priceIsValid" class="text-red-600 text-xs italic">El preu no és vàlid.
                                    </p>
                                </div>
                                <div class="w-full px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-state">
                                        Tipus de plat
                                    </label>
                                    <div class="relative">
                                        <select v-model="selectedType"
                                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="grid-state">
                                            <option v-for="type in types">{{type.type}}</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex w-full justify-end px-3">
                                    <input :disabled="!isValidForm"
                                        :class="{ 'cursor-not-allowed': !isValidForm, 'cursor-pointer': isValidForm }"
                                        type="submit" @click.prevent="uploadPlat"
                                        class="font-semibold accent py-2 px-4 mr-5 rounded focus:outline-none focus:shadow-outline"
                                        value="Pujar Plat">
                                    <button @click="closeModal" type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                                        Tancar
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                    <button @click.prevent="closeModal()" class="absolute top-0 right-0" aria-label="Tencar galeria">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
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

.modal-enter,
.modal-leave-to {
    opacity: 0;
}
</style>