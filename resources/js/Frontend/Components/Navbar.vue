<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    transparent: {
        type: Boolean,
        default: true
    }
});

const page = usePage();

const navDestinations = computed(() => page.props.navDestinations || []);
const navInboundPackages = computed(() => page.props.navInboundPackages || []);

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

const scrollToAbout = (e) => {
    const aboutEl = document.getElementById('about');
    if (aboutEl && (window.location.pathname === '/' || window.location.pathname === '')) {
        e.preventDefault();
        aboutEl.scrollIntoView({ behavior: 'smooth' });
    }
};

const handleMobileAboutClick = (e) => {
    mobileMenuOpen.value = false;
    scrollToAbout(e);
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <header class="sticky top-0 left-0 right-0 z-50 w-full bg-white py-2 sm:py-2.5 pl-6 sm:pl-9 lg:pl-12 xl:pl-14 pr-0 flex items-center justify-between transition-all duration-300 border-none outline-none border-b-0 font-spinnaker">
        <!-- Worldine Logo -->
        <Link href="/" class="flex items-center group py-0.5">
            <img 
                src="/images/Logo/worldine.png" 
                alt="Worldine Logo" 
                class="h-10 sm:h-11 lg:h-13 xl:h-14 w-auto object-contain group-hover:scale-105 transition-transform"
            />
        </Link>

        <!-- Desktop Navigation Links inside Blue Capsule -->
        <nav class="hidden lg:flex items-center bg-[#2B70B4] text-white rounded-l-full px-6 sm:px-7 lg:px-8 xl:px-10 py-2.5 sm:py-2.5 lg:py-3 space-x-3.5 sm:space-x-4 lg:space-x-5 xl:space-x-7 text-xs sm:text-sm lg:text-[14px] xl:text-[15px] font-bold tracking-wide shadow-md font-spinnaker">
            <Link href="/" class="text-white hover:text-sky-200 transition-colors whitespace-nowrap">Home</Link>
            <a href="/#about" @click="scrollToAbout" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap cursor-pointer">About Us</a>
            
            <!-- Sri Lanka Dropdown -->
            <div 
                class="relative py-1"
                @mouseenter="openSriLanka"
                @mouseleave="closeSriLanka"
            >
                <Link 
                    href="/srilanka" 
                    class="flex items-center space-x-1 text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap"
                >
                    <span>Sri Lanka</span>
                    <span v-if="navInboundPackages.length > 0" class="text-[10px] lg:text-xs transform transition-transform duration-200 ml-0.5" :class="{ 'rotate-180': activeSriLankaDropdown }">▼</span>
                </Link>

                <!-- Dynamic Sri Lanka Inbound Tours Dropdown Menu -->
                <div 
                    v-if="activeSriLankaDropdown && navInboundPackages.length > 0" 
                    class="absolute left-0 mt-2.5 w-60 bg-[#1E5288] text-white border border-white/20 rounded-xl shadow-2xl py-2 px-2 space-y-1 z-50 normal-case font-semibold text-xs sm:text-sm text-left max-h-80 overflow-y-auto"
                    @mouseenter="openSriLanka"
                    @mouseleave="closeSriLanka"
                >
                    <Link 
                        v-for="pkg in navInboundPackages" 
                        :key="pkg.id" 
                        :href="`/tours/${pkg.slug}`" 
                        @click="activeSriLankaDropdown = false" 
                        class="flex items-center justify-between px-3 py-1.5 rounded-lg text-white hover:bg-white/15 transition-colors group"
                    >
                        <span class="truncate">{{ pkg.title }}</span>
                        <span class="text-white/70 group-hover:text-white text-xs ml-1 flex-shrink-0">→</span>
                    </Link>
                </div>
            </div>

            <!-- Dynamic Destinations Dropdown -->
            <div 
                class="relative py-1"
                @mouseenter="openDestinations"
                @mouseleave="closeDestinations"
            >
                <Link 
                    href="/destinations" 
                    class="flex items-center space-x-1 text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap"
                >
                    <span>Destinations</span>
                    <span v-if="navDestinations.length > 0" class="text-[10px] lg:text-xs transform transition-transform duration-200 ml-0.5" :class="{ 'rotate-180': activeDestinationsDropdown }">▼</span>
                </Link>

                <!-- Dynamic Destinations Countries Dropdown Menu -->
                <div 
                    v-if="activeDestinationsDropdown && navDestinations.length > 0" 
                    class="absolute left-0 mt-2.5 w-56 bg-[#1E5288] text-white border border-white/20 rounded-xl shadow-2xl py-2 px-2 space-y-1 z-50 normal-case font-semibold text-xs sm:text-sm text-left max-h-80 overflow-y-auto"
                    @mouseenter="openDestinations"
                    @mouseleave="closeDestinations"
                >
                    <Link 
                        v-for="dest in navDestinations" 
                        :key="dest.id" 
                        :href="`/destinations?region=${dest.slug}`" 
                        @click="activeDestinationsDropdown = false" 
                        class="flex items-center justify-between px-3 py-1.5 rounded-lg text-white hover:bg-white/15 transition-colors group"
                    >
                        <span>{{ dest.name }}</span>
                        <span class="text-white/70 group-hover:text-white text-xs flex-shrink-0">→</span>
                    </Link>
                </div>
            </div>

            <Link href="/services" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap">Services</Link>
            
            <Link href="/contact" class="text-white/95 hover:text-sky-200 transition-colors whitespace-nowrap">Contact</Link>
        </nav>

        <!-- Burger Button -->
        <button 
            @click="mobileMenuOpen = !mobileMenuOpen" 
            class="lg:hidden mr-6 relative w-7 h-5 bg-transparent border-none outline-none cursor-pointer flex flex-col justify-between p-0 focus:outline-none group"
            :aria-label="mobileMenuOpen ? 'Close Menu' : 'Open Menu'"
        >
            <span 
                class="block h-[3.5px] w-full bg-[#2B70B4] group-hover:bg-[#2196F3] rounded-full transition-all duration-300 ease-in-out origin-[left_center]"
                :class="mobileMenuOpen ? 'rotate-45 translate-x-[3px] -translate-y-[1px]' : ''"
            ></span>
            <span 
                class="block h-[3.5px] w-full bg-[#2B70B4] group-hover:bg-[#2196F3] rounded-full transition-all duration-300 ease-in-out origin-[left_center]"
                :class="mobileMenuOpen ? 'w-0 opacity-0' : 'opacity-100'"
            ></span>
            <span 
                class="block h-[3.5px] w-full bg-[#2B70B4] group-hover:bg-[#2196F3] rounded-full transition-all duration-300 ease-in-out origin-[left_center]"
                :class="mobileMenuOpen ? '-rotate-45 translate-x-[3px] translate-y-[1px]' : ''"
            ></span>
        </button>

        <!-- Mobile Drawer -->
        <div v-if="mobileMenuOpen" class="lg:hidden bg-white/95 backdrop-blur-xl border-none outline-none px-6 pt-3 pb-5 space-y-3 text-xs font-bold uppercase tracking-wider fixed left-0 right-0 top-16 z-50 shadow-xl max-h-[85vh] overflow-y-auto text-slate-800 font-spinnaker">
            <Link href="/" @click="mobileMenuOpen = false" class="block text-slate-900 hover:text-[#2B70B4] py-1 border-b border-slate-100">Home</Link>
            <a href="/#about" @click="handleMobileAboutClick" class="block text-slate-700 hover:text-[#2B70B4] py-1 border-b border-slate-100 cursor-pointer">About Us</a>
            
            <!-- Mobile Sri Lanka Dropdown -->
            <div class="border-b border-slate-100 py-1">
                <button 
                    @click="activeSriLankaDropdown = !activeSriLankaDropdown" 
                    class="w-full flex items-center justify-between text-slate-700 hover:text-[#2B70B4] uppercase font-bold text-left"
                >
                    <span>Sri Lanka</span>
                    <span v-if="navInboundPackages.length > 0" class="text-[10px]">{{ activeSriLankaDropdown ? '▲' : '▼' }}</span>
                </button>
                <div v-if="activeSriLankaDropdown && navInboundPackages.length > 0" class="mt-2 pl-3 space-y-1.5 text-slate-600 normal-case font-medium">
                    <Link 
                        v-for="pkg in navInboundPackages" 
                        :key="pkg.id" 
                        :href="`/tours/${pkg.slug}`" 
                        @click="mobileMenuOpen = false" 
                        class="block py-1 text-xs hover:text-[#2B70B4]"
                    >
                        {{ pkg.title }}
                    </Link>
                </div>
            </div>

            <!-- Mobile Destinations Dropdown -->
            <div class="border-b border-slate-100 py-1">
                <button 
                    @click="activeDestinationsDropdown = !activeDestinationsDropdown" 
                    class="w-full flex items-center justify-between text-slate-700 hover:text-[#2B70B4] uppercase font-bold text-left"
                >
                    <span>Destinations</span>
                    <span v-if="navDestinations.length > 0" class="text-[10px]">{{ activeDestinationsDropdown ? '▲' : '▼' }}</span>
                </button>
                <div v-if="activeDestinationsDropdown && navDestinations.length > 0" class="mt-2 pl-3 space-y-1.5 text-slate-600 normal-case font-medium">
                    <Link 
                        v-for="dest in navDestinations" 
                        :key="dest.id" 
                        :href="`/destinations?region=${dest.slug}`" 
                        @click="mobileMenuOpen = false" 
                        class="block py-1 text-xs hover:text-[#2B70B4]"
                    >
                        {{ dest.name }}
                    </Link>
                </div>
            </div>

            <Link href="/services" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-[#2B70B4] py-1 border-b border-slate-100">Services</Link>
            <Link href="/contact" @click="mobileMenuOpen = false" class="inline-block mt-2 px-5 py-2 rounded-full bg-[#2B70B4] text-white font-extrabold shadow-md">Contact</Link>
        </div>
    </header>
</template>
