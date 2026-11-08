<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Frontend/Components/Navbar.vue';
import Footer from '@/Frontend/Components/Footer.vue';

defineProps({
    coreServices: {
        type: Array,
        default: () => []
    },
    valueAddedServices: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <Head title="Our Services - Worldine Destinations" />

    <div class="min-h-screen font-spinnaker bg-white text-slate-800 selection:bg-[#2B70B4] selection:text-white w-full overflow-x-hidden flex flex-col justify-between">
        <Navbar />

        <!-- HERO BANNER SECTION WITH GENTLE ORGANIC CURVE -->
        <section class="relative bg-gradient-to-br from-[#0B2545] via-[#134074] to-[#1D4E89] text-white pt-12 pb-20 sm:pt-16 sm:pb-28 overflow-hidden">
            <!-- Subtle Background Accents -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
            <div class="absolute -top-20 -right-20 w-80 h-80 bg-sky-400/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl mx-auto px-6 text-center space-y-3">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20">
                    <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                    <span class="text-[11px] sm:text-xs font-black uppercase tracking-[0.25em] text-sky-200">
                        Worldine Travel Concierge
                    </span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white uppercase leading-tight">
                    Our Travel Services
                </h1>

                <p class="text-xs sm:text-sm text-slate-200/90 font-medium max-w-xl mx-auto leading-relaxed">
                    Reliable, licensed travel operations and personalized customer assistance for international holidays and Sri Lanka expeditions.
                </p>
            </div>

            <!-- Gentle Wave Separator -->
            <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none z-10 pointer-events-none">
                <svg class="relative block w-full h-7 sm:h-10 text-white" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0 C150,90 350,-40 500,40 C650,120 900,20 1200,60 L1200,120 L0,120 Z" fill="currentColor"></path>
                </svg>
            </div>
        </section>

        <!-- SERVICES CONTENT (ELEGANT CENTERED TYPOGRAPHIC DIRECTORY) -->
        <main class="flex-grow max-w-3xl mx-auto px-6 py-12 sm:py-16 w-full space-y-12 sm:space-y-14">

            <!-- SECTION 1: OUR SERVICES -->
            <section class="space-y-6 sm:space-y-8">
                <!-- Section Heading Flanked by Thin Lines -->
                <div class="flex items-center justify-center space-x-4 max-w-lg mx-auto">
                    <div class="h-[1px] bg-sky-600/40 flex-1"></div>
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold text-[#102A43] tracking-normal whitespace-nowrap px-2">
                        Our Services
                    </h2>
                    <div class="h-[1px] bg-sky-600/40 flex-1"></div>
                </div>

                <!-- Centered Service Items List -->
                <div class="space-y-3.5 sm:space-y-4 text-center">
                    <div 
                        v-for="service in coreServices" 
                        :key="service.id"
                        class="leading-relaxed"
                    >
                        <Link 
                            :href="`/contact?service=${encodeURIComponent(service.slug)}`"
                            class="text-sm sm:text-base text-slate-700 hover:text-[#2B70B4] font-medium transition-colors duration-200 inline-block px-3 py-1 rounded hover:bg-slate-50"
                        >
                            {{ service.title }}
                        </Link>
                    </div>
                </div>
            </section>

            <!-- SECTION 2: VALUE ADDED SERVICES -->
            <section class="space-y-6 sm:space-y-8 pt-4">
                <!-- Section Heading Flanked by Thin Lines -->
                <div class="flex items-center justify-center space-x-4 max-w-lg mx-auto">
                    <div class="h-[1px] bg-sky-600/40 flex-1"></div>
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold text-[#102A43] tracking-normal whitespace-nowrap px-2">
                        Value added services
                    </h2>
                    <div class="h-[1px] bg-sky-600/40 flex-1"></div>
                </div>

                <!-- Centered Value Added Services List -->
                <div class="space-y-3.5 sm:space-y-4 text-center">
                    <div 
                        v-for="service in valueAddedServices" 
                        :key="service.id"
                        class="leading-relaxed"
                    >
                        <Link 
                            :href="`/contact?service=${encodeURIComponent(service.slug)}`"
                            class="text-sm sm:text-base text-slate-700 hover:text-[#2B70B4] font-medium transition-colors duration-200 inline-block px-3 py-1 rounded hover:bg-slate-50"
                        >
                            {{ service.title }}
                        </Link>
                    </div>
                </div>
            </section>

            <!-- CALL TO ACTION: LET'S CONNECT BUTTON -->
            <div class="pt-6 sm:pt-8 flex justify-center">
                <Link 
                    href="/contact"
                    class="inline-flex items-center justify-center px-8 py-3 rounded-lg bg-[#1E3A5F] hover:bg-[#2B70B4] text-white font-bold text-sm tracking-wide shadow-md hover:shadow-lg transition-all duration-200 active:scale-95"
                >
                    Let's connect
                </Link>
            </div>

        </main>

        <!-- TRUST & ACCREDITATION STRIP -->
        <section class="py-10 bg-slate-900 text-white w-full border-t border-slate-800">
            <div class="max-w-6xl mx-auto px-6 sm:px-10 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="space-y-1">
                    <span class="text-2xl font-black text-[#90CAF9]">20+</span>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-300">Years Experience</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl font-black text-[#90CAF9]">100%</span>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-300">SLTDA Licensed</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl font-black text-[#90CAF9]">24/7</span>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-300">Dedicated Support</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl font-black text-[#90CAF9]">50,000+</span>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-300">Global Travelers</div>
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>
