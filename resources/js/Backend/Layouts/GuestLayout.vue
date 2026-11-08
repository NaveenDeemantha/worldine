<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="h-[100svh] min-h-[100svh] max-h-[100svh] sm:h-auto sm:min-h-screen sm:max-h-none font-aptos bg-slate-950 text-slate-800 relative flex flex-col justify-between items-center overflow-x-hidden overflow-y-auto sm:overflow-visible selection:bg-[#2196F3] selection:text-white">
        
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

        <!-- TOP BAR: BACK TO HOME -->
        <header class="relative z-20 w-full max-w-7xl px-3 pt-2 pb-0.5 sm:px-6 sm:py-5 flex items-center justify-between shrink-0">
            <Link 
                href="/" 
                class="inline-flex items-center space-x-1 sm:space-x-2 bg-white/10 hover:bg-white/20 text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 sm:px-4 sm:py-2 rounded-full border border-white/20 transition-all duration-300 transform hover:-translate-x-1 shadow-xs"
            >
                <span>←</span>
                <span>Back to Worldine Home</span>
            </Link>
        </header>

        <!-- MAIN CENTER CONTENT CARD (SHARP SOLID WHITE) -->
        <main class="relative z-20 flex-1 w-full px-3 sm:px-4 py-1 sm:py-6 flex flex-col items-center justify-center shrink-0 min-h-0">
            <div class="w-full max-w-[340px] xs:max-w-[360px] sm:max-w-md bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 md:p-9 shadow-xl border border-slate-200 relative overflow-hidden">
                <!-- Top Brand Decorative Accent Bar -->
                <div class="absolute top-0 left-0 right-0 h-1 sm:h-1.5 bg-gradient-to-r from-[#2196F3] via-[#2B70B4] to-[#0D47A1]"></div>

                <!-- Worldine Logo & Welcome Tagline -->
                <div class="flex flex-col items-center text-center space-y-1 sm:space-y-2 mb-2.5 sm:mb-7">
                    <Link href="/" class="inline-block transition-transform hover:scale-105">
                        <img 
                            src="/images/Logo/worldine.png" 
                            alt="Worldine Destinations Logo" 
                            class="h-8 sm:h-13 w-auto object-contain drop-shadow-sm" 
                        />
                    </Link>
                    <p class="text-slate-500 text-[10px] sm:text-sm font-medium">
                        Sign in to manage Your Website Content.
                    </p>
                </div>

                <!-- Slot for Form Content -->
                <slot />
            </div>
        </main>

        <!-- FOOTER BRANDING & DEVELOPER CREDIT -->
        <footer class="relative z-20 w-full shrink-0 flex flex-col items-center text-center font-aptos">
            <div class="py-0.5 sm:py-2 text-slate-400 text-[9px] sm:text-xs font-medium">
                <p>© {{ new Date().getFullYear() }} Worldine Destinations. All rights reserved.</p>
            </div>
            
            <!-- DEDICATED BOTTOM STRIP FOR DEVELOPER CREDIT -->
            <div class="w-full bg-black/60 border-t border-white/10 py-1 sm:py-2 px-3 text-center">
                <a 
                    href="https://hoomansdigital.com" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    class="inline-flex items-center justify-center flex-wrap gap-1 text-[9px] sm:text-[11px] text-slate-300 hover:text-white transition-all group"
                >
                    <span class="text-slate-400 group-hover:text-slate-200">System Designed, Developed & Hosted By</span>
                    <img 
                        src="/images/Logo/digi logo.png" 
                        alt="Hoomans Digital" 
                        class="object-contain inline-block transition-transform group-hover:scale-105" 
                        style="height: 10px; max-height: 12px; width: auto; filter: brightness(0) invert(1);" 
                    />
                </a>
            </div>
        </footer>
    </div>
</template>
