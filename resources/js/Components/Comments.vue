<script setup>
import ImageGallery from '@/Components/ImageGallery.vue';
import EditComment from '@/Components/EditComment.vue';
import AddComment from '@/Components/AddComment.vue';
import { ref } from 'vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    comments: {
        type: [Array, Object],
        required: true
    },
    restaurantId: {
        type: Number,
        required: true
    },
    closeModal: {
        type: Function,
        required: true
    }
});

const addCommentModal = ref(false);
const editModal = ref(false);
const commentToEdit = ref([]);

const openEditModal = (comment) => {
    commentToEdit.value = comment;
    editModal.value = true;
}

const closeEditCommentModal = () => {
    commentToEdit.value = [];
    editModal.value = false;
}

const closeModal = () => {
    props.closeModal();
}

const addComment = () => {
    addCommentModal.value = true;
}

const closeCommentModal = () => {
    addCommentModal.value = false;
}

const comments = ref(props.comments);

const rId = ref(props.restaurantId);

function functionFormatUrl(url) {
    return '/storage/' + url;
}
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Intl.DateTimeFormat('ca', options).format(date);
}

const deleteCommentModal = ref(false);
const commentToDelete = ref('');

const showDeleteModal = (id) => {
    deleteCommentModal.value = true;
    commentToDelete.value = id;
};

const closeDeleteModal = () => {
    deleteCommentModal.value = false;
    commentToDelete.value = '';
}

const deleteComment = async () => {
    try {
        const formData = new FormData();
        formData.append('commentId', commentToDelete.value);

        const response = await axios.post('/restaurant/comment/delete', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        window.location.href = '/restaurant/show/' + rId.value;
        console.log(response);
    } catch (error) {
        deleteCommentModal.value = true;
        console.error(error);
    }
};
</script>

<template>
    <transition name="modal">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="flex items-center justify-center w-full h-full">
                <div
                    class="bg-white rounded-lg w-full h-5/6 overflow-auto shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-4">
                        <div class="sm:flex w-full sm:items-start">
                            <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                                <div class="flex justify-center w-full items-center">
                                    <h3 class="flex text-xl justify-center items-center w-2/6 leading-6 font-medium text-gray-900"
                                        id="modal-title">
                                        Opinions
                                    </h3>
                                    <div
                                        class="flex justify-center items-center px-4 py-3 w-2/6 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button @click="addComment" type="button" v-if="user"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                                            +
                                        </button>
                                    </div>
                                    <div
                                        class="flex justify-center items-center px-4 py-3 w-2/6 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button @click="closeModal" type="button"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                                            Tancar
                                        </button>
                                    </div>
                                </div>
                                <div v-if="comments.length > 0" v-for="comment in comments" :key="comment.id"
                                    class="mt-3 p-3 shadow">
                                    <div class="flex w-full m-2">
                                        <div class="w-1/6">
                                            <img class="w-10 h-10 rounded-full mr-3"
                                                :src="functionFormatUrl(comment.user.avatar)" alt="">
                                        </div>
                                        <div class="flex w-3/6 flex-col">
                                            <p class="text-sm">
                                                {{ comment.user.name }}
                                            </p>
                                            <p class="text-sm">
                                                {{ comment.user.email }}
                                            </p>
                                        </div>
                                        <div class="flex w-2/6" v-if="user">
                                            <button @click="openEditModal(comment)" type="button" v-if="user.id == comment.user.id"
                                                class="mt-3 inline-flex justify-center w-1/2 rounded-md border m-1 border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                                                Editar
                                            </button>
                                            <button @click="showDeleteModal(comment.id)" type="button" v-if="user.id == comment.user.id"
                                                class="mt-3 inline-flex justify-center w-1/2 rounded-md border m-1 border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium sm:mt-0 sm:w-auto sm:text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="h-6 w-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-lg">
                                        {{ comment.title }}
                                    </p>
                                    <p class="text-md">
                                        {{ comment.description }}
                                    </p>
                                    <div class="flex items-center">
                                        <span class="text-md pr-3">Valoració:</span>
                                        <template v-for="i in 5" :key="i">
                                            <label :for="'star' + i" class="text-gray-400"
                                                :class="{ 'text-yellow-400': i <= comment.rating }">
                                                ★
                                            </label>
                                        </template>
                                    </div>
                                    <ImageGallery v-if="comment.images.length > 0" :gallery="comment.images"
                                        class="py-3"></ImageGallery>
                                </div>
                                <div class="flex flex-col w-full justify-center items-center p-5" v-else>
                                    <h3 class="text-xl justify-center items-center leading-6 font-medium text-gray-900"
                                        id="modal-title">
                                        Sembla que encara no hi ha opinions!
                                    </h3>
                                    <h3 class="text-md justify-center items-center leading-6 font-medium text-gray-900"
                                        id="modal-title">
                                        Sigues el primer en pujar una opinió!
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    <transition name="modal">
        <div v-if="deleteCommentModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Eliminar comentari
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Vols eliminar aquest comentari?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="deleteComment" type="button"
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
    <AddComment v-if="addCommentModal" :restaurantId="rId" :closeCommentModal="closeCommentModal" v-bind="$attrs">
    </AddComment>
    <EditComment v-if="editModal" :comment="commentToEdit" :closeEditCommentModal="closeEditCommentModal"
        v-bind="$attrs">
    </EditComment>
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
