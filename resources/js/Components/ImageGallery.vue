<template>
<div class="grid gap-4">
    <!-- Carousel with Thumbnails -->
    <div class="relative">
      <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
        <!-- Carousel wrapper -->
        <div class="relative h-full">
          <template v-for="(image, index) in images" :key="index">
            <div v-if="index === activeIndex" class="absolute inset-0 flex items-center justify-center">
              <img :src="image.src" class="absolute block max-w-full h-auto transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
            </div>
          </template>
        </div>
        <!-- Slider controls -->
        <button @click="prevImage" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none">
          <!-- Previous button icon -->
        </button>
        <button @click="nextImage" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer focus:outline-none">
          <!-- Next button icon -->
        </button>
      </div>
      
      <!-- Thumbnails -->
      <div class="grid grid-cols-5 gap-4 mt-4">
        <template v-for="(image, index) in images" :key="index">
          <div @click="changeImage(index)" class="cursor-pointer">
            <img :src="image.src" class="h-auto max-w-full rounded-lg" alt="">
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';

import { ref } from 'vue';

const images = ref([
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg' },
  { src: 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg' },
]);

const activeIndex = ref(0);

function nextImage() {
  activeIndex.value = (activeIndex.value + 1) % images.value.length;
}

function prevImage() {
  activeIndex.value = (activeIndex.value - 1 + images.value.length) % images.value.length;
}

function changeImage(index) {
  activeIndex.value = index;
}

// defineProps({
//     images: Array,
// });

function functionFormatUrl(url) {
    return '/storage/' + url;
}
</script>