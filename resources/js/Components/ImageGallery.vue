<template>
  <div class="grid gap-4">
    <div class="relative">
      <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        <div class="relative h-full">
          <template v-for="(image, index) in images" :key="index">
            <div v-if="index === activeIndex" class="absolute inset-0 flex items-center justify-center">
              <img :src="functionFormatUrl(image.url)"
                class="absolute block w-full h-full transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                alt="">
            </div>
          </template>
        </div>
        <button @click="prevImage" aria-label="Imatge previa"
          class="absolute top-1/2 left-0 z-30 flex items-center justify-center h-12 w-12 -translate-y-1/2 bg-black bg-opacity-50 rounded-full text-white focus:outline-none hover:bg-opacity-75">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button @click="nextImage" aria-label="Imatge següent"
          class="absolute top-1/2 right-0 z-30 flex items-center justify-center h-12 w-12 -translate-y-1/2 bg-black bg-opacity-50 rounded-full text-white focus:outline-none hover:bg-opacity-75">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>

      <div class="grid grid-cols-5 gap-4 mt-4">
        <template v-for="(image, index) in visibleImages" :key="index">
          <div @click="changeImage(index)" class="cursor-pointer">
            <img :src="functionFormatUrl(image.url)" class="w-full h-24 object-cover rounded-lg" alt="">
          </div>
        </template>
      </div>

      <div class="flex justify-center mt-4">
        <button v-if="images.length > 5 && !expanded" @click="expandImages"
          class="px-6 py-2 rounded-full shadow-md hover:bg-gray-300 focus:outline-none transition duration-300">
          Veure més
        </button>
        <button v-else-if="expanded" @click="retractImages"
          class="px-6 py-2 rounded-full shadow-md hover:bg-gray-300 focus:outline-none transition duration-300">
          Veure menys
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  gallery: {
    type: [Array, Object],
    required: true
  }
});

const images = ref(props.gallery);
const activeIndex = ref(0);
const expanded = ref(false);

const visibleImages = computed(() => {
  if (expanded.value) {
    return images.value;
  }
  return images.value.slice(0, 5);
});

function nextImage() {
  activeIndex.value = (activeIndex.value + 1) % images.value.length;
}

function prevImage() {
  activeIndex.value = (activeIndex.value - 1 + images.value.length) % images.value.length;
}

function changeImage(index) {
  activeIndex.value = index;
}

function functionFormatUrl(url) {
  return '/storage/' + url;
}

function expandImages() {
  expanded.value = true;
}

function retractImages() {
  expanded.value = false;
}
</script>
