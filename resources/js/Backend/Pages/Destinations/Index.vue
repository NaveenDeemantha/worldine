<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    destinations: {
        type: Array,
        default: () => [],
    },
    packages: {
        type: Array,
        default: () => [],
    },
});

const activeTab = ref('packages'); // 'packages' | 'destinations'
const searchQuery = ref('');

// Modals State
const isDestinationModalOpen = ref(false);
const isPackageModalOpen = ref(false);
const editingDestination = ref(null);
const editingPackage = ref(null);

// Destination Form
const destForm = useForm({
    id: null,
    name: '',
    type: 'outbound',
    subtitle: '',
    description: '',
    image: '',
    badge: '',
    is_glimpse: true,
    is_featured: true,
    is_active: true,
});

// Package Form with Day-by-Day Itineraries
const pkgForm = useForm({
    id: null,
    destination_id: '',
    title: '',
    subtitle: '',
    category: 'global-outbound',
    price: 1500,
    duration_days: 5,
    duration_nights: 4,
    badge: 'Popular Choice',
    main_image: '',
    overview: '',
    is_featured: true,
    is_active: true,
    days: [],
});

// Add a Day to Package Itinerary
const addItineraryDay = () => {
    const nextDayNum = pkgForm.days.length + 1;
    pkgForm.days.push({
        day_number: nextDayNum,
        title: `Day ${nextDayNum}: Sightseeing & Exploration`,
        description: '',
        image: '',
        accommodation: '4-Star Luxury Resort',
        meals: 'Breakfast & Dinner',
    });
};

const removeItineraryDay = (index) => {
    pkgForm.days.splice(index, 1);
    // Re-index day numbers
    pkgForm.days.forEach((day, idx) => {
        day.day_number = idx + 1;
    });
};

// Open Destination Modal
const openDestinationModal = (dest = null) => {
    editingDestination.value = dest;
    if (dest) {
        destForm.id = dest.id;
        destForm.name = dest.name;
        destForm.type = dest.type;
        destForm.subtitle = dest.subtitle || '';
        destForm.description = dest.description || '';
        destForm.image = dest.image || '';
        destForm.badge = dest.badge || '';
        destForm.is_glimpse = dest.is_glimpse;
        destForm.is_featured = dest.is_featured;
        destForm.is_active = dest.is_active;
    } else {
        destForm.reset();
        destForm.id = null;
    }
    isDestinationModalOpen.value = true;
};

// Open Package Modal
const openPackageModal = (pkg = null) => {
    editingPackage.value = pkg;
    if (pkg) {
        pkgForm.id = pkg.id;
        pkgForm.destination_id = pkg.destination_id;
        pkgForm.title = pkg.title;
        pkgForm.subtitle = pkg.subtitle || '';
        pkgForm.category = pkg.category;
        pkgForm.price = pkg.price;
        pkgForm.duration_days = pkg.duration_days;
        pkgForm.duration_nights = pkg.duration_nights;
        pkgForm.badge = pkg.badge || '';
        pkgForm.main_image = pkg.main_image || '';
        pkgForm.overview = pkg.overview || '';
        pkgForm.is_featured = pkg.is_featured;
        pkgForm.is_active = pkg.is_active;
        pkgForm.days = pkg.itinerary_days ? pkg.itinerary_days.map(d => ({ ...d })) : [];
    } else {
        pkgForm.reset();
        pkgForm.id = null;
        if (props.destinations.length > 0) {
            pkgForm.destination_id = props.destinations[0].id;
        }
        // Add 2 default itinerary days
        pkgForm.days = [
            { day_number: 1, title: 'Day 1: Arrival & Hotel Check-in', description: '', image: '', accommodation: '4-Star Resort', meals: 'Dinner Included' },
            { day_number: 2, title: 'Day 2: City Tour & Landmarks', description: '', image: '', accommodation: '4-Star Resort', meals: 'Breakfast & Dinner' },
        ];
    }
    isPackageModalOpen.value = true;
};

const saveDestination = () => {
    if (destForm.id) {
        destForm.put(route('admin.destinations.update', destForm.id), {
            onSuccess: () => { isDestinationModalOpen.value = false; }
        });
    } else {
        destForm.post(route('admin.destinations.store'), {
            onSuccess: () => { isDestinationModalOpen.value = false; }
        });
    }
};

const deleteDestination = (destId) => {
    if (confirm('Are you sure you want to delete this destination and its associated packages?')) {
        router.delete(route('admin.destinations.destroy', destId));
    }
};

const savePackage = () => {
    pkgForm.post(route('admin.packages.store'), {
        onSuccess: () => { isPackageModalOpen.value = false; }
    });
};

const deletePackage = (pkgId) => {
    if (confirm('Are you sure you want to delete this tour package?')) {
        router.delete(route('admin.packages.destroy', pkgId));
    }
};

// Filtered Lists
const filteredPackages = computed(() => {
    if (!searchQuery.value) return props.packages;
    const q = searchQuery.value.toLowerCase();
    return props.packages.filter(p => p.title.toLowerCase().includes(q) || (p.destination && p.destination.name.toLowerCase().includes(q)));
});

