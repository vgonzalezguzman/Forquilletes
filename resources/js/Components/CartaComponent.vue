<script setup>
import { ref } from 'vue';
import CreatePlat from '@/Components/CreatePlat.vue';
import EditPlat from '@/Components/EditPlat.vue';

const props = defineProps({
    closeModal: {
        type: Function,
        required: true
    },
    restaurantId: {
        type: Number,
        required: true
    },
    types: {
        type: Object,
        required: true
    },
    plats: {
        type: Object,
        required: true
    },
});

const closeModal = () => {
    props.closeModal();
}
const rId = ref(props.restaurantId);
const types = ref(props.types);
const plats = ref(props.plats);

const isCreatePlatVisible = ref(false);

const showCreatePlat = () => {
    isCreatePlatVisible.value = true;
}

const hideCreatePlat = () => {
    isCreatePlatVisible.value = false;
}

const isEditVisible = ref(false);

const platToEdit = ref('');

const showEdit = (plat) => {
    platToEdit.value = plat;
    isEditVisible.value=true;
}

const hideEdit = (plat) => {
    platToEdit.value = plat;
    isEditVisible.value=false;
}

</script>

<template>
    <transition name="modal">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">

                    <div class="sm:flex sm:items-start">
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="flex flex-row w-full">
                                <h3 class="text-lg w-2/3 leading-6 font-medium text-gray-900" id="modal-title">
                                    Carta
                                </h3>
                                <div
                                    class="flex justify-center items-center px-4 py-3 w-1/3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" @click.prenvent="showCreatePlat()"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                                        Afegir plat
                                    </button>
                                </div>
                                <button @click.prevent="closeModal()" class="absolute top-0 right-0"
                                    aria-label="Tencar galeria">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-6 w-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <h3 class="text-md leading-6 font-medium text-gray-900" id="modal-title">
                                Type
                            </h3>
                            <div class="flex flex-col mt-2" v-for="plat in plats" :key="index">
                                <div v-if="plat.tId == 1" class="flex flex-row text-sm text-gray-500">
                                    <p class="w-1/3">Primers</p>
                                    <p class="w-1/6">{{ plat.name }}</p>
                                    <p class="w-1/6">{{ plat.price }} €</p> <button class="w-1/3"
                                        @click.prevent="showEdit(plat)">Editar</button>
                                </div>
                                <div v-if="plat.tId == 2" class="flex flex-row text-sm text-gray-500">
                                    <p class="w-1/3">Segons</p>
                                    <p class="w-1/3">{{ plat.name }}</p>
                                    <p class="w-1/6">{{ plat.price }} €</p><button class="w-1/3"
                                        @click.prevent="showEdit(plat)">Editar</button>
                                </div>
                                <div v-if="plat.tId == 3" class="flex flex-row text-sm text-gray-500">
                                    <p class="w-1/3">Postres</p>
                                    <p class="w-1/3">{{ plat.name }}</p>
                                    <p class="w-1/6">{{ plat.price }} €</p><button class="w-1/3"
                                        @click.prevent="showEdit(plat)">Editar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </transition>
    <EditPlat v-if="isEditVisible" :platToEdit="platToEdit" :closeModal="hideEdit" :rId="rId" :types="types"></EditPlat>
    <CreatePlat v-if="isCreatePlatVisible" :closeModal="hideCreatePlat" :rId="rId" :types="types"></CreatePlat>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}

.modal-enter,
.modal-leave-to {
    opacity: 0;
}
</style>