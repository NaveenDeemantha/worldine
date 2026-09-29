<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    bookings: { type: Array, default: () => [] },
});

const selectedIds = ref([]);
const selectAll = ref(false);
const isDeleting = ref(false);

const selectedBooking = ref(null);
const isModalOpen = ref(false);

// Synchronize select all state when individual items change
watch(selectedIds, (newVal) => {
    if (props.bookings.length > 0 && newVal.length === props.bookings.length) {
        selectAll.value = true;
    } else {
        selectAll.value = false;
    }
});

// Toggle Select All
const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedIds.value = props.bookings.map(b => b.db_id);
    } else {
        selectedIds.value = [];
    }
};

const viewBooking = (b) => {
    selectedBooking.value = b;
    isModalOpen.value = true;
};

const deleteSingle = (b) => {
    if (confirm(`Are you sure you want to permanently delete lead #${b.id} (${b.customer_name})?`)) {
        isDeleting.value = true;
        router.delete(route('admin.inquiries.destroy', b.db_id), {
            preserveScroll: true,
            onSuccess: () => {
                isModalOpen.value = false;
                selectedIds.value = selectedIds.value.filter(id => id !== b.db_id);
                isDeleting.value = false;
            },
            onError: () => {
                isDeleting.value = false;
            }
        });
    }
};

const deleteBulk = () => {
    if (!selectedIds.value.length) return;
    const count = selectedIds.value.length;
    if (confirm(`Are you sure you want to permanently delete ${count} selected lead(s)?`)) {
        isDeleting.value = true;
        router.post(route('admin.inquiries.bulk-destroy'), { ids: selectedIds.value }, {
            preserveScroll: true,
            onSuccess: () => {
                selectedIds.value = [];
                selectAll.value = false;
                isDeleting.value = false;
            },
            onError: () => {
                isDeleting.value = false;
            }
        });
    }
};

const formatPhone = (phone) => {
    if (!phone) return '';
    return phone.replace(/[^0-9+]/g, '');
};
</script>

