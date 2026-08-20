<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Frontend/Components/Navbar.vue';

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

        <!-- SITE FOOTER -->
        <footer id="footer" class="relative bg-slate-950 text-white text-xs w-full overflow-hidden font-spinnaker">
            <!-- Background Image with Very Low Opacity (10%) & Dark Blue Protection Gradient Overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="/images/Logo/worldineback.png" 
                    alt="Footer Background" 
                    class="w-full h-full object-cover object-center filter blur-[1px] opacity-10 scale-105"
                />
                <div class="absolute inset-0 bg-gradient-to-b from-[#0A2540]/95 via-[#0B2E59]/97 to-slate-950/99"></div>
            </div>

            <!-- DESKTOP FOOTER VIEW -->
            <div class="hidden md:block relative z-10 pt-8 sm:pt-10 pb-4 sm:pb-5 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 font-spinnaker">
                <div class="w-full grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    
                    <!-- Column 1: Logo & Branding -->
                    <div class="space-y-3">
                        <Link href="/" class="inline-block group">
                            <img 
                                src="/images/Logo/worldine.png" 
                                alt="Worldine Destinations Logo" 
                                class="h-16 sm:h-20 w-auto object-contain filter drop-shadow-md group-hover:scale-105 transition-transform" 
                            />
                        </Link>
                        <p class="text-slate-300 text-xs leading-relaxed font-normal">
                            Worldine Destinations (Pvt) Ltd. Over 20 years of experience in the travel trade with deep knowledge in Ticketing, Visas, Outbound & Inbound tours, and Travel Insurance.
                        </p>

                        <!-- Social Media Section -->
                        <div class="pt-1">
                            <h5 class="text-[11px] font-bold text-[#90CAF9] uppercase tracking-wider mb-2 font-spinnaker">Follow Us</h5>
                            <div class="flex items-center space-x-2.5">
                                <a href="https://www.facebook.com/worldinedestinations/" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#2196F3] text-white flex items-center justify-center transition-all border border-white/15" aria-label="Facebook">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <a href="https://www.instagram.com/worldinedestinations" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center transition-all border border-white/15" aria-label="Instagram">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Quick Links
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li><Link href="/" class="hover:text-[#90CAF9] transition-colors">Home</Link></li>
                            <li><Link href="/srilanka" class="hover:text-[#90CAF9] transition-colors">Sri Lanka Inbound</Link></li>
                            <li><Link href="/destinations" class="hover:text-[#90CAF9] transition-colors">Global Destinations</Link></li>
                            <li><Link href="/services" class="hover:text-[#90CAF9] transition-colors">Our Services</Link></li>
                            <li><Link href="/contact" class="hover:text-[#90CAF9] transition-colors">Contact & Support</Link></li>
                        </ul>
                    </div>

                    <!-- Column 3: Inbound & Outbound Tours -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Tour Expeditions
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li><Link href="/srilanka" class="hover:text-[#90CAF9] transition-colors">Sri Lanka Heritage Tours</Link></li>
                            <li><Link href="/destinations?region=maldives-paradise" class="hover:text-[#90CAF9] transition-colors">Maldives Luxury Escapes</Link></li>
                            <li><Link href="/destinations?region=dubai-uae" class="hover:text-[#90CAF9] transition-colors">Dubai & UAE Safaris</Link></li>
                            <li><Link href="/destinations?region=switzerland-europe" class="hover:text-[#90CAF9] transition-colors">Europe Schengen Tours</Link></li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact & Hotlines -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Hotline & Office
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li>
                                <a href="tel:+94766834881" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>+94 766 834 881</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:+94718834881" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>+94 718 834 881</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:info@worldinedestinations.com" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    <span class="truncate">info@worldinedestinations.com</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Copyright Bar -->
                <div class="mt-5 pt-2.5 border-t border-white/15 flex flex-row items-center justify-between gap-2 text-[11px] text-slate-400 font-spinnaker">
                    <div>
                        Copyright © 2026 Worldine Destinations (Pvt) Ltd. All Rights Reserved.
                    </div>
                </div>
            </div>

            <!-- MOBILE FOOTER VIEW -->
            <div class="block md:hidden relative z-10 pt-6 pb-4 w-full px-4 space-y-5 font-spinnaker">
                <div class="text-center space-y-2">
                    <img 
                        src="/images/Logo/worldine.png" 
                        alt="Worldine Destinations Logo" 
                        class="h-14 w-auto mx-auto object-contain" 
                    />
                    <p class="text-slate-300 text-[11px] font-normal leading-relaxed">
                        Worldine Destinations (Pvt) Ltd. Over 20 years of travel trade excellence.
                    </p>
                </div>
                <div class="text-center border-t border-white/15 pt-3 text-[11px] text-slate-400">
                    Copyright © 2026 Worldine Destinations (Pvt) Ltd.
                </div>
            </div>
        </footer>

    </div>
</template>
