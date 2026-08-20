<script setup>
import Navbar from '@/Frontend/Components/Navbar.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    package: Object,
    relatedPackages: Array,
});

const page = usePage();
const showSuccessBanner = ref(false);

const form = useForm({
    tour_package_id: props.package ? props.package.id : null,
    package_title: props.package ? props.package.title : '',
    customer_name: '',
    email: '',
    phone: '',
    travel_date: '',
    guests: 2,
    message: '',
});

const submitInquiry = () => {
    form.post(route('tours.inquire'), {
        preserveScroll: true,
        onSuccess: () => {
            showSuccessBanner.value = true;
            form.reset('customer_name', 'email', 'phone', 'travel_date', 'message');
            setTimeout(() => {
                showSuccessBanner.value = false;
            }, 6000);
        },
    });
};

const formatDescription = (text) => {
    if (!text) return '';
    const escaped = text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    return escaped.replace(/\*\*(.*?)\*\*/g, '<strong class="font-extrabold text-slate-900">$1</strong>');
};
</script>

<template>
    <Head :title="`${package.title} - Worldine Destinations`" />

    <div class="min-h-screen font-spinnaker bg-slate-50 text-slate-800 selection:bg-[#2196F3] selection:text-white w-full overflow-x-hidden">
        <Navbar />

        <!-- TOUR HERO BANNER -->
        <section class="relative h-[70vh] min-h-[480px] flex items-end justify-start bg-slate-950 text-white overflow-hidden w-full pb-12 px-6 sm:px-12 lg:px-20">
            <div class="absolute inset-0 z-0">
                <img 
                    :src="package.main_image" 
                    :alt="package.title" 
                    class="w-full h-full object-cover object-center"
                    fetchpriority="high"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-slate-950/40"></div>
            </div>

            <div class="relative z-10 max-w-4xl space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-xs font-black uppercase tracking-[0.25em] text-[#2196F3] bg-[#E3F2FD] px-4 py-1.5 rounded-full border border-[#90CAF9]/40 shadow-md">
                        {{ package.destination ? package.destination.name : 'WORLDINE TOUR' }}
                    </span>
                    <span class="text-xs font-extrabold uppercase bg-white/20 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/30 text-white">
                        {{ (package.itinerary_days && package.itinerary_days.length > 0) ? package.itinerary_days.length : package.duration_days }} Days Expedition
                    </span>
                    <span v-if="package.badge" class="text-xs font-extrabold uppercase bg-amber-500 text-slate-950 px-3.5 py-1.5 rounded-full shadow">
                        {{ package.badge }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white uppercase leading-tight">
                    {{ package.title }}
                </h1>
                <p class="text-slate-200 text-sm sm:text-base max-w-2xl font-medium leading-relaxed">
                    {{ package.subtitle || package.overview }}
                </p>
            </div>
        </section>

        <!-- MAIN LAYOUT: DAY-BY-DAY ITINERARY & INQUIRY FORM -->
        <section class="py-14 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">
                
                <!-- Left Column: Overview & Complete Day-by-Day Itinerary -->
                <div class="lg:col-span-8 space-y-10">
                    
                    <!-- Overview Card -->
                    <div class="bg-white p-7 sm:p-9 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                        <h2 class="text-xl font-black text-slate-900 uppercase tracking-tight">Tour Overview</h2>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">{{ package.overview }}</p>

                        <!-- Key Highlights & Inclusions -->
                        <div v-if="package.inclusions && package.inclusions.length" class="pt-4 border-t border-slate-100">
                            <h3 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-3">Package Inclusions & VIP Services</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <div v-for="(inc, i) in package.inclusions" :key="i" class="flex items-center space-x-2 text-xs font-bold text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-200/60">
                                    <span class="text-emerald-500 font-extrabold">✓</span>
                                    <span>{{ inc }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DAY-BY-DAY ITINERARY LIST WITH PHOTOS -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-black text-slate-900">Full Day-by-Day Itinerary</h2>
                            <span class="text-xs font-extrabold text-[#2196F3] bg-[#E3F2FD] px-3.5 py-1.5 rounded-full border border-[#90CAF9]/40">
                                {{ package.itinerary_days ? package.itinerary_days.length : 0 }} Detailed Days
                            </span>
                        </div>

                        <div 
                            v-for="day in package.itinerary_days" 
                            :key="day.id"
                            class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 p-6 sm:p-8 space-y-5"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                                <div class="flex items-center space-x-3">
                                    <span class="px-3.5 py-1.5 rounded-full bg-[#0D47A1] text-white font-black text-xs tracking-wider flex items-center justify-center shadow-xs flex-shrink-0 uppercase whitespace-nowrap">
                                        Day-{{ String(day.day_number).padStart(2, '0') }}
                                    </span>
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-snug">{{ day.title }}</h3>
                                </div>
                                <span v-if="day.accommodation && day.accommodation.trim() && day.accommodation.trim() !== '-'" class="text-xs font-bold text-slate-600 bg-slate-100/90 px-3.5 py-1.5 rounded-full border border-slate-200/60 w-fit flex items-center space-x-1.5 flex-shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-500 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12h12"/><path d="M6 7h12"/><path d="M6 17h12"/></svg>
                                    <span>{{ day.accommodation }}</span>
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                                <div :class="[day.image ? 'md:col-span-7' : 'md:col-span-12', 'flex flex-col justify-center space-y-3']">
                                    <p class="text-slate-600 text-xs sm:text-sm font-medium leading-relaxed whitespace-pre-line" v-html="formatDescription(day.description)">
                                    </p>
                                </div>

                                <div v-if="day.image" class="md:col-span-5 flex items-center justify-center">
                                    <div class="w-full h-full min-h-[180px] sm:min-h-[220px] max-h-[300px] rounded-2xl overflow-hidden shadow-sm border border-slate-100 group relative">
                                        <img 
                                            :src="day.image" 
                                            :alt="day.title" 
                                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Pricing, Inquiry Form, Related Tours & Concierge Card -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Main Sticky Booking Card -->
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-xl space-y-6">
                        <div class="border-b border-slate-100 pb-5 text-center">
                            <template v-if="package.price && Number(package.price) > 0">
                                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">STARTING FROM</span>
                                <div class="text-4xl font-black text-[#0D47A1] mt-1">${{ Number(package.price).toLocaleString() }} <span class="text-xs text-slate-400 font-semibold">/ person</span></div>
                                <p class="text-xs text-emerald-600 font-bold mt-1">✓ No Hidden Booking Fees</p>
                            </template>
                            <template v-else>
                                <span class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">CUSTOM TOUR PACKAGE</span>
                                <div class="text-2xl font-black text-[#0D47A1] mt-1">Inquire for Price</div>
                                <p class="text-xs text-emerald-600 font-bold mt-1">✓ Personalised Itinerary & Quote</p>
                            </template>
                        </div>

                        <div v-if="showSuccessBanner || page.props.flash?.success" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold leading-relaxed">
                            ✓ Thank you! Your tour inquiry has been submitted. Our concierge team will contact you shortly.
                        </div>

                        <form @submit.prevent="submitInquiry" class="space-y-4">
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">Inquire / Book This Tour</h3>

                            <div>
                                <input type="text" v-model="form.customer_name" required placeholder="Your Full Name" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-[#2196F3] outline-none" />
                            </div>

                            <div>
                                <input type="email" v-model="form.email" required placeholder="Email Address" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-[#2196F3] outline-none" />
                            </div>

                            <div>
                                <input type="tel" v-model="form.phone" required placeholder="Phone / WhatsApp Number" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 placeholder-slate-400 focus:bg-white focus:border-[#2196F3] outline-none" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <input type="date" v-model="form.travel_date" required class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 focus:bg-white focus:border-[#2196F3] outline-none" />
                                <input type="number" v-model="form.guests" min="1" required placeholder="Guests" class="w-full px-3 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-bold text-slate-900 focus:bg-white focus:border-[#2196F3] outline-none" />
                            </div>

                            <textarea v-model="form.message" rows="3" placeholder="Special requests or custom dates..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-xs font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:border-[#2196F3] outline-none"></textarea>

                            <button 
                                type="submit" 
                                class="w-full py-4 rounded-2xl bg-gradient-to-r from-[#2196F3] via-[#2B70B4] to-[#0D47A1] text-white font-extrabold text-xs uppercase tracking-widest shadow-xl hover:shadow-2xl hover:brightness-110 active:scale-[0.99] transition-all duration-300 flex items-center justify-center space-x-2 disabled:opacity-50"
                                :disabled="form.processing"
                            >
                                <span>{{ form.processing ? 'Sending Inquiry...' : 'Request Tour Quote' }}</span>
                                <span>→</span>
                            </button>
                        </form>

                        <div class="pt-4 border-t border-slate-100 text-center space-y-1.5 text-slate-500 text-xs">
                            <div class="flex items-center justify-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>Direct Concierge: +94 766 834 881</span>
                            </div>
                            <div class="flex items-center justify-center space-x-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                <span>Email: info@worldinedestinations.com</span>
                            </div>
                        </div>
                    </div>

                    <!-- RELATED TOUR PACKAGES SIDEBAR CARD -->
                    <div v-if="relatedPackages && relatedPackages.length > 0" class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h3 class="text-xs font-black uppercase text-slate-900 tracking-wider">Explore Similar Tours</h3>
                            <span class="text-[10px] font-extrabold text-[#2196F3] bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-200">
                                Recommended
                            </span>
                        </div>

                        <div class="space-y-3">
                            <Link 
                                v-for="relPkg in relatedPackages" 
                                :key="relPkg.id" 
                                :href="`/tours/${relPkg.slug}`" 
                                class="group flex items-start space-x-3.5 p-3 rounded-2xl border border-slate-100 hover:border-sky-300 hover:bg-slate-50/80 transition-all duration-300"
                            >
                                <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200/60 relative">
                                    <img 
                                        :src="relPkg.main_image || '/images/Logo/worldineback.png'" 
                                        :alt="relPkg.title" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                                    />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-[9px] font-extrabold text-[#2196F3] uppercase tracking-wider block">
                                        {{ relPkg.destination ? relPkg.destination.name : 'Worldine Tour' }}
                                    </span>
                                    <h4 class="text-xs font-black text-slate-900 group-hover:text-[#2196F3] transition-colors line-clamp-1 leading-snug">
                                        {{ relPkg.title }}
                                    </h4>
                                    <div class="flex items-center justify-between mt-1 text-[10px] text-slate-500 font-bold">
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-3 h-3 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <span>{{ relPkg.duration_days }} Days</span>
                                        </span>
                                        <span v-if="relPkg.price && Number(relPkg.price) > 0" class="text-[#0D47A1] font-black">
                                            ${{ Number(relPkg.price).toLocaleString() }}
                                        </span>
                                        <span v-else class="text-emerald-600 font-bold">
                                            Inquire
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>

                    <!-- INSTANT WHATSAPP & CONCIERGE ASSISTANCE CARD -->
                    <div class="bg-gradient-to-br from-slate-900 via-[#0D47A1] to-[#1565C0] p-6 rounded-3xl text-white shadow-md space-y-3 relative overflow-hidden">
                        <div class="relative z-10 space-y-2">
                            <div class="flex items-center space-x-2 text-xs font-bold text-sky-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Instant Concierge Assistance</span>
                            </div>
                            <h4 class="text-base font-black text-white">Need a Custom Itinerary?</h4>
                            <p class="text-xs text-slate-200 font-medium leading-relaxed">
                                Our travel specialists can customize dates, luxury hotels, and private transfers for your exact itinerary.
                            </p>
                            <div class="pt-2">
                                <a 
                                    href="https://wa.me/94766834881" 
                                    target="_blank" 
                                    class="w-full py-3 px-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs flex items-center justify-center space-x-2 shadow-sm transition-all hover:scale-[1.02]"
                                >
                                    <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l.999 1.595-1.152 4.21 4.316-1.132 1.58.994z"/></svg>
                                    <span>Chat on WhatsApp (+94 766 834 881)</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </div>
</template>
