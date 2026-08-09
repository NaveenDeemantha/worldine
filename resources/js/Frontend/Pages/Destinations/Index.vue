<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Navbar from '@/Frontend/Components/Navbar.vue';

const props = defineProps({
    destinations: Array,
    packages: Array,
});

const page = usePage();
const selectedRegion = ref('all');

const updateRegionFromUrl = () => {
    const params = new URLSearchParams(window.location.search);
    const regionParam = params.get('region');
    if (regionParam) {
        selectedRegion.value = regionParam;
    } else {
        selectedRegion.value = 'all';
    }
};

onMounted(() => {
    updateRegionFromUrl();
});

watch(() => page.url, () => {
    updateRegionFromUrl();
});

const filteredOutboundPackages = computed(() => {
    if (selectedRegion.value === 'all') return props.packages;
    return props.packages.filter(p => p.destination && (p.destination.slug.toLowerCase() === selectedRegion.value.toLowerCase() || p.destination.slug.toLowerCase().includes(selectedRegion.value.toLowerCase())));
});

const activeDestination = computed(() => {
    if (selectedRegion.value !== 'all' && props.destinations) {
        return props.destinations.find(d => d.slug.toLowerCase() === selectedRegion.value.toLowerCase() || d.slug.toLowerCase().includes(selectedRegion.value.toLowerCase())) || null;
    }
    return null;
});

const activeHeroImage = computed(() => {
    if (activeDestination.value && activeDestination.value.image) {
        return activeDestination.value.image;
    }
    return 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=1600&q=80';
});
</script>

<template>
    <Head title="Outbound Destinations & Global Tours - Worldine Destinations" />

    <div class="min-h-screen font-spinnaker bg-slate-50 text-slate-800 selection:bg-[#2196F3] selection:text-white w-full overflow-x-hidden">
        <Navbar />

        <!-- HERO BANNER -->
        <section class="relative h-[65vh] min-h-[420px] flex items-center justify-center bg-slate-950 text-white overflow-hidden w-full">
            <div class="absolute inset-0 z-0">
                <img 
                    :src="activeHeroImage" 
                    :alt="activeDestination ? activeDestination.name : 'Global Outbound Destinations'" 
                    class="w-full h-full object-cover object-center transition-all duration-700"
                    fetchpriority="high"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-slate-950/70"></div>
            </div>

            <div class="relative z-10 text-center max-w-4xl px-6 space-y-4">
                <span class="text-xs font-black uppercase tracking-[0.3em] text-[#2196F3] bg-[#E3F2FD] px-4 py-1.5 rounded-full border border-[#90CAF9]/40 inline-block shadow-md">
                    {{ activeDestination ? (activeDestination.badge || activeDestination.name) : 'GLOBAL OUTBOUND EXPEDITIONS' }}
                </span>
                <h1 class="text-3xl sm:text-6xl font-black tracking-tight text-white uppercase leading-tight">
                    {{ activeDestination ? activeDestination.name : 'Explore The World With Worldine' }}
                </h1>
                <p class="text-slate-200 text-xs sm:text-base max-w-2xl mx-auto font-medium leading-relaxed">
                    {{ activeDestination ? (activeDestination.subtitle || activeDestination.description) : 'Tailored international holiday packages across Australia, Bali, China, Dubai, Egypt, Japan, and Thailand with VIP flights, luxury resort stays, and hassle-free visa processing.' }}
                </p>
            </div>
        </section>

        <!-- DESTINATIONS FILTER & PACKAGES GRID -->
        <section class="py-16 sm:py-24 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <!-- Region Category Filter Tabs -->
            <div class="flex items-center space-x-3 overflow-x-auto pb-4 mb-10 no-scrollbar w-full">
                <button 
                    @click="selectedRegion = 'all'"
                    :class="[
                        'px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition-all border shadow-sm whitespace-nowrap',
                        selectedRegion === 'all' ? 'bg-[#0D47A1] text-white border-[#0D47A1]' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'
                    ]"
                >
                    All Outbound Destinations ({{ packages ? packages.length : 0 }})
                </button>

                <button 
                    v-for="d in destinations" 
                    :key="d.id"
                    @click="selectedRegion = d.slug"
                    :class="[
                        'px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition-all border shadow-sm whitespace-nowrap',
                        selectedRegion === d.slug ? 'bg-[#0D47A1] text-white border-[#0D47A1]' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'
                    ]"
                >
                    {{ d.name }} ({{ d.packages ? d.packages.length : 0 }})
                </button>
            </div>

            <!-- Packages Grid -->
            <div v-if="filteredOutboundPackages && filteredOutboundPackages.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 w-full">
                <div 
                    v-for="pkg in filteredOutboundPackages" 
                    :key="pkg.id"
                    class="group bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col transform hover:-translate-y-1"
                >
                    <div class="relative h-56 sm:h-64 overflow-hidden">
                        <img :src="pkg.main_image || '/images/Logo/worldineback.png'" :alt="pkg.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 bg-white/95 text-slate-900 border border-slate-200 font-extrabold text-[11px] px-3 py-1 rounded-full shadow">
                            {{ pkg.badge || (pkg.destination ? pkg.destination.name : 'Global Tour') }}
                        </span>
                        <div class="absolute bottom-4 left-4 right-4 text-white flex justify-between items-end">
                            <span v-if="pkg.price && Number(pkg.price) > 0" class="text-2xl font-black">${{ Number(pkg.price).toLocaleString() }}</span>
                            <span v-else class="text-xs font-extrabold bg-white/20 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/30">Inquire for Quote</span>
                            <span class="text-xs font-bold bg-white/20 backdrop-blur-md px-3 py-1 rounded-full border border-white/30">{{ (pkg.itinerary_days && pkg.itinerary_days.length > 0) ? pkg.itinerary_days.length : pkg.duration_days }} Days</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-xl font-black text-slate-900 leading-tight group-hover:text-[#2196F3] transition-colors">{{ pkg.title }}</h3>
                            <p class="text-slate-600 text-xs font-medium line-clamp-2 leading-relaxed">{{ pkg.subtitle || pkg.overview }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <Link 
                                :href="route('tours.show', pkg.slug || pkg.id)"
                                class="px-5 py-2.5 rounded-full bg-[#0D47A1] text-white text-xs font-extrabold shadow-md hover:bg-[#1565C0] transition-all flex items-center space-x-1.5"
                            >
                                <span>View Itinerary</span>
                                <span>→</span>
                            </Link>

                            <span class="text-xs font-bold text-slate-400 font-mono">
                                {{ pkg.destination ? pkg.destination.name : 'Global' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
