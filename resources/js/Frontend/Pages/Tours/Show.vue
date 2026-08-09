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
                            class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 p-6 sm:p-8 space-y-4"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
                                <div class="flex items-center space-x-3">
                                    <span class="px-3.5 py-1.5 rounded-full bg-[#0D47A1] text-white font-black text-xs tracking-wider flex items-center justify-center shadow-sm flex-shrink-0 uppercase whitespace-nowrap">
                                        Day-{{ String(day.day_number).padStart(2, '0') }}
                                    </span>
                                    <h3 class="text-lg font-black text-slate-900">{{ day.title }}</h3>
                                </div>
                                <span v-if="day.accommodation" class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full w-fit">
                                    🏨 {{ day.accommodation }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                                <div :class="[day.image ? 'md:col-span-7' : 'md:col-span-12', 'space-y-3']">
                                    <p class="text-slate-600 text-xs sm:text-sm font-medium leading-relaxed">
                                        {{ day.description }}
                                    </p>
                                    <div v-if="day.meals" class="text-xs font-extrabold text-[#2196F3]">
                                        🍽️ Meals: {{ day.meals }}
                                    </div>
                                </div>

                                <div v-if="day.image" class="md:col-span-5 h-44 sm:h-52 rounded-2xl overflow-hidden shadow-md">
                                    <img :src="day.image" :alt="day.title" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Pricing & Booking Inquiry Card -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-xl space-y-6 sticky top-24">
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

                        <div class="pt-4 border-t border-slate-100 text-center space-y-1 text-slate-500 text-xs">
                            <div>📞 Direct Concierge: +94 766 834 881</div>
                            <div>✉️ Email: info@worldinedestinations.com</div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</template>
