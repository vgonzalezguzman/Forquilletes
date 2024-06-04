<template>
    <Layout class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center justify-center pt-0 w-full h-full p-3">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="flex items-center h-full w-full justify-center relative">
                        <div class="flex flex-col items-center justify-center relative w-40 h-40">
                            <input aria-label="Imatge del perfil" id="profile_image" type="file" accept="image/*"
                                @change="handleImageChange"
                                class="absolute rounded-full w-full h-full inset-0 opacity-0 cursor-pointer" />
                            <img class="w-full h-full border rounded-full object-cover" :src="imageUrl"
                                alt="User Avatar" />
                            <div id="profile_image_overlay"
                                class="absolute inset-0 pointer-events-none flex items-center justify-center bg-white bg-opacity-50 opacity-0 transition-opacity rounded-full">
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
                    <p v-if="file == null" class="text-red-600 text-xs italic">La imatge de perfil no és vàlida</p>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Nom
                        </label>
                        <input v-model="name"
                            :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !nameIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': nameIsValid }"
                            id="grid-first-name" type="text" placeholder="Pere Calders">
                        <p v-if="!nameIsValid" class="text-red-600 text-xs italic">El nom no és vàlid.</p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-email">
                            Correu
                        </label>
                        <input v-model="email"
                            :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !emailIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': emailIsValid }"
                            id="grid-email" type="text" placeholder="exemple@exemple.com">
                        <p v-if="!emailIsValid" class="text-red-600 text-xs italic">El correu no és vàlid.</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-password">
                            Contrassenya
                        </label>
                        <input v-model="password"
                            :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !passwordIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': passwordIsValid }"
                            id="grid-password" type="password" placeholder="******************">
                        <p v-if="!passwordIsValid" class="text-red-600 text-xs italic">La contrasenya ha de tenir
                            almenys 8 caràcters.</p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-password-confirmation">
                            Confirma la contrassenya
                        </label>
                        <input v-model="passwordConfirmation"
                            :class="{ 'appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white': !passwordConfirmationIsValid, 'appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500': passwordConfirmationIsValid }"
                            id="grid-password-confirmation" type="password" placeholder="******************">
                        <p v-if="!passwordConfirmationIsValid" class="text-red-600 text-xs italic">Les contrasenyes han
                            de ser les mateixes.</p>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <input :disabled="!isValidForm"
                        :class="{ 'cursor-not-allowed': !isValidForm, 'cursor-pointer': isValidForm }" type="submit"
                        @click.prevent="uploadData"
                        class="font-semibold accent py-2 px-4 mr-5 rounded focus:outline-none focus:shadow-outline"
                        value="Resgistra't">
                    <a class="inline-block align-baseline font-semibold text-sm pl-2 ml-5" href="/login">
                        Ja tens un compte? Entra
                    </a>
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

const props = defineProps({
    lockedEmails: Object
});

const lockedEmails = ref(props.lockedEmails);

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const defaultImageUrl = 'https://img.icons8.com/ios-glyphs/120/user--v1.png';
const imageUrl = ref(defaultImageUrl);
const file = ref(null);
const showModal = ref(false);
const serverResponse = ref('');
const responseIsError = ref(false);

const isValidForm = computed(() => {
    return nameIsValid.value && emailIsValid.value && passwordIsValid.value && passwordConfirmationIsValid.value && file.value;
});

const nameIsValid = computed(() => {
    return name.value.trim() !== '';
});
const emailIsValid = computed(() => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailRegex.test(email.value)) {
        return !lockedEmails.value.includes(email.value);
    }
});

const passwordIsValid = computed(() => {
    return password.value.length >= 8;
});
const passwordConfirmationIsValid = computed(() => {
    return password.value === passwordConfirmation.value;
});

const closeModal = () => {
    showModal.value = false;
};

const showResponseModal = () => {
    showModal.value = true;
};

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

const uploadData = async () => {
    try {
        const formData = new FormData();
        formData.append('name', name.value);
        formData.append('email', email.value);
        formData.append('password', password.value);
        formData.append('password_confirmation', passwordConfirmation.value);

        formData.append('profileImg', file.value);

        const response = await axios.post('/register/send', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        showResponseModal();
        serverResponse.value = "L'usuari s'ha creat correctament.";
    } catch (error) {
        responseIsError.value = true;
        showResponseModal();
        serverResponse.value = "Hi ha hagut un problema. Si us plau, torna-ho a intentar més tard.";
    }
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
    background-color: #E1C4FF;
}

#profile_image:hover~#profile_image_overlay {
    opacity: 100;
}
</style>
