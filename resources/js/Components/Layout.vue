<script setup>
import { ref } from 'vue';

const drawerNavigation = ref(false);

const logoUrl = '/storage/images/logo.svg';

const toggleDrawer = () => {
    drawerNavigation.value = !drawerNavigation.value;
};

const handleMainClick = () => {
    if (drawerNavigation.value) {
        drawerNavigation.value = false;
    }
};
</script>

<template>
    <div class="flex flex-col w-full h-svh overflow-hidden textColor">
        <nav class="flex flex-row w-full items-center justify-between p-3 z-50 background border-b border-gray-400">

            <div class="flex justify-center align-center accent rounded">
                <button class="w-10 h-10 relative" @click.prevent="toggleDrawer">
                    <div class="block w-5 absolute left-4 transform -translate-x-1/2 -translate-y-1/2">
                        <span class="block absolute h-0.5 w-7 bg-current transform transition duration-500 ease-in-out"
                            :class="{ 'rotate-45': drawerNavigation, ' -translate-y-1.5': !drawerNavigation }"></span>
                        <span class="block absolute h-0.5 w-7 bg-current transform transition duration-500 ease-in-out"
                            :class="{ 'opacity-0': drawerNavigation }"></span>
                        <span class="block absolute h-0.5 w-7 bg-current transform transition duration-500 ease-in-out"
                            :class="{ '-rotate-45': drawerNavigation, ' translate-y-1.5': !drawerNavigation }"></span>
                    </div>
                </button>
            </div>

            <a href="/" class="flex">
                <img :src="logoUrl" class="h-10 mx-3" alt="Logo Forquilletes" />
                <span class="text-xl font-semibold sm:text-2xl whitespace-nowrap">Forquilletes</span>
            </a>

            <a href="/login" class="flex justify-center align-center accent rounded p-2 font-medium">
                Entrar
            </a>
        </nav>

        <div class="flex flex-row w-full h-full relative background">
            <aside v-if="drawerNavigation" class="flex flex-col h-full p-3 w-2/3 md:w-1/3 lg:w-1/6 z-50 secondary border-r border-gray-400">
                <a href="/" class="mb-2">Inici</a>
                <a href="/aboutUs">Sobre Nosaltres</a>
            </aside>

            <main class="w-full h-full" @click="handleMainClick">
                <slot></slot>
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
    background-color: #FD72BB;
} 

.accent {
    background-color: #FD4D79;
}
</style>