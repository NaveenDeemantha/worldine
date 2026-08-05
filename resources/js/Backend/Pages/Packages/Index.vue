<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    destinations: { type: Array, default: () => [] },
    packages: { type: Array, default: () => [] },
});

const searchQuery = ref('');
const selectedCategoryFilter = ref('all');
const isPackageModalOpen = ref(false);
const editingPackage = ref(null);
const pkgImagePreview = ref(null);

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
    main_image: null,
    overview: '',
    is_featured: true,
    is_active: true,
});

const onPkgFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        pkgForm.main_image = file;
        pkgImagePreview.value = URL.createObjectURL(file);
    }
};

const openPackageModal = (pkg = null) => {
    editingPackage.value = pkg;
    pkgImagePreview.value = null;
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
        pkgForm.main_image = pkg.main_image || null;
        pkgForm.overview = pkg.overview || '';
        pkgForm.is_featured = pkg.is_featured;
        pkgForm.is_active = pkg.is_active;
        if (pkg.main_image) pkgImagePreview.value = pkg.main_image;
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
    let result = props.packages;
    if (selectedCategoryFilter.value !== 'all') {
        result = result.filter(p => p.category === selectedCategoryFilter.value);
    }
    if (searchQuery.value) {
        const q = searchQuery.value.toLowerCase();
        result = result.filter(p => p.title.toLowerCase().includes(q) || (p.destination && p.destination.name.toLowerCase().includes(q)));
    }
    return result;
});
</script>

