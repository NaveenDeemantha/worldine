<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalDestinations: 0,
            inboundCount: 0,
            outboundCount: 0,
            totalPackages: 0,
            activePackages: 0,
            featuredPackages: 0,
            avgPackagePrice: '$0',
            totalItineraryDays: 0,
            totalPackageInquiries: 0,
            totalContactInquiries: 0,
            pendingInquiriesCount: 0,
        })
    },
    packageInquiries: {
        type: Array,
        default: () => []
    },
    contactInquiries: {
        type: Array,
        default: () => []
    },
    recentPackages: {
        type: Array,
        default: () => []
    },
    destinationsSummary: {
        type: Array,
        default: () => []
    }
});

const activeInquiryTab = ref('package'); // 'package' or 'contact'
const selectedInquiry = ref(null);
const isInquiryModalOpen = ref(false);

const viewInquiryDetails = (inq) => {
    selectedInquiry.value = inq;
    isInquiryModalOpen.value = true;
};
</script>

<template>
    <Head title="Executive Admin Dashboard - Worldine Destinations" />

    <AuthenticatedLayout>
        <div class="space-y-8 font-aptos">
            
            <!-- 1. METRICS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- Card 1: Package Inquiries (NEW) -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Package Inquiries</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-[#0D47A1] flex items-center justify-center border border-blue-100">
                            <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.totalPackageInquiries }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Tour package bookings</p>
                    </div>
                </div>

                <!-- Card 2: Contact Form Leads (NEW) -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Contact Form Leads</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                            <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.totalContactInquiries }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">General web submissions</p>
                    </div>
                </div>

                <!-- Card 3: Pending Leads -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Action</span>
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100">
                            <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-amber-600 tracking-tight">{{ stats.pendingInquiriesCount }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Awaiting concierge reply</p>
                    </div>
                </div>

                <!-- Card 4: Total Destinations -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Destinations</span>
                        <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center border border-purple-100">
                            <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.totalDestinations }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            <span class="text-blue-700 font-bold">{{ stats.inboundCount }} Inbound</span> • <span class="text-indigo-700 font-bold">{{ stats.outboundCount }} Outbound</span>
                        </p>
                    </div>
                </div>

            </div>

            <!-- 2. DEDICATED INQUIRIES & LEADS SECTION -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                
                <!-- HEADER & TAB SWITCHER -->
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center space-x-2">
                            <h2 class="text-lg font-black text-slate-900">Customer Inquiries & Leads</h2>
                            <span class="text-xs bg-[#0D47A1] text-white px-2 py-0.5 rounded-full font-black">LIVE</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Real-time inquiries submitted via Contact Us form and Tour Package inquiry modals.</p>
                    </div>

                    <!-- Tabs -->
                    <div class="flex items-center p-1 bg-slate-100 rounded-xl">
                        <button 
                            @click="activeInquiryTab = 'package'"
                            :class="[
                                'px-4 py-1.5 rounded-lg text-xs font-extrabold transition-all',
                                activeInquiryTab === 'package' 
                                    ? 'bg-white text-[#0D47A1] shadow-xs' 
                                    : 'text-slate-600 hover:text-slate-900'
                            ]"
                        >
                            Package Inquiries ({{ packageInquiries.length }})
                        </button>
                        <button 
                            @click="activeInquiryTab = 'contact'"
                            :class="[
                                'px-4 py-1.5 rounded-lg text-xs font-extrabold transition-all',
                                activeInquiryTab === 'contact' 
                                    ? 'bg-white text-[#0D47A1] shadow-xs' 
                                    : 'text-slate-600 hover:text-slate-900'
                            ]"
                        >
                            Contact Form Inquiries ({{ contactInquiries.length }})
                        </button>
                    </div>
                </div>

                <!-- TABLE 1: PACKAGE-WISE INQUIRIES -->
                <div v-if="activeInquiryTab === 'package'" class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-medium text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-100">
                            <tr>
                                <th class="py-4 px-6">Ref ID</th>
                                <th class="py-4 px-4">Traveler & Contact</th>
                                <th class="py-4 px-4">Requested Tour Package</th>
                                <th class="py-4 px-4">Travel Date & Guests</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="inq in packageInquiries" :key="inq.db_id" class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-[#0D47A1] whitespace-nowrap">{{ inq.id }}</td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900">{{ inq.customer_name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ inq.email }} • {{ inq.phone }}</div>
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-800">{{ inq.package_title }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-800">{{ inq.travel_date }}</div>
                                    <div class="text-[11px] text-slate-500">{{ inq.guests }} Traveler(s)</div>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <button 
                                        @click="viewInquiryDetails(inq)"
                                        class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#2196F3] hover:text-white text-slate-700 font-bold transition-all"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!packageInquiries.length">
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">No tour package inquiries submitted yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TABLE 2: CONTACT FORM INQUIRIES -->
                <div v-if="activeInquiryTab === 'contact'" class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-medium text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-100">
                            <tr>
                                <th class="py-4 px-6">Ref ID</th>
                                <th class="py-4 px-4">Traveler & Contact</th>
                                <th class="py-4 px-4">Inquiry Category / Destination</th>
                                <th class="py-4 px-4">Travel Date & Guests</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="inq in contactInquiries" :key="inq.db_id" class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-[#0D47A1] whitespace-nowrap">{{ inq.id }}</td>
                                <td class="py-4 px-4">
                                    <div class="font-extrabold text-slate-900">{{ inq.customer_name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ inq.email }} • {{ inq.phone }}</div>
                                </td>
                                <td class="py-4 px-4 font-bold text-slate-800">
                                    <div>{{ inq.inquiry_type }}</div>
                                    <div v-if="inq.destination" class="text-[11px] text-slate-500 font-medium">{{ inq.destination }}</div>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="font-bold text-slate-800">{{ inq.travel_date }}</div>
                                    <div class="text-[11px] text-slate-500">{{ inq.guests }} Traveler(s)</div>
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <button 
                                        @click="viewInquiryDetails(inq)"
                                        class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-[#2196F3] hover:text-white text-slate-700 font-bold transition-all"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!contactInquiries.length">
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">No contact form inquiries submitted yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- 3. RECENT PACKAGES TABLE & DESTINATIONS LIST (RESPONSIVE GRID) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Recent Tour Packages (8 cols) -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-black text-slate-900">Recent Tour Packages</h2>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">List of live tour packages published in the database.</p>
                        </div>
                        <Link 
                            :href="route('admin.packages.index')"
                            class="text-xs font-extrabold text-[#0D47A1] hover:underline"
                        >
                            View All →
                        </Link>
                    </div>

                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left text-xs font-medium text-slate-600 whitespace-nowrap">
                            <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-100">
                                <tr>
                                    <th class="py-4 px-6">Package Title</th>
                                    <th class="py-4 px-4">Destination</th>
                                    <th class="py-4 px-4">Duration</th>
                                    <th class="py-4 px-4">Price</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="pkg in recentPackages" :key="pkg.id" class="hover:bg-slate-50/70 transition-colors">
                                    <td class="py-4 px-6 font-bold text-slate-900">
                                        <div class="flex items-center space-x-2">
                                            <span>{{ pkg.title }}</span>
                                            <span v-if="pkg.is_featured" class="text-[9px] bg-amber-100 text-amber-800 font-black px-1.5 py-0.5 rounded uppercase">Featured</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-700 font-semibold">{{ pkg.destination }}</td>
                                    <td class="py-4 px-4 text-slate-600">{{ pkg.duration }}</td>
                                    <td class="py-4 px-4">
                                        <span v-if="pkg.price && pkg.price !== 'On Request' && pkg.price !== '$0'" class="font-black text-slate-900">{{ pkg.price }}</span>
                                        <span v-else class="text-xs font-bold text-amber-700 inline-flex items-center space-x-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span><span>On Request</span></span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center space-x-1.5 text-xs font-bold">
                                            <span :class="['w-2 h-2 rounded-full', pkg.is_active ? 'bg-emerald-500' : 'bg-slate-400']"></span>
                                            <span :class="pkg.is_active ? 'text-emerald-700' : 'text-slate-500'">{{ pkg.is_active ? 'Active' : 'Draft' }}</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="!recentPackages.length">
                                    <td colspan="5" class="py-10 text-center text-slate-400 font-medium">No tour packages created yet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Destinations Inventory List (4 cols) -->
                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 shadow-xs p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Destinations</h3>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">Catalog overview</p>
                        </div>
                        <Link :href="route('admin.destinations.index')" class="text-xs font-extrabold text-[#0D47A1] hover:underline">Manage →</Link>
                    </div>

                    <div class="space-y-3">
                        <div 
                            v-for="dest in destinationsSummary" 
                            :key="dest.id"
                            class="p-3.5 rounded-xl bg-slate-50 flex items-center justify-between border border-slate-100/80"
                        >
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-xs text-slate-900">{{ dest.name }}</span>
                                    <span class="text-[9px] bg-slate-200 text-slate-700 px-1.5 py-0.5 rounded font-bold uppercase">{{ dest.type }}</span>
                                </div>
                                <span class="text-[11px] text-slate-500 font-medium block mt-0.5">{{ dest.badge }}</span>
                            </div>
                            <span class="text-xs font-black text-slate-800 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                {{ dest.packages_count }} Tours
                            </span>
                        </div>
                    </div>

                    <!-- Quick Link: Contact CMS -->
                    <div class="pt-2 border-t border-slate-100">
                        <Link 
                            :href="route('admin.contact.index')"
                            class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold flex items-center justify-between transition-colors"
                        >
                            <span>Contact Page CMS Settings</span>
                            <span>→</span>
                        </Link>
                    </div>
                </div>

            </div>

        </div>

        <!-- MODAL: INQUIRY DETAILS VIEW -->
        <div v-if="isInquiryModalOpen && selectedInquiry" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs font-aptos">
            <div class="bg-white w-full max-w-lg rounded-3xl p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                        <span class="text-xs font-mono font-extrabold text-[#0D47A1]">{{ selectedInquiry.id }}</span>
                        <h3 class="text-lg font-black text-slate-900 mt-0.5">Traveler Inquiry Details</h3>
                    </div>
                    <button @click="isInquiryModalOpen = false" class="text-slate-400 hover:text-slate-700 font-bold p-1">✕</button>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-[10px] text-slate-400 uppercase font-bold block">Customer Name</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ selectedInquiry.customer_name }}</span>
                    </div>

                    <div class="space-y-1.5 p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="flex justify-between"><span class="text-slate-500 font-bold">Email:</span> <span class="font-bold text-slate-900">{{ selectedInquiry.email }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500 font-bold">Phone Hotline:</span> <span class="font-bold text-slate-900">{{ selectedInquiry.phone }}</span></div>
                        <div v-if="selectedInquiry.package_title" class="flex justify-between"><span class="text-slate-500 font-bold">Tour Package:</span> <span class="font-black text-[#0D47A1]">{{ selectedInquiry.package_title }}</span></div>
                        <div v-if="selectedInquiry.inquiry_type" class="flex justify-between"><span class="text-slate-500 font-bold">Category:</span> <span class="font-bold text-slate-900">{{ selectedInquiry.inquiry_type }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500 font-bold">Travel Date:</span> <span class="font-bold text-slate-900">{{ selectedInquiry.travel_date }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500 font-bold">Travelers:</span> <span class="font-bold text-slate-900">{{ selectedInquiry.guests }} Guest(s)</span></div>
                    </div>

                    <div v-if="selectedInquiry.message" class="p-3 rounded-xl bg-blue-50/60 border border-blue-100 space-y-1">
                        <span class="text-[10px] uppercase font-bold text-[#0D47A1] block">Customer Message / Special Requirements</span>
                        <p class="text-slate-700 font-medium leading-relaxed">{{ selectedInquiry.message }}</p>
                    </div>
                </div>

                <div class="pt-2 flex justify-end">
                    <button 
                        @click="isInquiryModalOpen = false" 
                        class="px-5 py-2 rounded-xl bg-[#0D47A1] hover:bg-blue-800 text-white text-xs font-bold transition-all shadow-sm"
                    >
                        Close Window
                    </button>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
