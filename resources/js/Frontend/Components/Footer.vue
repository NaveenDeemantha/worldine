<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    settings: {
        type: Object,
        default: () => ({})
    }
});
</script>

<template>
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
        <div class="hidden md:block relative z-10 pt-10 pb-6 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 font-spinnaker">
            <div class="w-full grid grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- Column 1: Logo & Branding -->
                <div class="space-y-4">
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
                            <a href="https://www.facebook.com/worldinedestinations" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#2196F3] text-white flex items-center justify-center transition-all border border-white/15" aria-label="Facebook">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="https://www.instagram.com/worldinedestinations" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center transition-all border border-white/15" aria-label="Instagram">
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

                <!-- Column 4: Contact & Payment Methods -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Hotline & Office
                        </h4>
                        <ul class="space-y-1.5 text-xs font-semibold text-slate-200 mt-2.5">
                            <li>
                                <a :href="`tel:${(settings?.landline_phone || '+94112636558').replace(/\s+/g, '')}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>Land: {{ settings?.landline_phone || '+94 11 263 6558' }}</span>
                                </a>
                            </li>
                            <li>
                                <a :href="`tel:${(settings?.primary_phone || '+94766834881').replace(/\s+/g, '')}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>Mob: {{ settings?.primary_phone || '+94 766 834 881' }}</span>
                                </a>
                            </li>
                            <li>
                                <a :href="`tel:${(settings?.outbound_phone || '+94718834881').replace(/\s+/g, '')}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>Mob: {{ settings?.outbound_phone || '+94 718 834 881' }}</span>
                                </a>
                            </li>
                            <li>
                                <a :href="`tel:${(settings?.inbound_phone || '+9477869229').replace(/\s+/g, '')}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>Mob: {{ settings?.inbound_phone || '+94 778 692 229' }}</span>
                                </a>
                            </li>
                            <li>
                                <a :href="`mailto:${settings?.primary_email || 'info@worldinedestinations.com'}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    <span class="truncate">{{ settings?.primary_email || 'info@worldinedestinations.com' }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Accepted Payment Options (Desktop) -->
                    <div class="pt-2 border-t border-white/10">
                        <span class="text-[10px] font-bold text-[#90CAF9] uppercase tracking-wider block mb-2">
                            Accepted Payment Options
                        </span>
                        <div class="flex items-center flex-wrap gap-2.5">
                            <div class="bg-white/95 hover:bg-white px-2.5 py-1 rounded-xl border border-white/20 shadow-sm transition-transform hover:scale-105 flex items-center justify-center h-8 shrink-0">
                                <img src="/images/Logo/vsms.png" alt="Visa and MasterCard Accepted" class="h-5 max-h-5 w-auto max-w-[70px] object-contain block" />
                            </div>
                            <div class="bg-white/95 hover:bg-white px-2.5 py-1 rounded-xl border border-white/20 shadow-sm transition-transform hover:scale-105 flex items-center justify-center h-8 shrink-0">
                                <img src="/images/Logo/koko pay.png" alt="KOKO Pay - Buy Now Pay Later" class="h-4 max-h-4 w-auto max-w-[60px] object-contain block" />
                            </div>
                        </div>
                        <span class="text-[10px] text-slate-400 block mt-1.5 font-medium">Card & KOKO Payments</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright Bar (Desktop) -->
            <div class="mt-8 pt-4 border-t border-white/15 flex flex-row items-center justify-between gap-4 text-[11px] text-slate-400 font-spinnaker">
                <div>
                    Copyright © 2026 Worldine Destinations (Pvt) Ltd. All Rights Reserved.
                </div>

                <div class="flex items-center space-x-2">
                    <span class="text-[10px] text-slate-400">Secure Payments via</span>
                    <div class="flex items-center space-x-2">
                        <img src="/images/Logo/vsms.png" alt="Visa MasterCard" class="h-4 max-h-4 w-auto max-w-[50px] bg-white/90 px-1 py-0.5 rounded object-contain block" />
                        <img src="/images/Logo/koko pay.png" alt="KOKO" class="h-3.5 max-h-3.5 w-auto max-w-[45px] bg-white/90 px-1 py-0.5 rounded object-contain block" />
                    </div>
                </div>
            </div>
        </div>

        <!-- MOBILE FOOTER VIEW (block md:hidden) -->
        <div class="block md:hidden relative z-10 pt-8 pb-6 w-full px-5 space-y-6 font-spinnaker">
            
            <!-- Company Branding & Socials -->
            <div class="space-y-3 pb-5 border-b border-white/15">
                <div class="flex items-center justify-between">
                    <Link href="/" class="inline-block group">
                        <img 
                            src="/images/Logo/worldine.png" 
                            alt="Worldine Destinations Logo" 
                            class="h-14 w-auto object-contain filter drop-shadow-md" 
                        />
                    </Link>

                    <!-- Social Media Links -->
                    <div class="flex items-center space-x-2">
                        <a href="https://www.facebook.com/worldinedestinations" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#2196F3] text-white flex items-center justify-center font-bold text-xs transition-all border border-white/15 shadow-xs active:scale-95" aria-label="Facebook">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://www.instagram.com/worldinedestinations" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center font-bold text-xs transition-all border border-white/15 shadow-xs active:scale-95" aria-label="Instagram">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <p class="text-slate-300 text-xs leading-relaxed font-normal">
                    Worldine Destinations (Pvt) Ltd. Over 20 years of experience in the travel trade with deep knowledge in Ticketing, Visas, Outbound & Inbound tours, and Travel Insurance.
                </p>
            </div>

            <!-- 3-Column Navigation & Contact Grid -->
            <div class="grid grid-cols-3 gap-2.5 sm:gap-3 text-[10px] sm:text-xs pb-5 border-b border-white/15">
                <!-- Column 1: Quick Links -->
                <div class="space-y-2">
                    <h4 class="text-[#90CAF9] font-bold text-[11px] sm:text-xs uppercase tracking-wider border-b border-white/15 pb-1 font-spinnaker">
                        Quick Links
                    </h4>
                    <ul class="space-y-1.5 text-slate-200 font-semibold">
                        <li><Link href="/" class="hover:text-[#90CAF9] block transition-colors">Home</Link></li>
                        <li><Link href="/srilanka" class="hover:text-[#90CAF9] block transition-colors">Sri Lanka</Link></li>
                        <li><Link href="/destinations" class="hover:text-[#90CAF9] block transition-colors">Destinations</Link></li>
                        <li><Link href="/services" class="hover:text-[#90CAF9] block transition-colors">Our Services</Link></li>
                        <li><Link href="/contact" class="hover:text-[#90CAF9] block transition-colors">Contact</Link></li>
                    </ul>
                </div>

                <!-- Column 2: Tour Expeditions -->
                <div class="space-y-2">
                    <h4 class="text-[#90CAF9] font-bold text-[11px] sm:text-xs uppercase tracking-wider border-b border-white/15 pb-1 font-spinnaker">
                        Tours
                    </h4>
                    <ul class="space-y-1.5 text-slate-200 font-semibold">
                        <li><Link href="/srilanka" class="hover:text-[#90CAF9] block transition-colors">Sri Lanka</Link></li>
                        <li><Link href="/destinations?region=maldives-paradise" class="hover:text-[#90CAF9] block transition-colors">Maldives</Link></li>
                        <li><Link href="/destinations?region=dubai-uae" class="hover:text-[#90CAF9] block transition-colors">Dubai & UAE</Link></li>
                        <li><Link href="/destinations?region=switzerland-europe" class="hover:text-[#90CAF9] block transition-colors">Schengen</Link></li>
                    </ul>
                </div>

                <!-- Column 3: Hotline & Office Contacts -->
                <div class="space-y-2">
                    <h4 class="text-[#90CAF9] font-bold text-[11px] sm:text-xs uppercase tracking-wider border-b border-white/15 pb-1 font-spinnaker">
                        Hotline
                    </h4>
                    <ul class="space-y-1 text-slate-200 font-semibold">
                        <li>
                            <a :href="`tel:${(settings?.landline_phone || '+94112636558').replace(/\s+/g, '')}`" class="hover:text-[#90CAF9] block leading-snug">
                                <span class="text-[9px] text-[#90CAF9] block font-bold">Landline</span>
                                <span class="truncate block text-[10px]">{{ settings?.landline_phone || '+94 11 263 6558' }}</span>
                            </a>
                        </li>
                        <li>
                            <a :href="`tel:${(settings?.primary_phone || '+94766834881').replace(/\s+/g, '')}`" class="hover:text-[#90CAF9] block leading-snug">
                                <span class="text-[9px] text-[#90CAF9] block font-bold">Primary</span>
                                <span class="truncate block text-[10px]">{{ settings?.primary_phone || '+94 766 834 881' }}</span>
                            </a>
                        </li>
                        <li>
                            <a :href="`tel:${(settings?.outbound_phone || '+94718834881').replace(/\s+/g, '')}`" class="hover:text-[#90CAF9] block leading-snug">
                                <span class="text-[9px] text-[#90CAF9] block font-bold">Outbound</span>
                                <span class="truncate block text-[10px]">{{ settings?.outbound_phone || '+94 718 834 881' }}</span>
                            </a>
                        </li>
                        <li>
                            <a :href="`tel:${(settings?.inbound_phone || '+9477869229').replace(/\s+/g, '')}`" class="hover:text-[#90CAF9] block leading-snug">
                                <span class="text-[9px] text-[#90CAF9] block font-bold">Inbound</span>
                                <span class="truncate block text-[10px]">{{ settings?.inbound_phone || '+94 778 692 229' }}</span>
                            </a>
                        </li>
                        <li>
                            <a :href="`mailto:${settings?.primary_email || 'info@worldinedestinations.com'}`" class="hover:text-[#90CAF9] block leading-snug">
                                <span class="text-[9px] text-[#90CAF9] block font-bold">Email</span>
                                <span class="truncate block text-[10px]">{{ settings?.primary_email || 'info@worldinedestinations.com' }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Accepted Payments in Mobile -->
            <div class="space-y-2 pb-4">
                <span class="text-[10px] font-bold text-[#90CAF9] uppercase tracking-wider block text-center">
                    Accepted Payment Options
                </span>
                <div class="flex items-center justify-center space-x-3">
                    <div class="bg-white/95 px-3 py-1 rounded-xl border border-white/20 shadow-xs flex items-center justify-center h-8 shrink-0">
                        <img src="/images/Logo/vsms.png" alt="Visa and MasterCard" class="h-5 max-h-5 w-auto max-w-[70px] object-contain block" />
                    </div>
                    <div class="bg-white/95 px-3 py-1 rounded-xl border border-white/20 shadow-xs flex items-center justify-center h-8 shrink-0">
                        <img src="/images/Logo/koko pay.png" alt="KOKO Pay" class="h-4 max-h-4 w-auto max-w-[60px] object-contain block" />
                    </div>
                </div>
                <p class="text-[10px] text-center text-slate-400">Card Payments & Installments with KOKO</p>
            </div>

            <!-- Mobile Bottom Copyright & Security Bar -->
            <div class="pt-4 border-t border-white/15 space-y-2 text-center text-[10px] text-slate-400 font-spinnaker">
                <div>Copyright © 2026 Worldine Destinations (Pvt) Ltd. All Rights Reserved.</div>
                <div class="flex items-center justify-center space-x-2 pt-1">
                    <span>Secure Payments via</span>
                    <img src="/images/Logo/vsms.png" alt="Visa MasterCard" class="h-3.5 max-h-3.5 w-auto max-w-[45px] bg-white/90 px-1 py-0.5 rounded object-contain inline-block" />
                    <img src="/images/Logo/koko pay.png" alt="KOKO" class="h-3 max-h-3 w-auto max-w-[40px] bg-white/90 px-1 py-0.5 rounded object-contain inline-block" />
                </div>
            </div>
        </div>

        <!-- DEDICATED BOTTOM STRIP FOR DEVELOPER CREDIT -->
        <div class="relative z-10 w-full bg-black/70 border-t border-white/10 py-2.5 px-4 text-center font-spinnaker">
            <a 
                href="https://hoomansdigital.com" 
                target="_blank" 
                rel="noopener noreferrer" 
                class="inline-flex items-center justify-center flex-wrap gap-2 text-[11px] sm:text-xs text-slate-300 hover:text-white transition-all group"
            >
                <span class="text-slate-400 group-hover:text-slate-200">System Designed, Developed & Hosted By</span>
                <img 
                    src="/images/Logo/digi logo.png" 
                    alt="Hoomans Digital" 
                    class="object-contain inline-block transition-transform group-hover:scale-105" 
                    style="height: 14px; max-height: 16px; width: auto; filter: brightness(0) invert(1);" 
                />
            </a>
        </div>
    </footer>
</template>
