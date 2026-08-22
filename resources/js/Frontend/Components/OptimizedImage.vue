<script setup>
import { ref } from 'vue';

const props = defineProps({
    src: { type: String, required: true },
    alt: { type: String, default: '' },
    imgClass: { type: String, default: 'w-full h-full object-cover' },
    wrapperClass: { type: String, default: 'w-full h-full relative overflow-hidden bg-slate-100' },
    loading: { type: String, default: 'lazy' }, // 'lazy' | 'eager'
    fetchpriority: { type: String, default: 'auto' }, // 'high' | 'low' | 'auto'
});

const isLoaded = ref(false);
const hasError = ref(false);

const onLoad = () => {
    isLoaded.value = true;
};

const onError = () => {
    hasError.value = true;
    isLoaded.value = true;
};
</script>

<template>
    <div :class="[wrapperClass, 'relative']">
        <!-- Shimmer Skeleton Loading State -->
        <div 
            v-if="!isLoaded" 
            class="absolute inset-0 bg-gradient-to-r from-slate-200 via-slate-100 to-slate-200 animate-pulse z-0"
        ></div>

        <!-- Actual Image with Smooth Opacity Transition -->
        <img 
            :src="src" 
            :alt="alt" 
            :loading="loading"
            :fetchpriority="fetchpriority"
            decoding="async"
            @load="onLoad"
            @error="onError"
            :class="[
                imgClass,
                'transition-opacity duration-500 ease-out',
                isLoaded ? 'opacity-100' : 'opacity-0'
            ]"
        />

        <!-- Fallback if Broken Image -->
        <div 
            v-if="hasError" 
            class="absolute inset-0 flex items-center justify-center bg-slate-100 text-slate-400 text-xs font-semibold"
        >
            <span>Image unavailable</span>
        </div>
    </div>
</template>