<template>
    <Head title="Tour Packages Inventory - Admin Portal" />

    <AuthenticatedLayout>
        <div class="space-y-6 font-aptos">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-[#0D47A1]">INVENTORY CATALOG</span>
                    <h1 class="text-2xl font-black text-slate-900 mt-0.5">Tour Packages Manager</h1>
                    <p class="text-xs text-slate-500 font-medium mt-1">Create and manage published tour packages across all destinations.</p>
                </div>

                <button 
                    @click="openPackageModal()" 
                    class="px-5 py-2.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white text-xs font-extrabold shadow-md flex items-center justify-center space-x-1.5"
                >
                    <span>+ Create New Package</span>
                </button>
            </div>

            <!-- SEARCH & CATEGORY FILTER BAR -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-200">
                <div class="relative w-full sm:w-72">
                    <input 
                        type="text" 
                        v-model="searchQuery" 
                        placeholder="Search tour title or region..." 
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#2196F3]"
                    />
                    <span class="absolute left-3 top-2.5 text-slate-400 text-xs">🔍</span>
                </div>

                <div class="flex items-center space-x-2 w-full sm:w-auto">
                    <span class="text-xs font-bold text-slate-500 uppercase">Category:</span>
                    <select v-model="selectedCategoryFilter" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800">
                        <option value="all">All Categories</option>
                        <option value="srilanka-inbound">Sri Lanka Inbound</option>
                        <option value="global-outbound">Global Outbound</option>
                        <option value="europe-schengen">Europe Schengen</option>
                        <option value="east-asia">East Asia & Japan</option>
                        <option value="luxury-escapes">Luxury Escapes</option>
                    </select>
                </div>
            </div>

            <!-- PACKAGES TABLE -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left text-xs whitespace-nowrap">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200">
                            <tr>
                                <th class="py-4 px-6">Package Name</th>
                                <th class="py-4 px-4">Destination Region</th>
                                <th class="py-4 px-4">Price & Duration</th>
                                <th class="py-4 px-4">Itinerary</th>
                                <th class="py-4 px-4 text-center">Status</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                            <tr v-for="pkg in filteredPackages" :key="pkg.id" class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 flex items-center space-x-3">
                                    <img :src="pkg.main_image || '/images/Logo/worldineback.png'" :alt="pkg.title" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0" />
                                    <div class="max-w-xs">
                                        <div class="font-extrabold text-slate-900 text-sm truncate">{{ pkg.title }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ pkg.subtitle || pkg.category }}</div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ pkg.destination ? pkg.destination.name : pkg.category }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <div class="font-black text-slate-900 text-sm" v-if="pkg.price && Number(pkg.price) > 0">${{ pkg.price }}</div>
                                    <div class="text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 inline-block mb-0.5" v-else>On Request</div>
                                    <div class="text-[11px] text-slate-500 font-medium">{{ pkg.duration_days }} Days / {{ pkg.duration_nights }} Nights</div>
                                </td>
                                <td class="py-4 px-4">
                                    <Link 
                                        :href="route('admin.itineraries.index') + '?package_id=' + pkg.id" 
                                        class="px-3 py-1.5 rounded-xl text-[11px] font-extrabold bg-blue-50 hover:bg-blue-100 text-[#0D47A1] border border-blue-200 transition-colors whitespace-nowrap inline-flex items-center space-x-1.5"
                                        title="Manage Day-by-Day Itinerary"
                                    >
                                        <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        <span>{{ pkg.itinerary_days ? pkg.itinerary_days.length : 0 }} Days (Edit)</span>
                                    </Link>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span :class="['px-3 py-1 rounded-full text-[11px] font-extrabold whitespace-nowrap inline-block', pkg.is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200']">
                                        {{ pkg.is_active ? 'Active' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <Link 
                                            :href="route('admin.itineraries.index') + '?package_id=' + pkg.id"
                                            class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-200 transition-colors inline-flex items-center space-x-1"
                                            title="Manage Itinerary Days"
                                        >
                                            <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                                            <span>Itinerary</span>
                                        </Link>
                                        <button @click="openPackageModal(pkg)" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-[#2196F3] hover:text-white text-slate-700 font-bold transition-all text-xs">Edit</button>
                                        <button @click="deletePackage(pkg.id)" class="px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-bold transition-all text-xs">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PACKAGE MODAL WITH IMAGE FILE UPLOAD -->
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

                    <!-- IMAGE FILE UPLOAD + URL INPUT -->
                    <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 border-b border-slate-200/80 pb-2">
                            <label class="block text-xs font-bold text-slate-800 uppercase">Cover Image (Upload File or Enter URL)</label>
                            <span class="text-[10px] font-extrabold text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-full flex items-center space-x-1">
                                <svg class="w-3 h-3 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="9" x2="9" y1="21" y2="9"/></svg>
                                <span>Rec: 1200×800 px | Max: 500 KB</span>
                            </span>
                        </div>

                        <div class="p-2.5 bg-amber-50 border border-amber-200/80 rounded-xl text-[11px] text-amber-900 font-medium flex items-start space-x-2">
                            <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                            <span><strong>Compression Reminder:</strong> Compress images to under 500 KB (using TinyPNG or Squoosh) before uploading for fast site loading.</span>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-center gap-3 pt-1">
                            <div v-if="pkgImagePreview" class="w-20 h-20 rounded-xl overflow-hidden border border-slate-200 bg-white flex-shrink-0 shadow-xs">
                                <img :src="pkgImagePreview" class="w-full h-full object-cover" />
                            </div>

                            <div class="space-y-2.5 flex-grow w-full">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-600 flex items-center space-x-1 mb-1">
                                        <svg class="w-3.5 h-3.5 text-slate-500 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                        <span>Upload Image File from Device:</span>
                                    </span>
                                    <input 
                                        type="file" 
                                        @change="onPkgFileChange" 
                                        accept="image/*" 
                                        class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-[#0D47A1] file:text-white hover:file:bg-[#1565C0] cursor-pointer"
                                    />
                                </div>

                                <div>
                                    <span class="text-[10px] font-bold text-slate-600 flex items-center space-x-1 mb-1">
                                        <svg class="w-3.5 h-3.5 text-slate-500 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                                        <span>Or Enter Image Web URL:</span>
                                    </span>
                                    <input type="text" v-model="pkgForm.main_image" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-bold" placeholder="https://..." />
                                </div>
                            </div>
                        </div>
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
