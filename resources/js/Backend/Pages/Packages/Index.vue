<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    destinations: { type: Array, default: () => [] },
    packages: { type: Array, default: () => [] },
});

const searchQuery = ref('');
const selectedCategoryFilter = ref('all');
const isPackageModalOpen = ref(false);
const editingPackage = ref(null);

const pkgForm = useForm({
    id: null,
    destination_id: '',
    title: '',
    subtitle: '',
    category: 'global-outbound',
    price: null,
    duration_days: 5,
    duration_nights: 4,
    badge: 'Popular Choice',
    main_image: '',
    overview: '',
    is_featured: true,
    is_active: true,
});

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
    } else {
        pkgForm.reset();
        pkgForm.id = null;
        if (props.destinations.length > 0) {
            pkgForm.destination_id = props.destinations[0].id;
        }
    }
    isPackageModalOpen.value = true;
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

const filteredPackages = computed(() => {
    return props.packages.filter(pkg => {
        const matchesSearch = !searchQuery.value || pkg.title.toLowerCase().includes(searchQuery.value.toLowerCase()) || (pkg.destination && pkg.destination.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
        const matchesCat = selectedCategoryFilter.value === 'all' || pkg.category === selectedCategoryFilter.value;
        return matchesSearch && matchesCat;
    });
});
</script>

<template>
    <Head title="Tour Packages Catalog - Admin Portal" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tour Packages Catalog</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">Manage pricing, durations, region assignments, and cover images for all travel packages.</p>
            </div>
        </template>

        <div class="space-y-6 font-aptos">
            <!-- SEARCH, CATEGORY FILTERS & ACTION BUTTON INSIDE PAGE -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex items-center space-x-2 overflow-x-auto pb-1 lg:pb-0">
                    <button 
                        @click="selectedCategoryFilter = 'all'"
                        :class="['px-3.5 py-2 rounded-xl text-xs font-extrabold transition-all', selectedCategoryFilter === 'all' ? 'bg-[#0D47A1] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200']"
                    >
                        All Packages ({{ packages.length }})
                    </button>
                    <button 
                        @click="selectedCategoryFilter = 'srilanka-inbound'"
                        :class="['px-3.5 py-2 rounded-xl text-xs font-extrabold transition-all', selectedCategoryFilter === 'srilanka-inbound' ? 'bg-[#0D47A1] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200']"
                    >
                        Sri Lanka Inbound
                    </button>
                    <button 
                        @click="selectedCategoryFilter = 'global-outbound'"
                        :class="['px-3.5 py-2 rounded-xl text-xs font-extrabold transition-all', selectedCategoryFilter === 'global-outbound' ? 'bg-[#0D47A1] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200']"
                    >
                        Global Outbound
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <div class="relative w-full sm:w-64">
                        <input 
                            type="text" 
                            v-model="searchQuery" 
                            placeholder="Search packages..." 
                            class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#2196F3]"
                        />
                        <span class="absolute left-3 top-3 text-slate-400 text-xs">🔍</span>
                    </div>

                    <button 
                        @click="openPackageModal()" 
                        class="px-4 py-2.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white text-xs font-extrabold transition-all shadow-md flex items-center justify-center space-x-1.5 whitespace-nowrap"
                    >
                        <span>+ Create New Package</span>
                    </button>
                </div>
            </div>

            <!-- PACKAGES TABLE -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200">
                            <tr>
                                <th class="p-4">Package Name</th>
                                <th class="p-4">Destination</th>
                                <th class="p-4">Price</th>
                                <th class="p-4">Duration</th>
                                <th class="p-4">Itinerary Status</th>
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
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ pkg.destination ? pkg.destination.name : pkg.category }}
                                    </span>
                                </td>
                                <td class="p-4 font-black text-slate-900">
                                    <span v-if="pkg.price && Number(pkg.price) > 0">${{ pkg.price }}</span>
                                    <span v-else class="text-[11px] font-extrabold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">On Request</span>
                                </td>
                                <td class="p-4">{{ pkg.duration_days }} Days / {{ pkg.duration_nights }} Nights</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-extrabold bg-blue-50 text-[#0D47A1] border border-blue-200">
                                        {{ pkg.itinerary_days ? pkg.itinerary_days.length : 0 }} Days Logged
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
        </div>

        <!-- PACKAGE MODAL -->
        <div v-if="isPackageModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs">
            <div class="bg-white w-full max-w-2xl rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200 font-aptos space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h2 class="text-xl font-black text-[#0D47A1]">{{ editingPackage ? 'Edit Tour Package' : 'Create New Package' }}</h2>
                    <button @click="isPackageModalOpen = false" class="text-slate-400 font-bold">✕</button>
                </div>

                <form @submit.prevent="savePackage" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Package Title</label>
                            <input type="text" v-model="pkgForm.title" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Destination Region</label>
                            <select v-model="pkgForm.destination_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900">
                                <option v-for="d in destinations" :key="d.id" :value="d.id">{{ d.name }} ({{ d.type }})</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Price (USD $) <span class="text-[10px] text-slate-400 font-normal">(Optional)</span></label>
                            <input type="number" step="0.01" v-model="pkgForm.price" placeholder="Leave empty for 'On Request'" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Duration Days</label>
                            <input type="number" v-model="pkgForm.duration_days" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cover Image URL</label>
                        <input type="url" v-model="pkgForm.main_image" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-900" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Overview Description</label>
                        <textarea v-model="pkgForm.overview" rows="3" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs font-medium text-slate-900"></textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <button type="button" @click="isPackageModalOpen = false" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0D47A1] text-white text-xs font-extrabold shadow-md hover:bg-[#1565C0]">Save Package</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
