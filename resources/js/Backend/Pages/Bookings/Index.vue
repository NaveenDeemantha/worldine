<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    bookings: { type: Array, default: () => [] },
});

const selectedBooking = ref(null);
const isModalOpen = ref(false);

const viewBooking = (b) => {
    selectedBooking.value = b;
    isModalOpen.value = true;
};
</script>

<template>
    <Head title="Bookings & Customer Leads - Admin Portal" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 font-aptos">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Bookings & Customer Leads</h1>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Manage incoming tour reservation inquiries submitted by travelers on Worldine Destinations.</p>
                </div>
            </div>
        </template>

        <div class="space-y-6 font-aptos">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-extrabold border-b border-slate-200">
                            <tr>
                                <th class="p-4">Reference ID</th>
                                <th class="p-4">Customer Name & Contact</th>
                                <th class="p-4">Inquiry Source</th>
                                <th class="p-4">Requested Package / Subject</th>
                                <th class="p-4">Travel Date & Guests</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                            <tr v-for="b in bookings" :key="b.id" class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-4 font-mono font-bold text-[#0D47A1]">{{ b.id }}</td>
                                <td class="p-4">
                                    <div class="font-extrabold text-slate-900">{{ b.customer_name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ b.email }} • {{ b.phone }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center space-x-1.5 text-xs font-bold text-slate-700">
                                        <span :class="['w-2 h-2 rounded-full', b.type === 'Contact Form Lead' ? 'bg-sky-500' : 'bg-[#0D47A1]']"></span>
                                        <span>{{ b.type === 'Contact Form Lead' ? 'Web Contact Form' : 'Tour Package' }}</span>
                                    </span>
                                </td>
                                <td class="p-4 font-bold text-slate-800">{{ b.package_title }}</td>
                                <td class="p-4">
                                    <div>{{ b.travel_date }}</div>
                                    <div class="text-[11px] text-slate-500">{{ b.guests }} Traveler(s)</div>
                                </td>
                                <td class="p-4 text-right">
                                    <button @click="viewBooking(b)" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#2196F3] hover:text-white text-slate-700 font-bold transition-all">View Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL -->
        <div v-if="isModalOpen && selectedBooking" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs font-aptos">
            <div class="bg-white w-full max-w-md rounded-3xl p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <span class="text-xs font-mono font-extrabold text-[#0D47A1]">{{ selectedBooking.id }}</span>
                    <button @click="isModalOpen = false" class="text-slate-400 font-bold">✕</button>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 font-bold uppercase block">Customer Name</span>
                        <div class="font-extrabold text-slate-900 text-sm">{{ selectedBooking.customer_name }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase block">Contact Details</span>
                        <div class="font-semibold text-slate-700">{{ selectedBooking.email }}</div>
                        <div class="font-semibold text-slate-700">{{ selectedBooking.phone }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase block">Requested Package</span>
                        <div class="font-bold text-[#0D47A1]">{{ selectedBooking.package_title }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400 font-bold uppercase block">Travel Details</span>
                        <div class="font-semibold text-slate-800">Date: {{ selectedBooking.travel_date }} ({{ selectedBooking.guests }} Guests)</div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button @click="isModalOpen = false" class="px-4 py-2 rounded-xl bg-[#0D47A1] text-white text-xs font-extrabold">Close</button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
