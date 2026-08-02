<script setup>
import Navbar from '@/Frontend/Components/Navbar.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    destination: Object,
    packages: Array,
});

const selectedPackage = ref(null);
const isDetailModalOpen = ref(false);
const searchQuery = ref('all');

const updateSearchFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    const searchParam = params.get('search');
    if (searchParam) {
        searchQuery.value = searchParam;
    } else {
        searchQuery.value = 'all';
    }
};

onMounted(() => {
    updateSearchFromUrl();
});

const filteredPackages = computed(() => {
    if (!props.packages) return [];
    if (searchQuery.value === 'all') return props.packages;
    return props.packages.filter(p => 
        p.title.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
        (p.subtitle && p.subtitle.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
        (p.overview && p.overview.toLowerCase().includes(searchQuery.value.toLowerCase()))
    );
});

const openQuickDetail = (pkg) => {
    selectedPackage.value = pkg;
    isDetailModalOpen.value = true;
};
</script>

<template>
    <Head title="Sri Lanka Inbound Tours - Worldine Destinations" />

    <div class="min-h-screen font-spinnaker bg-slate-50 text-slate-800 selection:bg-[#2196F3] selection:text-white w-full overflow-x-hidden">
        <Navbar />

        <!-- SRI LANKA HERO BANNER -->
        <section class="relative h-[65vh] min-h-[420px] flex items-center justify-center bg-slate-950 text-white overflow-hidden w-full">
            <div class="absolute inset-0 z-0">
                <img 
                    src="https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1600&q=80" 
                    alt="Sri Lanka Inbound Expeditions" 
                    class="w-full h-full object-cover object-center"
                    fetchpriority="high"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/70"></div>
            </div>

            <div class="relative z-10 text-center max-w-4xl px-6 space-y-4">
                <span class="text-xs font-black uppercase tracking-[0.3em] text-[#2196F3] bg-[#E3F2FD] px-4 py-1.5 rounded-full border border-[#90CAF9]/40 inline-block shadow-md">
                    SRI LANKA INBOUND TOURS
                </span>
                <h1 class="text-3xl sm:text-6xl font-black tracking-tight text-white uppercase leading-tight">
                    The Pearl of the Indian Ocean
                </h1>
                <p class="text-slate-200 text-xs sm:text-base max-w-2xl mx-auto font-medium leading-relaxed">
                    Explore ancient UNESCO fortresses, misty Ceylon tea hills, wild elephant safaris, and pristine golden coastlines with 20+ years of local Sri Lankan travel expertise.
                </p>
            </div>
        </section>

        <!-- SRI LANKA TOUR PACKAGES GRID -->
        <section class="py-16 sm:py-24 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full flex flex-col md:flex-row md:items-end justify-between mb-10">
                <div>
                    <span class="text-[#2196F3] text-xs font-black uppercase tracking-widest">CURATED INBOUND ITINERARIES</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Sri Lanka Tour Packages</h2>
                </div>
                <p class="text-slate-600 text-xs sm:text-sm max-w-md mt-2 md:mt-0 font-medium leading-relaxed">
                    Handpicked itineraries featuring 5-star resort stays, private luxury transport, and local expert guides.
                </p>
            </div>

            <div v-if="filteredPackages && filteredPackages.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 w-full">
                <div 
                    v-for="pkg in filteredPackages" 
                    :key="pkg.id"
                    class="group bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col transform hover:-translate-y-1"
                >
                    <div class="relative h-56 sm:h-64 overflow-hidden">
                        <img :src="pkg.main_image" :alt="pkg.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-white/95 text-slate-900 border border-slate-200 font-extrabold text-[11px] px-3 py-1 rounded-full shadow">
                            {{ pkg.badge || 'Sri Lanka Inbound' }}
                        </span>
                        <div class="absolute bottom-4 left-4 right-4 text-white flex justify-between items-end">
                            <span v-if="pkg.price && Number(pkg.price) > 0" class="text-2xl font-black">${{ Number(pkg.price).toLocaleString() }}</span>
                            <span v-else class="text-xs font-extrabold bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">Inquire for Quote</span>
                            <span class="text-xs font-bold bg-white/20 backdrop-blur-md px-3 py-1 rounded-full border border-white/30">{{ pkg.duration_days }} Days</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-xl font-black text-slate-900 leading-tight group-hover:text-[#2196F3] transition-colors">{{ pkg.title }}</h3>
                            <p class="text-slate-600 text-xs font-medium line-clamp-2 leading-relaxed">{{ pkg.subtitle || pkg.overview }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <Link 
                                :href="route('tours.show', pkg.slug)"
                                class="px-5 py-2.5 rounded-full bg-[#0D47A1] text-white text-xs font-extrabold shadow-md hover:bg-[#1565C0] transition-all flex items-center space-x-1.5"
                            >
                                <span>View Day-by-Day Itinerary</span>
                                <span>→</span>
                            </Link>

                            <button 
                                @click="openQuickDetail(pkg)"
                                class="px-4 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all"
                            >
                                Quick View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- QUICK DETAIL MODAL -->
        <div v-if="isDetailModalOpen && selectedPackage" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
            <div class="bg-white w-full max-w-2xl rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 max-h-[85vh] overflow-y-auto">
                <div class="flex justify-between items-start border-b border-slate-100 pb-4">
                    <div>
                        <span class="text-xs font-extrabold uppercase text-[#2196F3]">{{ selectedPackage.duration_days }} Days Expedition</span>
                        <h2 class="text-2xl font-black text-slate-900 mt-0.5">{{ selectedPackage.title }}</h2>
                    </div>
                    <button @click="isDetailModalOpen = false" class="text-slate-400 font-bold text-lg">✕</button>
                </div>

                <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ selectedPackage.overview }}</p>

                <!-- Itinerary Days list -->
                <div v-if="selectedPackage.itinerary_days && selectedPackage.itinerary_days.length" class="space-y-3">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">Day-by-Day Highlights</h3>
                    <div v-for="day in selectedPackage.itinerary_days" :key="day.id" class="p-3 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-start space-x-3">
                        <span class="text-xs font-black bg-[#0D47A1] text-white px-2.5 py-1 rounded-full flex-shrink-0">Day {{ day.day_number }}</span>
                        <div>
                            <div class="text-xs font-bold text-slate-900">{{ day.title }}</div>
                            <div class="text-[11px] text-slate-600 mt-0.5">{{ day.description }}</div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                    <span v-if="selectedPackage.price && Number(selectedPackage.price) > 0" class="text-xl font-black text-[#0D47A1]">${{ Number(selectedPackage.price).toLocaleString() }} USD</span>
                    <span v-else class="text-xs font-black bg-blue-50 text-[#0D47A1] px-3.5 py-2 rounded-xl border border-blue-100">Custom Tour • Inquire for Quote</span>
                    <Link :href="route('tours.show', selectedPackage.slug)" class="px-6 py-2.5 rounded-full bg-[#2196F3] text-white text-xs font-extrabold shadow-md hover:bg-[#0D47A1] transition-all">
                        Full Itinerary & Booking Page →
                    </Link>
                </div>
            </div>
        </div>

    </div>
</template>
