<script setup>
import { ref } from 'vue';

const props = defineProps({
    user: Object
});

const user = props.user;
const drawerNavigation = ref(false);
const logoUrl = '/images/logo.svg';

const toggleDrawer = () => {
    drawerNavigation.value = !drawerNavigation.value;
};

const handleMainClick = () => {
    if (drawerNavigation.value) {
        drawerNavigation.value = false;
    }
};

let formattedDate = null;

if (user) {
    const dateString = user.created_at;
    formattedDate = ref(formatDate(dateString));
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long' };
    return new Intl.DateTimeFormat('ca', options).format(date);
}

const pfp = user ? '/storage/' + user.avatar : null;
</script>

<template>
    <div class="flex flex-col w-full h-svh overflow-hidden textColor">
        <nav class="flex flex-row w-full items-center justify-between p-1 z-50 background border-b border-gray-400">

            <div class="w-1/3">
                <div class="flex justify-center w-10 align-center accent rounded">
                    <button class="w-10 h-10 relative" @click.prevent="toggleDrawer" aria-label="Sidebar">
                        <div class="block w-5 absolute left-4 transform -translate-x-1/2 -translate-y-1/2">
                            <span
                                class="block absolute h-0.5 w-7 bg-current transform transition duration-500 ease-in-out"
                                :class="{ 'rotate-45': drawerNavigation, ' -translate-y-1.5': !drawerNavigation }"></span>
                            <span
                                class="block absolute h-0.5 w-7 bg-current transform transition duration-500 ease-in-out"
                                :class="{ 'opacity-0': drawerNavigation }"></span>
                            <span
                                class="block absolute h-0.5 w-7 bg-current transform transition duration-500 ease-in-out"
                                :class="{ '-rotate-45': drawerNavigation, ' translate-y-1.5': !drawerNavigation }"></span>
                        </div>
                    </button>
                </div>
            </div>

            <div class="w-1/3">
                <a href="/" class="flex flex-row text justify-center align-center">
                    <img :src="logoUrl" class="h-10 mx-3" alt="Logo Forquilletes" />
                    <span class="text-xl font-semibold sm:text-2xl whitespace-nowrap">Forquilletes</span>
                </a>
            </div>

            <div class="flex justify-end w-1/3">
                <a v-if="!user" href="/login"
                    class="flex w-13 justify-center align-center accent rounded p-2 font-medium">
                    Entrar
                </a>
                <div v-if="user" id="avatarButton" type="button" data-dropdown-toggle="userDropdown"
                    data-dropdown-placement="bottom-start"
                    class="flex cursor-pointer hover:shadow-md lg:w-4/6 h-10 p-6 items-center gap-4">
                    <img class="w-9 h-9 rounded-full" :src="pfp" alt="">

                    <div class="hidden lg:flex lg:flex-col font-medium dark:text-white">
                        <div>{{ user.name }}</div>
                        <div class="text-sm">Es va unir al {{ formattedDate }}</div>
                    </div>
                </div>
                <div v-if="user" id="userDropdown"
                    class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-47 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div>{{ user.name }}</div>
                        <div class="font-medium truncate">{{ user.email }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="avatarButton">
                        <li>
                            <a href="/dashboard"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="/restaurant/create"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Afegir un restaurant</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Opcións</a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <a href="/logout"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tancar
                            sessió</a>
                    </div>
                </div>
            </div>

        </nav>

        <div class="flex flex-row w-full h-full relative background">
            <aside v-if="drawerNavigation"
                class="flex absolute text-lg flex-col h-full p-3 w-2/3 md:w-1/3 lg:w-1/6 z-50 secondary border-r border-gray-400">
                <a href="/" class="mb-2">Inici</a>
                <a href="/aboutUs">Sobre Nosaltres</a>
            </aside>

            <main class="w-full h-full overflow-auto" @click="handleMainClick">
                <slot :user="user"></slot>
                <div v-if="drawerNavigation" class="fixed inset-0 bg-black opacity-20 z-10"></div>
            </main>
        </div>

    </div>
</template>

<style scoped>
.svg-rotate {
    transition: transform 0.2s ease;
}

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
    background-color: #E1C4FF;
}

.accent {
    background-color: #E1C4FF;
}
</style>