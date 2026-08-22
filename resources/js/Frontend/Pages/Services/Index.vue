<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Frontend/Components/Navbar.vue';
import Footer from '@/Frontend/Components/Footer.vue';

const serviceList = [
    { title: 'AIRLINE TICKETING & RESERVATIONS', slug: 'Airline Ticketing & Reservations' },
    { title: 'HOLIDAYS PACKAGES', slug: 'Holidays Packages' },
    { title: 'WORLDWIDE HOTEL RESERVATIONS', slug: 'Worldwide Hotel Reservations' },
    { title: 'VISA ASSISTANCE', slug: 'Visa Assistance' },
    { title: 'TRAVEL INSURANCE', slug: 'Travel Insurance' },
    { title: 'HEALTH INSURANCE', slug: 'Health Insurance' },
    { title: 'CRUISE PACKAGES', slug: 'Cruise Packages' },
    { title: 'STUDENT VISA CONSULATION', slug: 'Student Visa Consultation' },
];
</script>

<template>
    <Head title="Our Services - Worldine Destinations" />

    <div class="min-h-screen font-spinnaker bg-slate-50 text-slate-800 selection:bg-[#00B4D8] selection:text-white w-full overflow-x-hidden">
        <Navbar />

        <!-- HERO BANNER SECTION -->
        <section class="relative h-[38vh] min-h-[280px] sm:min-h-[340px] flex items-center justify-center bg-slate-950 text-white overflow-hidden w-full">
            <div class="absolute inset-0 z-0">
                <img 
                    src="/images/Logo/worldineback.png" 
                    alt="Worldine Travel Services" 
                    class="w-full h-full object-cover object-center filter brightness-90"
                    fetchpriority="high"
                />
                <!-- Smooth White Top Fade for Navbar -->
                <div class="absolute top-0 left-0 right-0 h-20 sm:h-28 bg-gradient-to-b from-white via-white/20 to-transparent pointer-events-none z-10"></div>
                <!-- Soft Dark Protection Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-slate-950/20 to-slate-950/30 z-10 pointer-events-none"></div>
            </div>

            <div class="relative z-20 text-center w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 pt-10 sm:pt-14 max-w-4xl mx-auto space-y-2">
                <span class="text-[11px] sm:text-xs font-black uppercase tracking-[0.3em] text-[#00B4D8] bg-white/10 backdrop-blur-md px-4 py-1 rounded-full inline-block" style="color: #00B4D8;">
                    WORLDINE TRAVEL CONCIERGE
                </span>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white uppercase leading-tight">
                    Our Services
                </h1>
            </div>
        </section>

        <!-- MAIN SERVICES SECTION -->
        <section class="py-16 sm:py-24 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 bg-white">
            
            <div class="w-full max-w-4xl mx-auto space-y-10">
                
                <!-- TITLE HEADER WITH TEAL UNDERLINE ACCENT -->
                <div class="text-center space-y-3">
                    <h2 class="text-3xl sm:text-4xl font-black tracking-wider uppercase" style="color: #00B4D8;">
                        OUR SERVICES
                    </h2>
                    <!-- Teal Underline Accent -->
                    <div class="w-24 h-1.5 mx-auto rounded-full" style="background-color: #00B4D8;"></div>
                </div>

                <!-- HIGH VISIBILITY TEAL BARS (EXACT MATCH TO SCREENSHOT WITH GUARANTEED COLORS) -->
                <div class="space-y-3.5 w-full">
                    <Link
                        v-for="(service, index) in serviceList"
                        :key="index"
                        :href="`/contact?service=${encodeURIComponent(service.slug)}`"
                        class="w-full px-6 sm:px-8 py-4 sm:py-5 flex items-center justify-between font-black text-sm sm:text-base tracking-wider uppercase transition-all duration-200 block shadow-md hover:shadow-lg cursor-pointer group rounded-sm"
                        style="background-color: #00B4D8; color: #ffffff;"
                    >
                        <span class="pr-4 leading-tight group-hover:translate-x-1 transition-transform inline-block font-extrabold text-white" style="color: #ffffff;">
                            {{ service.title }}
                        </span>
                        <span class="text-xl sm:text-2xl font-black text-white flex-shrink-0" style="color: #ffffff;">
                            +
                        </span>
                    </Link>
                </div>

            </div>

        </section>

        <!-- TRUST & ACCREDITATION STRIP -->
        <section class="py-12 bg-slate-900 text-white w-full font-spinnaker">
            <div class="w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">20+</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">Years Industry Expertise</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">100%</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">SLTDA Licensed & Approved</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">24/7</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">Personal Travel Concierge</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">50,000+</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">Happy Global Travelers</div>
                </div>
            </div>
        </section>

        <Footer />

    </div>
</template>