const filteredDestinations = computed(() => {
    if (!searchQuery.value) return props.destinations;
    const q = searchQuery.value.toLowerCase();
    return props.destinations.filter(d => d.name.toLowerCase().includes(q) || d.type.toLowerCase().includes(q));
});
</script>

<template>
    <Head title="Destinations & Tour Packages - Admin Portal" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Destinations & Tour Packages</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">Manage all Inbound & Outbound travel packages, Glimpse Carousel cards, and Day-by-Day itineraries live on Worldine Destinations.</p>
            </div>
        </template>

        <div class="space-y-6 font-aptos">
            <!-- TAB CONTROL, SEARCH FILTER & PAGE ACTION BUTTONS INSIDE PAGE -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex items-center space-x-2 bg-slate-100 p-1 rounded-xl w-fit">
                    <button 
                        @click="activeTab = 'packages'"
                        :class="[
                            'px-4 py-2 rounded-lg text-xs font-extrabold transition-all',
                            activeTab === 'packages' ? 'bg-white text-[#0D47A1] shadow-xs' : 'text-slate-600 hover:text-slate-900'
                        ]"
                    >
                        Tour Packages ({{ packages.length }})
                    </button>
                    <button 
                        @click="activeTab = 'destinations'"
                        :class="[
                            'px-4 py-2 rounded-lg text-xs font-extrabold transition-all',
                            activeTab === 'destinations' ? 'bg-white text-[#0D47A1] shadow-xs' : 'text-slate-600 hover:text-slate-900'
                        ]"
                    >
                        Destinations & Carousel ({{ destinations.length }})
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="relative w-full sm:w-64">
                        <input 
                            type="text" 
                            v-model="searchQuery" 
                            placeholder="Search tours or regions..." 
                            class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#2196F3]"
                        />
                        <span class="absolute left-3 top-3 text-slate-400 text-xs">🔍</span>
                    </div>

                    <button 
                        @click="openDestinationModal()" 
                        class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold border border-slate-200 transition-colors shadow-xs flex items-center justify-center space-x-1.5 whitespace-nowrap"
                    >
                        <span>+ Add Destination</span>
                    </button>

                    <button 
                        @click="openPackageModal()" 
                        class="px-4 py-2.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white text-xs font-extrabold transition-all shadow-md flex items-center justify-center space-x-1.5 whitespace-nowrap"
                    >
                        <span>+ Create Tour Package</span>
                    </button>
                </div>
            </div>

            <!-- TAB 1: TOUR PACKAGES TABLE VIEW -->
            <div v-if="activeTab === 'packages'" class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200">
                            <tr>
                                <th class="p-4">Package Name</th>
                                <th class="p-4">Destination / Category</th>
                                <th class="p-4">Price / Duration</th>
                                <th class="p-4">Itinerary Days</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                            <tr v-for="pkg in filteredPackages" :key="pkg.id" class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-4 flex items-center space-x-3">
                                    <img :src="pkg.main_image" :alt="pkg.title" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0" />
                                    <div>
                                        <div class="font-extrabold text-slate-900 text-sm">{{ pkg.title }}</div>
                                        <div class="text-[11px] text-slate-400 line-clamp-1">{{ pkg.subtitle }}</div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ pkg.destination ? pkg.destination.name : pkg.category }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="font-black text-slate-900">${{ pkg.price }}</div>
                                    <div class="text-[11px] text-slate-500">{{ pkg.duration_days }} Days / {{ pkg.duration_nights }} Nights</div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-blue-50 text-[#0D47A1] border border-blue-200">
                                        {{ pkg.itinerary_days ? pkg.itinerary_days.length : 0 }} Days Logged
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span :class="['px-2.5 py-1 rounded-full text-[11px] font-extrabold', pkg.is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500']">
                                        {{ pkg.is_active ? 'Active Live' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <button @click="openPackageModal(pkg)" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#2196F3] hover:text-white text-slate-700 font-bold transition-all">Edit</button>
                                    <button @click="deletePackage(pkg.id)" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-bold transition-all">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: DESTINATIONS & GLIMPSE CAROUSEL -->
            <div v-if="activeTab === 'destinations'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div 
                    v-for="dest in filteredDestinations" 
                    :key="dest.id"
                    class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition-all p-5 flex flex-col justify-between"
                >
                    <div class="space-y-3">
                        <div class="relative h-40 rounded-xl overflow-hidden">
                            <img :src="dest.image" :alt="dest.name" class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            <span class="absolute top-3 left-3 bg-white/90 text-slate-900 text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full shadow">
                                {{ dest.type }}
                            </span>
                            <span v-if="dest.is_glimpse" class="absolute top-3 right-3 bg-[#2196F3] text-white text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full shadow">
                                ★ In Glimpse Carousel
                            </span>
                            <h3 class="absolute bottom-3 left-3 right-3 text-white text-xl font-black">{{ dest.name }}</h3>
                        </div>
                        <p class="text-xs text-slate-600 font-medium line-clamp-2">{{ dest.subtitle }}</p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-extrabold text-[#0D47A1]">
                            {{ dest.packages ? dest.packages.length : 0 }} Tour Packages
                        </span>

                        <div class="space-x-2">
                            <button @click="openDestinationModal(dest)" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#2196F3] hover:text-white text-slate-700 text-xs font-bold transition-all">Edit</button>
                            <button @click="deleteDestination(dest.id)" class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold transition-all">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- PACKAGE & ITINERARY DAY-BY-DAY MODAL -->
        <div v-if="isPackageModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white w-full max-w-4xl rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto font-spinnaker space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h2 class="text-xl font-black text-[#0D47A1]">
                            {{ editingPackage ? 'Edit Tour Package & Itinerary' : 'Create New Tour Package' }}
                        </h2>
                        <p class="text-xs text-slate-500 font-medium">Build complete day-by-day itineraries with photos, descriptions, and inclusions.</p>
                    </div>
                    <button @click="isPackageModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold">✕</button>
                </div>

                <form @submit.prevent="savePackage" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Package Title</label>
                            <input type="text" v-model="pkgForm.title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" placeholder="e.g. 7 Days Heritage Expedition" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Destination Region</label>
                            <select v-model="pkgForm.destination_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900">
                                <option v-for="d in destinations" :key="d.id" :value="d.id">{{ d.name }} ({{ d.type }})</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category Filter Tag</label>
                            <select v-model="pkgForm.category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900">
                                <option value="srilanka-inbound">Sri Lanka Inbound</option>
                                <option value="global-outbound">Global Outbound</option>
                                <option value="europe-schengen">Europe Schengen</option>
                                <option value="east-asia">East Asia & Japan</option>
                                <option value="luxury-escapes">Luxury Escapes</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Price (USD $)</label>
                            <input type="number" step="0.01" v-model="pkgForm.price" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Duration Days</label>
                            <input type="number" v-model="pkgForm.duration_days" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Duration Nights</label>
                            <input type="number" v-model="pkgForm.duration_nights" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Main Cover Image URL</label>
                        <input type="url" v-model="pkgForm.main_image" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" placeholder="https://images.unsplash.com/..." />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Overview Description</label>
                        <textarea v-model="pkgForm.overview" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-900" placeholder="Summary of this tour package..."></textarea>
                    </div>

                    <!-- DAY-BY-DAY ITINERARY BUILDER -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Day-by-Day Itinerary Days</h3>
                            <button type="button" @click="addItineraryDay" class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-extrabold border border-emerald-200 hover:bg-emerald-100">
                                + Add Day {{ pkgForm.days.length + 1 }}
                            </button>
                        </div>

                        <div v-for="(day, idx) in pkgForm.days" :key="idx" class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 relative">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black uppercase text-[#0D47A1] bg-blue-100 px-3 py-1 rounded-full">Day {{ day.day_number }}</span>
                                <button type="button" @click="removeItineraryDay(idx)" class="text-xs font-bold text-rose-600 hover:underline">Remove Day</button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="sm:col-span-2">
                                    <input type="text" v-model="day.title" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold" placeholder="Day Title e.g. Arrival & Sigiriya Fortress" />
                                </div>
                                <div class="sm:col-span-2">
                                    <textarea v-model="day.description" rows="2" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-medium" placeholder="Detailed itinerary narrative for this day..."></textarea>
                                </div>
                                <div>
                                    <input type="url" v-model="day.image" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold" placeholder="Day Photo Image URL" />
                                </div>
                                <div>
                                    <input type="text" v-model="day.accommodation" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold" placeholder="Hotel e.g. Sigiriya Resort (5★)" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <button type="button" @click="isPackageModalOpen = false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0D47A1] text-white text-xs font-extrabold shadow-md hover:bg-[#1565C0]">Save Tour Package</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- DESTINATION MODAL -->
        <div v-if="isDestinationModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
            <div class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl border border-slate-200 font-spinnaker space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-black text-[#0D47A1]">{{ editingDestination ? 'Edit Destination' : 'Add New Destination' }}</h2>
                    <button @click="isDestinationModalOpen = false" class="text-slate-400 font-bold">✕</button>
                </div>

                <form @submit.prevent="saveDestination" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Destination Name</label>
                        <input type="text" v-model="destForm.name" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold" placeholder="e.g. Sri Lanka or Japan" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Type</label>
                        <select v-model="destForm.type" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold">
                            <option value="inbound">Inbound Tour (Sri Lanka)</option>
                            <option value="outbound">Outbound Tour (Global)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subtitle</label>
                        <input type="text" v-model="destForm.subtitle" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-medium" placeholder="e.g. Kyoto Temples & Bullet Trains" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cover Image URL</label>
                        <input type="url" v-model="destForm.image" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold" placeholder="https://images.unsplash.com/..." />
                    </div>

                    <div class="flex items-center space-x-4 pt-2">
                        <label class="inline-flex items-center text-xs font-bold cursor-pointer">
                            <input type="checkbox" v-model="destForm.is_glimpse" class="rounded text-[#2196F3]" />
                            <span class="ml-2">Show in Glimpse Carousel</span>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <button type="button" @click="isDestinationModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-[#0D47A1] text-white text-xs font-extrabold">Save Destination</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
