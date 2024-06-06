<script setup>
import { ref } from 'vue';

const props = defineProps({
    closeModal: {
        type: Function,
        required: true
    }
});

const closeModal = () => {
    props.closeModal();
}

</script>

<template>
    <transition name="modal">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Carta
                            </h3>
                            <h3 class="text-md leading-6 font-medium text-gray-900" id="modal-title">
                                Type
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Name
                                </p>
                            </div>
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
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s;
}

.modal-enter,
.modal-leave-to {
    opacity: 0;
}
</style>