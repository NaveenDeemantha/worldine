<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    packages: { type: Array, default: () => [] },
});

const selectedPackageId = ref(props.packages.length > 0 ? props.packages[0].id : null);

const selectedPackage = computed(() => {
    return props.packages.find(p => p.id === selectedPackageId.value) || null;
});

const itineraryForm = useForm({
    id: null,
    destination_id: null,
    title: '',
    days: [],
});

const loadPackageItinerary = (pkg) => {
    selectedPackageId.value = pkg.id;
    itineraryForm.id = pkg.id;
    itineraryForm.destination_id = pkg.destination_id;
    itineraryForm.title = pkg.title;
    itineraryForm.days = pkg.itinerary_days ? pkg.itinerary_days.map(d => ({ ...d })) : [];
};

if (props.packages.length > 0) {
    loadPackageItinerary(props.packages[0]);
}

const addItineraryDay = () => {
    const nextDayNum = itineraryForm.days.length + 1;
    itineraryForm.days.push({
        day_number: nextDayNum,
        title: `Day ${nextDayNum}: Sightseeing & Exploration`,
        description: '',
        image: '',
        accommodation: '4-Star Luxury Resort',
        meals: 'Breakfast & Dinner',
    });
};

const removeItineraryDay = (index) => {
    itineraryForm.days.splice(index, 1);
    itineraryForm.days.forEach((day, idx) => {
        day.day_number = idx + 1;
    });
};

const saveItinerary = () => {
    itineraryForm.post(route('admin.packages.store'), {
        preserveScroll: true,
        onSuccess: () => {
            alert('Itinerary updated successfully!');
        }
    });
};
</script>

<template>
    <Head title="Day-by-Day Itinerary Builder - Admin Portal" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Day-by-Day Itinerary Builder</h1>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Select a tour package and customize day-by-day narratives, hotel stays, and day photos.</p>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 font-spinnaker">
            
            <!-- LEFT COLUMN: TOUR PACKAGE SELECTOR LIST -->
            <div class="lg:col-span-4 space-y-3">
                <h2 class="text-xs font-black uppercase text-slate-400 tracking-wider">Select Tour Package</h2>
                
                <div class="space-y-2 max-h-[75vh] overflow-y-auto pr-1">
                    <div 
                        v-for="pkg in packages" 
                        :key="pkg.id"
                        @click="loadPackageItinerary(pkg)"
                        :class="[
                            'p-4 rounded-2xl border transition-all cursor-pointer flex items-center justify-between',
                            selectedPackageId === pkg.id ? 'bg-[#0D47A1] text-white border-[#0D47A1] shadow-md' : 'bg-white text-slate-800 border-slate-200 hover:border-slate-300'
                        ]"
                    >
                        <div class="flex items-center space-x-3">
                            <img :src="pkg.main_image" :alt="pkg.title" class="w-10 h-10 rounded-xl object-cover" />
                            <div>
                                <div class="font-extrabold text-xs leading-tight line-clamp-1">{{ pkg.title }}</div>
                                <div :class="['text-[10px] mt-0.5', selectedPackageId === pkg.id ? 'text-sky-200' : 'text-slate-500']">
                                    {{ pkg.duration_days }} Days • {{ pkg.itinerary_days ? pkg.itinerary_days.length : 0 }} Days Built
                                </div>
                            </div>
                        </div>
                        <span class="text-xs font-black">→</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: ITINERARY BUILDER CANVAS -->
            <div class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
                <div v-if="selectedPackage" class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-4 gap-4">
                        <div>
                            <span class="text-[10px] font-black uppercase text-[#2196F3] bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                                {{ selectedPackage.destination ? selectedPackage.destination.name : 'Tour Package' }}
                            </span>
                            <h2 class="text-xl font-black text-slate-900 mt-2">{{ selectedPackage.title }}</h2>
                        </div>

                        <button @click="addItineraryDay" class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200 hover:bg-emerald-100">
                            + Add Day {{ itineraryForm.days.length + 1 }}
                        </button>
                    </div>

                    <form @submit.prevent="saveItinerary" class="space-y-6">
                        <div v-for="(day, idx) in itineraryForm.days" :key="idx" class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black uppercase text-white bg-[#0D47A1] px-3.5 py-1 rounded-full">Day {{ day.day_number }}</span>
                                <button type="button" @click="removeItineraryDay(idx)" class="text-xs font-bold text-rose-600 hover:underline">Remove Day</button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Day Title</label>
                                    <input type="text" v-model="day.title" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-900" placeholder="e.g. Arrival in Colombo & Transfer to Sigiriya" />
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Day Narrative / Itinerary Details</label>
                                    <textarea v-model="day.description" rows="2" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-medium text-slate-900" placeholder="Describe activities, visits, and highlights..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Day Photo Image URL</label>
                                    <input type="url" v-model="day.image" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-900" placeholder="https://images.unsplash.com/..." />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Hotel Stay</label>
                                    <input type="text" v-model="day.accommodation" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-900" placeholder="e.g. Sigiriya Resort (5★)" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                            <button type="submit" class="px-8 py-3 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white text-xs font-extrabold shadow-md">
                                Save Complete Itinerary
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
