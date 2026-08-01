<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    transparent: {
        type: Boolean,
        default: true
    }
});

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activePagesDropdown = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 30;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <header :class="[
        'fixed top-0 left-0 right-0 z-50 transition-all duration-300 w-full px-6 sm:px-10 lg:px-16 xl:px-20',
        isScrolled 
            ? 'bg-slate-950/40 backdrop-blur-md py-3 shadow-lg' 
            : 'bg-transparent py-4 sm:py-5'
    ]">
        <div class="w-full flex items-center justify-between">
            
            <!-- Worldine Standalone Logo Image -->
            <Link href="/" class="flex items-center group">
                <img 
                    src="/images/Logo/worldine.png" 
                    alt="Worldine Logo" 
                    class="h-10 sm:h-12 lg:h-14 w-auto object-contain group-hover:scale-105 transition-transform filter drop-shadow-md"
                />
            </Link>

            <!-- Desktop Navigation Links (Transparent Mode) -->
            <nav class="hidden lg:flex items-center space-x-6 xl:space-x-10 text-xs font-bold uppercase tracking-wider text-white">
                <a href="#hero" class="text-white hover:text-[#90CAF9] transition-colors">HOME</a>
                <a href="#about" class="text-white/90 hover:text-[#90CAF9] transition-colors">ABOUT</a>
                <a href="#destinations" class="text-white/90 hover:text-[#90CAF9] transition-colors">SERVICE</a>
                <a href="#destinations" class="text-white/90 hover:text-[#90CAF9] transition-colors">GALLERY</a>
                <a href="#quiz" class="text-white/90 hover:text-[#90CAF9] transition-colors">FAQ</a>
                
                <!-- Pages Dropdown -->
                <div class="relative">
                    <button 
                        @click="activePagesDropdown = !activePagesDropdown" 
                        class="flex items-center space-x-1 text-white/90 hover:text-[#90CAF9] transition-colors uppercase font-bold focus:outline-none"
                    >
                        <span>PAGES</span>
                        <span class="text-[9px]">▼</span>
                    </button>

                    <div v-if="activePagesDropdown" class="absolute right-0 mt-3 w-48 bg-slate-900/90 backdrop-blur-xl border border-white/15 rounded-xl shadow-2xl py-2 z-50 normal-case font-normal text-xs">
                        <a href="#destinations" @click="activePagesDropdown = false" class="block px-4 py-2 text-white hover:bg-[#2196F3] hover:text-white">Tour Packages</a>
                        <a href="#estimator" @click="activePagesDropdown = false" class="block px-4 py-2 text-white hover:bg-[#2196F3] hover:text-white">Budget Estimator</a>
                        <a href="#quiz" @click="activePagesDropdown = false" class="block px-4 py-2 text-white hover:bg-[#2196F3] hover:text-white">Travel Quiz</a>
                        <a href="#testimonials" @click="activePagesDropdown = false" class="block px-4 py-2 text-white hover:bg-[#2196F3] hover:text-white">Customer Reviews</a>
                    </div>
                </div>

                <!-- CTA Contact Pill -->
                <a href="#estimator" class="px-5 py-2 rounded-full bg-[#2196F3] text-white font-extrabold hover:bg-[#90CAF9] hover:text-slate-950 transition-all shadow-md">
                    CONTACT
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-1.5 text-white hover:text-[#90CAF9] focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Drawer -->
        <div v-if="mobileMenuOpen" class="lg:hidden bg-slate-950/95 backdrop-blur-xl border-b border-white/15 px-6 pt-3 pb-5 space-y-3 text-xs font-bold uppercase tracking-wider fixed left-0 right-0 top-16 z-50">
            <a href="#hero" @click="mobileMenuOpen = false" class="block text-white hover:text-[#90CAF9] py-1 border-b border-white/10">HOME</a>
            <a href="#about" @click="mobileMenuOpen = false" class="block text-white/90 hover:text-[#90CAF9] py-1 border-b border-white/10">ABOUT</a>
            <a href="#destinations" @click="mobileMenuOpen = false" class="block text-white/90 hover:text-[#90CAF9] py-1 border-b border-white/10">SERVICE</a>
            <a href="#destinations" @click="mobileMenuOpen = false" class="block text-white/90 hover:text-[#90CAF9] py-1 border-b border-white/10">GALLERY</a>
            <a href="#quiz" @click="mobileMenuOpen = false" class="block text-white/90 hover:text-[#90CAF9] py-1 border-b border-white/10">FAQ</a>
            <a href="#estimator" @click="mobileMenuOpen = false" class="inline-block mt-2 px-5 py-2 rounded-full bg-[#2196F3] text-white font-extrabold">CONTACT</a>
        </div>
    </header>
</template>