<template>
    <Head title="Bookings & Customer Leads - Admin Portal" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 font-aptos">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                        <span>Bookings & Leads</span>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-100 text-[#0D47A1] font-bold font-mono">
                            {{ bookings.length }}
                        </span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Review, manage, and inspect incoming tour reservations and contact inquiries.</p>
                </div>

                <!-- Bulk Delete Action Bar -->
                <div v-if="selectedIds.length > 0" class="flex items-center gap-2 bg-rose-50 px-3.5 py-1.5 rounded-xl border border-rose-200 animate-fade-in">
                    <span class="text-xs font-black text-rose-800">{{ selectedIds.length }} Selected</span>
                    <button 
                        @click="deleteBulk" 
                        :disabled="isDeleting"
                        class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 disabled:opacity-50 text-white rounded-lg text-xs font-black transition-all flex items-center gap-1.5 shadow-xs"
                    >
                        <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        <span>{{ isDeleting ? 'Deleting...' : 'Delete Selected' }}</span>
                    </button>
                    <button 
                        @click="selectedIds = []" 
                        class="text-xs font-bold text-slate-500 hover:text-slate-800 ml-1"
                    >
                        Deselect
                    </button>
                </div>
            </div>
        </template>

        <div class="font-aptos space-y-4">
            <!-- LEADS TABLE (Zero Horizontal Scroll, Table-Fixed, Clean Density) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-2xs overflow-hidden">
                <table class="w-full table-fixed text-left text-xs">
                    <thead class="bg-slate-50/90 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200">
                        <tr>
                            <!-- Master Select All Checkbox & Ref ID Column -->
                            <th class="p-3.5 w-[140px]">
                                <div class="flex items-center gap-2.5">
                                    <input 
                                        type="checkbox" 
                                        v-model="selectAll" 
                                        @change="toggleSelectAll" 
                                        class="rounded text-[#0D47A1] focus:ring-[#0D47A1] border-slate-300 cursor-pointer"
                                        title="Select All"
                                    />
                                    <span>Reference</span>
                                </div>
                            </th>

                            <!-- Customer & Contact Column -->
                            <th class="p-3.5 w-1/3">Customer & Contact</th>

                            <!-- Inquiry Source & Subject -->
                            <th class="p-3.5 w-1/3">Inquiry Details</th>

                            <!-- Travel Specs -->
                            <th class="p-3.5 w-[140px]">Travel Specs</th>

                            <!-- Actions -->
                            <th class="p-3.5 w-[110px] text-right pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        <tr 
                            v-for="b in bookings" 
                            :key="b.id" 
                            :class="[
                                'hover:bg-blue-50/30 transition-colors group',
                                selectedIds.includes(b.db_id) ? 'bg-blue-50/60' : ''
                            ]"
                        >
                            <!-- Selection Checkbox + Reference ID + Time -->
                            <td class="p-3.5 align-middle">
                                <div class="flex items-center gap-2.5">
                                    <input 
                                        type="checkbox" 
                                        :value="b.db_id" 
                                        v-model="selectedIds" 
                                        class="rounded text-[#0D47A1] focus:ring-[#0D47A1] border-slate-300 cursor-pointer"
                                    />
                                    <div class="min-w-0">
                                        <span class="font-mono font-bold text-[#0D47A1] text-xs block truncate">{{ b.id }}</span>
                                        <span class="text-[10px] text-slate-400 font-normal block truncate">{{ b.created_at }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Customer Name, Phone & Email -->
                            <td class="p-3.5 align-middle">
                                <div class="space-y-0.5 min-w-0">
                                    <div class="font-extrabold text-slate-900 text-xs truncate" :title="b.customer_name">
                                        {{ b.customer_name }}
                                    </div>
                                    <div class="flex items-center gap-1.5 text-[11px] text-slate-600 min-w-0">
                                        <a :href="`mailto:${b.email}`" class="hover:text-[#0D47A1] truncate font-medium" :title="b.email">
                                            {{ b.email }}
                                        </a>
                                        <span class="text-slate-300">•</span>
                                        <a :href="`tel:${formatPhone(b.phone)}`" class="hover:text-slate-900 shrink-0 font-medium text-slate-500">
                                            {{ b.phone }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Inquiry Source Badge + Subject/Package -->
                            <td class="p-3.5 align-middle">
                                <div class="space-y-1 min-w-0">
                                    <span 
                                        :class="[
                                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider',
                                            b.type === 'Contact Form Lead' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-blue-50 text-[#0D47A1] border border-blue-200'
                                        ]"
                                    >
                                        <span :class="['w-1.5 h-1.5 rounded-full', b.type === 'Contact Form Lead' ? 'bg-sky-500' : 'bg-[#0D47A1]']"></span>
                                        <span>{{ b.type === 'Contact Form Lead' ? 'Contact Form' : 'Tour Booking' }}</span>
                                    </span>
                                    <div class="font-bold text-slate-900 text-xs truncate max-w-full block" :title="b.package_title">
                                        {{ b.package_title }}
                                    </div>
                                </div>
                            </td>

                            <!-- Travel Date & Guests -->
                            <td class="p-3.5 align-middle">
                                <div class="space-y-0.5 min-w-0">
                                    <div class="text-[11px] font-bold text-slate-800 truncate" :title="b.travel_date">
                                        {{ b.travel_date || 'Flexible Date' }}
                                    </div>
                                    <div class="text-[10px] font-medium text-slate-500">
                                        {{ b.guests }} Traveler(s)
                                    </div>
                                </div>
                            </td>

                            <!-- Actions (View + Delete) -->
                            <td class="p-3.5 text-right pr-4 align-middle">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button 
                                        @click="viewBooking(b)" 
                                        class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-[#0D47A1] hover:text-white text-slate-700 font-bold transition-all text-[11px]"
                                        title="View Full Details"
                                    >
                                        View
                                    </button>
                                    <button 
                                        @click="deleteSingle(b)" 
                                        class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition-all"
                                        title="Delete Lead"
                                    >
                                        <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="!bookings.length">
                            <td colspan="5" class="p-12 text-center text-slate-400 font-medium">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800">No leads or bookings recorded</h3>
                                <p class="text-xs text-slate-400 mt-0.5">New tour bookings and contact messages will appear here.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FULL DETAIL MODAL -->
        <div v-if="isModalOpen && selectedBooking" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs font-aptos animate-fade-in">
            <div class="bg-white w-full max-w-lg rounded-3xl p-6 sm:p-7 shadow-2xl border border-slate-200 space-y-5 relative">
                
                <!-- Modal Header -->
                <div class="flex justify-between items-start border-b border-slate-100 pb-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-mono font-black text-[#0D47A1] bg-blue-50 px-2.5 py-0.5 rounded-md border border-blue-200">
                                {{ selectedBooking.id }}
                            </span>
                            <span 
                                :class="[
                                    'text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md',
                                    selectedBooking.type === 'Contact Form Lead' ? 'bg-sky-50 text-sky-700' : 'bg-emerald-50 text-emerald-700'
                                ]"
                            >
                                {{ selectedBooking.type }}
                            </span>
                        </div>
                        <h2 class="text-lg font-black text-slate-900 mt-1">{{ selectedBooking.customer_name }}</h2>
                    </div>

                    <button @click="isModalOpen = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 hover:text-slate-800 hover:bg-slate-200 flex items-center justify-center font-bold text-sm transition-colors">
                        ✕
                    </button>
                </div>

                <!-- Contact Action Bar -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <a 
                        :href="`mailto:${selectedBooking.email}`" 
                        class="p-2.5 rounded-xl bg-slate-50 hover:bg-[#0D47A1] hover:text-white text-slate-700 border border-slate-200 text-center text-xs font-bold transition-all flex flex-col items-center gap-1"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <span>Send Email</span>
                    </a>
                    <a 
                        :href="`tel:${formatPhone(selectedBooking.phone)}`" 
                        class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-600 hover:text-white text-slate-700 border border-slate-200 text-center text-xs font-bold transition-all flex flex-col items-center gap-1"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>Call Phone</span>
                    </a>
                    <a 
                        :href="`https://wa.me/${formatPhone(selectedBooking.phone)}`" 
                        target="_blank" 
                        class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-500 hover:text-white text-slate-700 border border-slate-200 text-center text-xs font-bold transition-all flex flex-col items-center gap-1 col-span-2 sm:col-span-1"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.54 1.861.821 2.796.821 3.183 0 5.769-2.586 5.77-5.766.001-3.182-2.585-5.808-5.77-5.808zm3.385 8.212c-.144.405-.837.774-1.17.824-.312.045-.694.079-2.116-.508-1.748-.72-2.859-2.502-2.946-2.617-.087-.116-.708-.941-.708-1.792s.448-1.271.607-1.445c.16-.175.348-.219.465-.219.116 0 .233.001.335.006.107.005.251-.04.391.297.145.349.494 1.206.538 1.294.044.088.073.19.015.306-.058.116-.087.188-.174.29-.088.102-.185.228-.264.306-.088.088-.18.184-.078.36.102.175.454.748.974 1.212.671.597 1.236.782 1.411.87.175.088.277.073.379-.044.102-.117.437-.509.553-.684.117-.175.233-.146.393-.088.16.058 1.018.48 1.193.568.175.087.291.131.335.204.044.073.044.423-.1.828z"/></svg>
                        <span>WhatsApp</span>
                    </a>
                </div>

                <!-- Structured Info Details -->
                <div class="space-y-3.5 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block tracking-wider">Email Address</span>
                            <div class="font-bold text-slate-800 break-all">{{ selectedBooking.email }}</div>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block tracking-wider">Phone / WhatsApp</span>
                            <div class="font-bold text-slate-800">{{ selectedBooking.phone }}</div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200/60 pt-2.5">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block tracking-wider">Requested Package / Subject</span>
                        <div class="font-extrabold text-[#0D47A1] text-sm mt-0.5">{{ selectedBooking.package_title }}</div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 border-t border-slate-200/60 pt-2.5">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block tracking-wider">Preferred Travel Date</span>
                            <div class="font-bold text-slate-800">{{ selectedBooking.travel_date || 'Not Specified' }}</div>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block tracking-wider">Travelers / Guests</span>
                            <div class="font-bold text-slate-800">{{ selectedBooking.guests }} Person(s)</div>
                        </div>
                    </div>

                    <div v-if="selectedBooking.message" class="border-t border-slate-200/60 pt-2.5">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block tracking-wider mb-1">Customer Inquiry Message</span>
                        <div class="p-3 rounded-xl bg-white border border-slate-200 text-slate-800 font-medium leading-relaxed max-h-40 overflow-y-auto whitespace-pre-wrap">
                            {{ selectedBooking.message }}
                        </div>
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="pt-2 flex items-center justify-between">
                    <button 
                        @click="deleteSingle(selectedBooking)" 
                        class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs font-black transition-all flex items-center gap-1.5"
                    >
                        <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        <span>Delete Lead</span>
                    </button>
                    <button @click="isModalOpen = false" class="px-5 py-2.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white text-xs font-extrabold shadow-sm transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
