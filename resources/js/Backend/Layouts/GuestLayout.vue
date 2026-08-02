<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen font-spinnaker bg-slate-950 text-slate-800 relative flex flex-col justify-between items-center overflow-x-hidden selection:bg-[#2196F3] selection:text-white">
        
        <!-- DYNAMIC TRAVEL BACKGROUND LAYER -->
        <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
            <img 
                src="/images/Logo/worldineback.png" 
                alt="Worldine Travel Background" 
                class="w-full h-full object-cover object-center opacity-30 scale-100"
            />
            <!-- Gradient Protection Overlays -->
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-[#0A2540]/85 to-[#0D47A1]/90"></div>
        </div>

        <!-- TOP BAR: BACK TO HOME & HELPLINE BADGE -->
        <header class="relative z-20 w-full max-w-7xl px-6 py-6 flex items-center justify-between">
            <Link 
                href="/" 
                class="inline-flex items-center space-x-2 bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-4 py-2 rounded-full border border-white/20 transition-all duration-300 transform hover:-translate-x-1 shadow-lg"
            >
                <span>←</span>
                <span>Back to Worldine Home</span>
            </Link>

            <!-- <div class="hidden sm:flex items-center space-x-2 bg-slate-900/60 text-slate-300 text-xs font-medium px-4 py-2 rounded-full border border-white/10">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>24/7 Helpline: +94 766 834 881</span>
            </div> -->
        </header>

        <!-- MAIN CENTER CONTENT CARD (SHARP SOLID WHITE) -->
        <main class="relative z-20 my-auto py-8 px-4 w-full flex flex-col items-center justify-center">
            <div class="w-full max-w-md sm:max-w-lg bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-slate-200 relative overflow-hidden">
                <!-- Top Brand Decorative Accent Bar -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#2196F3] via-[#2B70B4] to-[#0D47A1]"></div>

                <!-- Worldine Logo & Welcome Tagline -->
                <div class="flex flex-col items-center text-center space-y-2.5 mb-8">
                    <Link href="/" class="inline-block transition-transform hover:scale-105">
                        <img 
                            src="/images/Logo/worldine.png" 
                            alt="Worldine Destinations Logo" 
                            class="h-12 sm:h-14 w-auto object-contain drop-shadow-sm" 
                        />
                    </Link>
                    <p class="text-slate-500 text-xs sm:text-sm font-medium pt-1">
                        Sign in to manage Your Website Content.
                    </p>
                </div>

                <!-- Slot for Form Content -->
                <slot />
            </div>
        </main>

        <!-- FOOTER BRANDING -->
        <footer class="relative z-20 w-full py-5 text-center text-slate-400 text-xs font-medium">
            <p>© {{ new Date().getFullYear() }} Worldine Destinations. All rights reserved.</p>
        </footer>
    </div>
</template>
