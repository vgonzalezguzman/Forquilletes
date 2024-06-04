<template>
    <Layout class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center justify-center pt-0 w-full h-full p-3">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Usuari
                    </label>
                    <input v-model="email" aria-label="Email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="text" placeholder="Email">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Contassenya
                    </label>
                    <input v-model="password" aria-label="Contrasenya"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password" type="password" placeholder="******************">

                </div>
                <div class="flex items-center justify-between">
                    <input type="submit" @click.prevent="logIn"
                        class="font-semibold cursor-pointer accent py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        value="Entrar">
                    <a class="inline-block align-baseline font-semibold text-sm pl-2" href="/register">
                        No tens un compte? <br> Registra't
                    </a>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import { ref } from 'vue';

const email = ref('');
const password = ref('');

const logIn = async () => {
    try {
        const formData = new FormData();
        formData.append('email', email.value);
        formData.append('password', password.value);

        const response = await axios.post('/login/send', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        console.log(response.data);
        window.location.href = `/dashboard`;
    } catch (error) {
        console.error(error);
    }
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
</style>