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

// Dropdown states
const activeSriLankaDropdown = ref(false);
const activeDestinationsDropdown = ref(false);

let sriLankaTimer = null;
let destinationsTimer = null;

const openSriLanka = () => {
    if (sriLankaTimer) clearTimeout(sriLankaTimer);
    activeSriLankaDropdown.value = true;
    activeDestinationsDropdown.value = false;
};

const closeSriLanka = () => {
    sriLankaTimer = setTimeout(() => {
        activeSriLankaDropdown.value = false;
    }, 200);
};

const openDestinations = () => {
    if (destinationsTimer) clearTimeout(destinationsTimer);
    activeDestinationsDropdown.value = true;
    activeSriLankaDropdown.value = false;
};

const closeDestinations = () => {
    destinationsTimer = setTimeout(() => {
        activeDestinationsDropdown.value = false;
    }, 200);
};

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
            ? 'bg-slate-950/85 backdrop-blur-md py-3 shadow-lg' 
            : 'bg-transparent py-4 sm:py-5'
    ]">
        <div class="w-full flex items-center justify-between">
            
            <!-- Worldine Logo -->
            <Link href="/" class="flex items-center group">
                <img 
                    src="/images/Logo/worldine.png" 
                    alt="Worldine Logo" 
                    class="h-10 sm:h-12 lg:h-14 w-auto object-contain group-hover:scale-105 transition-transform filter drop-shadow-md"
                />
            </Link>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-6 xl:space-x-8 text-xs font-extrabold uppercase tracking-wider text-white">
                <a href="#hero" class="text-white hover:text-[#90CAF9] transition-colors">Home</a>
                <a href="#about" class="text-white/90 hover:text-[#90CAF9] transition-colors">About us</a>
                
                <!-- Sri Lanka Dropdown (Inbound Tours) -->
                <div 
                    class="relative py-2"
                    @mouseenter="openSriLanka"
                    @mouseleave="closeSriLanka"
                >
                    <a 
                        href="#destinations" 
                        class="flex items-center space-x-1 text-white/90 hover:text-[#90CAF9] transition-colors"
                    >
                        <span>Sri Lanka</span>
                        <span class="text-[9px] transform transition-transform duration-200" :class="{ 'rotate-180': activeSriLankaDropdown }">▼</span>
                    </a>

                    <!-- Sri Lanka Inbound Tours Dropdown Menu (Clean 1-Line) -->
                    <div 
                        v-if="activeSriLankaDropdown" 
                        class="absolute left-0 mt-2 w-64 bg-slate-950/95 backdrop-blur-xl border border-white/15 rounded-xl shadow-2xl py-2 px-1.5 space-y-0.5 z-50 normal-case font-medium text-xs text-left"
                        @mouseenter="openSriLanka"
                        @mouseleave="closeSriLanka"
                    >
                        <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>Heritage & Cultural Tour</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>Grand Heritage Expedition</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>Coastal Beach Adventure</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>Wildlife & Nature Safari</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                    </div>
                </div>

                <!-- Destinations Dropdown (Destination Countries) -->
                <div 
                    class="relative py-2"
                    @mouseenter="openDestinations"
                    @mouseleave="closeDestinations"
                >
                    <a 
                        href="#destinations" 
                        class="flex items-center space-x-1 text-white/90 hover:text-[#90CAF9] transition-colors"
                    >
                        <span>Destinations</span>
                        <span class="text-[9px] transform transition-transform duration-200" :class="{ 'rotate-180': activeDestinationsDropdown }">▼</span>
                    </a>

                    <!-- Destinations Countries Dropdown Menu (Clean 1-Line) -->
                    <div 
                        v-if="activeDestinationsDropdown" 
                        class="absolute left-0 mt-2 w-60 bg-slate-950/95 backdrop-blur-xl border border-white/15 rounded-xl shadow-2xl py-2 px-1.5 space-y-0.5 z-50 normal-case font-medium text-xs text-left"
                        @mouseenter="openDestinations"
                        @mouseleave="closeDestinations"
                    >
                        <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>🇲🇻 Maldives</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>🇦🇪 Dubai & UAE</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>🇪🇺 Europe Schengen</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>🇯🇵 Japan & East Asia</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                        <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/90 hover:bg-[#2196F3] hover:text-white transition-colors group">
                            <span>🇨🇦 Canada</span>
                            <span class="text-white/40 group-hover:text-white text-[10px] opacity-0 group-hover:opacity-100 transition-opacity">→</span>
                        </a>
                    </div>
                </div>

                <a href="#services" class="text-white/90 hover:text-[#90CAF9] transition-colors">Services</a>
                
                <!-- CTA Contact Us Pill -->
                <a href="#footer" class="px-5 py-2 rounded-full bg-[#2196F3] text-white font-extrabold hover:bg-[#90CAF9] hover:text-slate-950 transition-all shadow-md">
                    Contact us
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

        <!-- Mobile Drawer with Clean 1-Line Accordion Submenus -->
        <div v-if="mobileMenuOpen" class="lg:hidden bg-slate-950/95 backdrop-blur-xl border-b border-white/15 px-6 pt-3 pb-5 space-y-3 text-xs font-bold uppercase tracking-wider fixed left-0 right-0 top-16 z-50 max-h-[85vh] overflow-y-auto">
            <a href="#hero" @click="mobileMenuOpen = false" class="block text-white hover:text-[#90CAF9] py-1 border-b border-white/10">Home</a>
            <a href="#about" @click="mobileMenuOpen = false" class="block text-white/90 hover:text-[#90CAF9] py-1 border-b border-white/10">About us</a>
            
            <!-- Mobile Sri Lanka Dropdown -->
            <div class="border-b border-white/10 py-1">
                <button @click="activeSriLankaDropdown = !activeSriLankaDropdown" class="w-full flex items-center justify-between text-white/90 hover:text-[#90CAF9] uppercase font-bold text-left">
                    <span>Sri Lanka</span>
                    <span class="text-[10px]">{{ activeSriLankaDropdown ? '▲' : '▼' }}</span>
                </button>
                <div v-if="activeSriLankaDropdown" class="mt-2 pl-3 space-y-1.5 text-slate-300 normal-case font-medium">
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">Heritage & Cultural Tour</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">Grand Heritage Expedition</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">Coastal Beach Adventure</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">Wildlife & Nature Safari</a>
                </div>
            </div>

            <!-- Mobile Destinations Dropdown -->
            <div class="border-b border-white/10 py-1">
                <button @click="activeDestinationsDropdown = !activeDestinationsDropdown" class="w-full flex items-center justify-between text-white/90 hover:text-[#90CAF9] uppercase font-bold text-left">
                    <span>Destinations</span>
                    <span class="text-[10px]">{{ activeDestinationsDropdown ? '▲' : '▼' }}</span>
                </button>
                <div v-if="activeDestinationsDropdown" class="mt-2 pl-3 space-y-1.5 text-slate-300 normal-case font-medium">
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">🇲🇻 Maldives</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">🇦🇪 Dubai & UAE</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">🇪🇺 Europe Schengen</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">🇯🇵 Japan & East Asia</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#90CAF9]">🇨🇦 Canada</a>
                </div>
            </div>

            <a href="#services" @click="mobileMenuOpen = false" class="block text-white/90 hover:text-[#90CAF9] py-1 border-b border-white/10">Services</a>
            <a href="#footer" @click="mobileMenuOpen = false" class="inline-block mt-2 px-5 py-2 rounded-full bg-[#2196F3] text-white font-extrabold">Contact us</a>
        </div>
    </header>
</template>

