<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

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

onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    const pkgId = params.get('package_id');
    if (pkgId && props.packages.length > 0) {
        const found = props.packages.find(p => p.id === Number(pkgId) || String(p.id) === String(pkgId));
        if (found) {
            loadPackageItinerary(found);
        }
    }
});

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

const onDayFileChange = (e, index) => {
    const file = e.target.files[0];
    if (file) {
        itineraryForm.days[index].image = file;
    }
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
        <div class="space-y-6 font-aptos">

            <!-- GLOBAL IMAGE GUIDANCE BANNER -->
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/90 text-amber-900 text-xs font-medium flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                <div class="flex items-start space-x-2.5">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    <div>
                        <strong class="font-extrabold text-amber-950">Image Upload Requirements & Compression Reminder:</strong>
                        <p class="text-[11px] text-amber-800 mt-0.5">
                            Recommended dimensions: <strong>1200×800 px</strong> (Landscape). Please optimize & compress image files under <strong>500 KB</strong> (using free tools like <strong>TinyPNG</strong> or <strong>Squoosh</strong>) before uploading to ensure 100% fast loading speed for website visitors.
                        </p>
                    </div>
                </div>
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-900 bg-amber-200/70 px-3 py-1 rounded-full whitespace-nowrap self-start sm:self-auto border border-amber-300">
                    Max: 500 KB per file
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
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
                                <img :src="pkg.main_image || '/images/Logo/worldineback.png'" :alt="pkg.title" class="w-10 h-10 rounded-xl object-cover" />
                                <div>
                                    <div class="font-extrabold text-xs leading-tight line-clamp-1">{{ pkg.title }}</div>
                                    <div :class="['text-[10px] mt-0.5', selectedPackageId === pkg.id ? 'text-sky-200' : 'text-slate-500']">
                                        {{ pkg.duration_days }} Days • {{ pkg.itinerary_days ? pkg.itinerary_days.length : 0 }} Days Logged
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
                                    
                                    <!-- DAY PHOTO UPLOAD WITH SPECS & COMPRESSION REMINDER -->
                                    <div class="sm:col-span-2 space-y-2 p-3.5 bg-white rounded-xl border border-slate-200">
                                        <div class="flex items-center justify-between">
                                            <label class="block text-[11px] font-bold text-slate-700 uppercase">Day Photo (Upload File or Enter URL)</label>
                                            <span class="text-[9px] font-extrabold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200 flex items-center space-x-1">
                                                <svg class="w-3 h-3 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
                                                <span>Rec: 800×600 px | Max: 500 KB</span>
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                            <div>
                                                <span class="text-[10px] font-bold text-slate-500 flex items-center space-x-1 mb-1">
                                                    <svg class="w-3.5 h-3.5 text-slate-500 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                                    <span>Upload File:</span>
                                                </span>
                                                <input 
                                                    type="file" 
                                                    @change="onDayFileChange($event, idx)" 
                                                    accept="image/*" 
                                                    class="w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-extrabold file:bg-[#0D47A1] file:text-white cursor-pointer"
                                                />
                                            </div>
                                            <div>
                                                <span class="text-[10px] font-bold text-slate-500 flex items-center space-x-1 mb-1">
                                                    <svg class="w-3.5 h-3.5 text-slate-500 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                                    <span>Or Web URL:</span>
                                                </span>
                                                <input type="text" v-model="day.image" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold" placeholder="https://..." />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-2">
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
        </div>
    </AuthenticatedLayout>
</template>
