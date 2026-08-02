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
    <header class="sticky top-0 left-0 right-0 z-50 w-full bg-white py-2.5 sm:py-3 pl-6 sm:pl-10 lg:pl-14 pr-0 flex items-center justify-between transition-all duration-300 border-none outline-none border-b-0 font-spinnaker">
        <!-- Worldine Logo -->
        <Link href="/" class="flex items-center group py-1">
            <img 
                src="/images/Logo/worldine.png" 
                alt="Worldine Logo" 
                class="h-11 sm:h-13 lg:h-15 xl:h-16 w-auto object-contain group-hover:scale-105 transition-transform"
            />
        </Link>

        <!-- Desktop Navigation Links inside Blue Capsule (Auto-responsive sizing & enhanced visibility) -->
        <nav class="hidden lg:flex items-center bg-[#2B70B4] text-white rounded-l-full px-6 sm:px-8 lg:px-10 xl:px-12 py-3 sm:py-3.5 lg:py-4 space-x-4 sm:space-x-5 lg:space-x-7 xl:space-x-9 text-xs sm:text-sm lg:text-base font-bold tracking-wide shadow-md font-spinnaker">
            <a href="#hero" class="text-white hover:text-sky-200 transition-colors whitespace-nowrap">Home</a>
            <a href="#about" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap">About Us</a>
            
            <!-- Sri Lanka Dropdown -->
            <div 
                class="relative py-1"
                @mouseenter="openSriLanka"
                @mouseleave="closeSriLanka"
            >
                <a 
                    href="#destinations" 
                    class="flex items-center space-x-1 text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap"
                >
                    <span>Sri Lanka</span>
                    <span class="text-[10px] lg:text-xs transform transition-transform duration-200 ml-0.5" :class="{ 'rotate-180': activeSriLankaDropdown }">▼</span>
                </a>

                <!-- Sri Lanka Inbound Tours Dropdown Menu -->
                <div 
                    v-if="activeSriLankaDropdown" 
                    class="absolute left-0 mt-2 w-64 bg-[#1E5288] text-white border border-white/20 rounded-xl shadow-2xl py-2 px-2 space-y-1 z-50 normal-case font-semibold text-xs sm:text-sm text-left"
                    @mouseenter="openSriLanka"
                    @mouseleave="closeSriLanka"
                >
                    <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>Heritage & Cultural Tour</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>Grand Heritage Expedition</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>Coastal Beach Adventure</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeSriLankaDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>Wildlife & Nature Safari</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                </div>
            </div>

            <!-- Destinations Dropdown -->
            <div 
                class="relative py-1"
                @mouseenter="openDestinations"
                @mouseleave="closeDestinations"
            >
                <a 
                    href="#destinations" 
                    class="flex items-center space-x-1 text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap"
                >
                    <span>Destinations</span>
                    <span class="text-[10px] lg:text-xs transform transition-transform duration-200 ml-0.5" :class="{ 'rotate-180': activeDestinationsDropdown }">▼</span>
                </a>

                <!-- Destinations Countries Dropdown Menu -->
                <div 
                    v-if="activeDestinationsDropdown" 
                    class="absolute left-0 mt-2 w-60 bg-[#1E5288] text-white border border-white/20 rounded-xl shadow-2xl py-2 px-2 space-y-1 z-50 normal-case font-semibold text-xs sm:text-sm text-left"
                    @mouseenter="openDestinations"
                    @mouseleave="closeDestinations"
                >
                    <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>🇲🇻 Maldives</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>🇦🇪 Dubai & UAE</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>🇪🇺 Europe Schengen</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>🇯🇵 Japan & East Asia</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                    <a href="#destinations" @click="activeDestinationsDropdown = false" class="flex items-center justify-between px-3 py-2 rounded-lg text-white hover:bg-white/15 transition-colors group">
                        <span>🇨🇦 Canada</span>
                        <span class="text-white/70 group-hover:text-white text-xs">→</span>
                    </a>
                </div>
            </div>

            <a href="#services" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap">Services</a>

            <a href="#estimator" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap">Worldine Education</a>
            
            <a href="#footer" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap">Contact</a>

            <!-- Admin Portal Access Link -->
            <Link href="/dashboard" class="text-white/90 hover:text-white flex items-center space-x-1 px-3 py-1.5 rounded-full bg-white/20 hover:bg-white/30 transition-all text-xs sm:text-sm font-semibold whitespace-nowrap">
                <span>🔑 Admin</span>
            </Link>
        </nav>

        <!-- Cevorob Uiverse Animated Blue Burger Button (Transparent Background) -->
        <button 
            @click="mobileMenuOpen = !mobileMenuOpen" 
            class="lg:hidden mr-6 relative w-7 h-5 bg-transparent border-none outline-none cursor-pointer flex flex-col justify-between p-0 focus:outline-none group"
            :aria-label="mobileMenuOpen ? 'Close Menu' : 'Open Menu'"
        >
            <!-- Top Line -->
            <span 
                class="block h-[3.5px] w-full bg-[#2B70B4] group-hover:bg-[#2196F3] rounded-full transition-all duration-300 ease-in-out origin-[left_center]"
                :class="mobileMenuOpen ? 'rotate-45 translate-x-[3px] -translate-y-[1px]' : ''"
            ></span>
            <!-- Middle Line -->
            <span 
                class="block h-[3.5px] w-full bg-[#2B70B4] group-hover:bg-[#2196F3] rounded-full transition-all duration-300 ease-in-out origin-[left_center]"
                :class="mobileMenuOpen ? 'w-0 opacity-0' : 'opacity-100'"
            ></span>
            <!-- Bottom Line -->
            <span 
                class="block h-[3.5px] w-full bg-[#2B70B4] group-hover:bg-[#2196F3] rounded-full transition-all duration-300 ease-in-out origin-[left_center]"
                :class="mobileMenuOpen ? '-rotate-45 translate-x-[3px] translate-y-[1px]' : ''"
            ></span>
        </button>

        <!-- Mobile Drawer -->
        <div v-if="mobileMenuOpen" class="lg:hidden bg-white/95 backdrop-blur-xl border-none outline-none px-6 pt-3 pb-5 space-y-3 text-xs font-bold uppercase tracking-wider fixed left-0 right-0 top-16 z-50 shadow-xl max-h-[85vh] overflow-y-auto text-slate-800 font-spinnaker">
            <a href="#hero" @click="mobileMenuOpen = false" class="block text-slate-900 hover:text-[#2B70B4] py-1 border-b border-slate-100">Home</a>
            <a href="#about" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-[#2B70B4] py-1 border-b border-slate-100">About Us</a>
            
            <!-- Mobile Sri Lanka Dropdown -->
            <div class="border-b border-slate-100 py-1">
                <button @click="activeSriLankaDropdown = !activeSriLankaDropdown" class="w-full flex items-center justify-between text-slate-700 hover:text-[#2B70B4] uppercase font-bold text-left">
                    <span>Sri Lanka</span>
                    <span class="text-[10px]">{{ activeSriLankaDropdown ? '▲' : '▼' }}</span>
                </button>
                <div v-if="activeSriLankaDropdown" class="mt-2 pl-3 space-y-1.5 text-slate-600 normal-case font-medium">
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">Heritage & Cultural Tour</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">Grand Heritage Expedition</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">Coastal Beach Adventure</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">Wildlife & Nature Safari</a>
                </div>
            </div>

            <!-- Mobile Destinations Dropdown -->
            <div class="border-b border-slate-100 py-1">
                <button @click="activeDestinationsDropdown = !activeDestinationsDropdown" class="w-full flex items-center justify-between text-slate-700 hover:text-[#2B70B4] uppercase font-bold text-left">
                    <span>Destinations</span>
                    <span class="text-[10px]">{{ activeDestinationsDropdown ? '▲' : '▼' }}</span>
                </button>
                <div v-if="activeDestinationsDropdown" class="mt-2 pl-3 space-y-1.5 text-slate-600 normal-case font-medium">
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">🇲🇻 Maldives</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">🇦🇪 Dubai & UAE</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">🇪🇺 Europe Schengen</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">🇯🇵 Japan & East Asia</a>
                    <a href="#destinations" @click="mobileMenuOpen = false" class="block py-1 text-xs hover:text-[#2B70B4]">🇨🇦 Canada</a>
                </div>
            </div>

            <a href="#services" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-[#2B70B4] py-1 border-b border-slate-100">Services</a>
            <a href="#estimator" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-[#2B70B4] py-1 border-b border-slate-100">Worldine Education</a>
            <a href="#footer" @click="mobileMenuOpen = false" class="inline-block mt-2 px-5 py-2 rounded-full bg-[#2B70B4] text-white font-extrabold shadow-md">Contact</a>
        </div>
    </header>
</template>

