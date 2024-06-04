<script setup>
import { ref } from 'vue';

const props = defineProps({
    images: {
        type: [Array, Object],
        required: true
    },
    closeModal: {
        type: Function,
        required: true
    },
    confirmDelete: {
        type: Function,
        required: true
    }
});

const confirmDelete = (index) => {
    props.confirmDelete(index);
}

const closeModal = () => {
    props.closeModal();
}

const gallery = ref(props.images);

function functionFormatUrl(url) {
    return '/storage/' + url;
}
</script>
<template>
    <transition name="modal">
        <div
            class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
            <div
                class="bg-white rounded-lg m-3 p-3 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 mt-4">
                    <div class="relative w-full px-3" v-for="(image, index) in gallery" :key="image.id">
                        <label for="description"
                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"></label>
                        <img :src="functionFormatUrl(image.url)" class="w-full h-24 object-cover rounded-lg" alt="">
                        <button @click.prevent="confirmDelete(index)" aria-label="Borrar imatge"
                            class="absolute top-0 right-0 p-2 bg-red-500 text-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
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
.modal-leave-to

/* .modal-leave-active in <2.1.8 */
    {
    opacity: 0;
}
</style>