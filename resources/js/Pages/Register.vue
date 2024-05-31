<template>
    <Layout class="flex flex-col w-full h-full">
        <div class="flex flex-col items-center justify-center pt-0 w-full h-full p-3">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-first-name">
                            Nom
                        </label>
                        <input v-model="name"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-first-name" type="text" placeholder="Pere Calders">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-email">
                            Correu
                        </label>
                        <input v-model="email"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-email" type="text" placeholder="exemple@exemple.com">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-password">
                            Contrassenya
                        </label>
                        <input v-model="password"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-password" type="password" placeholder="******************">
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <input type="submit" @click.prevent="register"
                        class="font-semibold cursor-pointer accent py-2 px-4 mr-5 rounded focus:outline-none focus:shadow-outline"
                        value="Resgistra't">
                    <a class="inline-block align-baseline font-semibold text-sm pl-2 ml-5" href="/login">
                        Ja tens un compte? Entra
                    </a>
                </div>
            </form>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import { ref } from 'vue';

const name = ref('');
const email = ref('');
const password = ref('');
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
    background-color: #FD4D79;
}
</style>