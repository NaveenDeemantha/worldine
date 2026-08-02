<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

// Executive Light Theme Analytics Data (Zero Emojis, Pure Professional Vector SVG Icons)
const stats = ref([
    { 
        title: 'Total Revenue', 
        value: '$148,500', 
        change: '+18.4%', 
        isPositive: true, 
        iconPath: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 
        iconBg: 'bg-emerald-50 text-emerald-600 border-emerald-200',
        sub: 'vs $125.4k last month' 
    },
    { 
        title: 'Active Bookings', 
        value: '342', 
        change: '+12.5%', 
        isPositive: true, 
        iconPath: 'M15 5v2m-6-2v2M5 11h14M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 
        iconBg: 'bg-blue-50 text-blue-600 border-blue-200',
        sub: '24 pending approval' 
    },
    { 
        title: 'Popular Destination', 
        value: 'Sri Lanka', 
        change: '145 Tours', 
        isPositive: true, 
        iconPath: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V7a2 2 0 00-2-2h-1.5A2.5 2.5 0 0113 2.5V2M12 21a9 9 0 100-18 9 9 0 000 18z', 
        iconBg: 'bg-sky-50 text-sky-600 border-sky-200',
        sub: 'Inbound #1 Choice' 
    },
    { 
        title: 'Total Travelers', 
        value: '1,280', 
        change: '+8.2%', 
        isPositive: true, 
        iconPath: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 
        iconBg: 'bg-indigo-50 text-indigo-600 border-indigo-200',
        sub: 'Active explorers' 
    }
]);

const recentBookings = ref([
    { id: 'WRD-8021', customer: 'Alexander Wright', email: 'alex.w@gmail.com', destination: 'Heritage & Cultural Tour Sri Lanka', date: 'Aug 12 - Aug 17', price: '$1,700', status: 'Confirmed', badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200' },
    { id: 'WRD-8022', customer: 'Sophia Chen', email: 'sophia.c@outlook.com', destination: 'Maldives Luxury Overwater Escape', date: 'Sep 02 - Sep 07', price: '$3,700', status: 'Pending', badgeClass: 'bg-amber-50 text-amber-700 border-amber-200' },
    { id: 'WRD-8023', customer: 'Marcus Vance', email: 'marcus.v@yahoo.com', destination: 'East Asia Cultural Discovery - Japan', date: 'Aug 20 - Aug 27', price: '$4,200', status: 'Confirmed', badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200' },
    { id: 'WRD-8024', customer: 'Elena Rostova', email: 'elena.r@hotmail.com', destination: 'Sri Lanka Wildlife & Nature Safari', date: 'Aug 25 - Aug 31', price: '$1,980', status: 'In Progress', badgeClass: 'bg-blue-50 text-blue-700 border-blue-200' },
    { id: 'WRD-8025', customer: 'Liam O’Connor', email: 'liam.oc@gmail.com', destination: 'Europe Schengen Grand Expedition', date: 'Oct 05 - Oct 14', price: '$4,900', status: 'Confirmed', badgeClass: 'bg-emerald-50 text-emerald-700 border-emerald-200' }
]);

const topDestinations = ref([
    { name: 'Sri Lanka Inbound Tours', count: '145 Bookings', share: 45, color: 'bg-[#0D47A1]' },
    { name: 'Maldives Overwater Escapes', count: '82 Bookings', share: 26, color: 'bg-[#2196F3]' },
    { name: 'Japan & East Asia Tours', count: '64 Bookings', share: 18, color: 'bg-indigo-600' },
    { name: 'Dubai Sky Towers & Desert', count: '36 Bookings', share: 11, color: 'bg-slate-600' }
]);
</script>

<template>
    <Head title="Admin Dashboard - Worldine Destinations" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Executive Dashboard</h1>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Performance metrics and tour reservation overview for Worldine Destinations.</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button class="px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold border border-slate-200 transition-colors shadow-xs flex items-center space-x-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Export Analytics</span>
                    </button>

                    <button class="px-4 py-2 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white text-xs font-bold transition-all shadow-md flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Create Tour Package</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="space-y-8 font-aptos">
            
            <!-- STATS CARDS GRID (LIGHT EXECUTIVE THEME) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div 
                    v-for="(s, idx) in stats" 
                    :key="idx" 
                    class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs relative overflow-hidden group hover:border-slate-300 transition-all duration-200"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ s.title }}</span>
                        <div :class="['w-10 h-10 rounded-xl border flex items-center justify-center shadow-xs', s.iconBg]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" :d="s.iconPath" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4 flex items-baseline justify-between">
                        <span class="text-3xl font-black text-slate-900 tracking-tight">{{ s.value }}</span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ s.change }}
                        </span>
                    </div>

                    <div class="mt-2 text-[11px] font-medium text-slate-500">
                        {{ s.sub }}
                    </div>
                </div>
            </div>

            <!-- TWO COLUMN MAIN SECTION: RECENT BOOKINGS & TOP DESTINATIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- LEFT: RECENT BOOKINGS TABLE (8 COLUMNS) -->
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl shadow-xs overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-slate-200 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Recent Tour Reservations</h3>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Latest inbound and outbound traveler requests</p>
                        </div>
                        <button class="text-xs font-bold text-[#0D47A1] hover:text-[#2196F3] flex items-center space-x-1">
                            <span>View All Reservations</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                    <th class="py-3.5 px-6">Booking ID</th>
                                    <th class="py-3.5 px-6">Customer</th>
                                    <th class="py-3.5 px-6">Destination</th>
                                    <th class="py-3.5 px-6">Dates</th>
                                    <th class="py-3.5 px-6">Amount</th>
                                    <th class="py-3.5 px-6">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                <tr 
                                    v-for="b in recentBookings" 
                                    :key="b.id"
                                    class="hover:bg-slate-50 transition-colors"
                                >
                                    <td class="py-4 px-6 font-mono font-bold text-[#0D47A1]">{{ b.id }}</td>
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-900">{{ b.customer }}</div>
                                        <div class="text-[11px] text-slate-500">{{ b.email }}</div>
                                    </td>
                                    <td class="py-4 px-6 font-medium text-slate-700 max-w-[200px] truncate">{{ b.destination }}</td>
                                    <td class="py-4 px-6 text-slate-500 font-medium">{{ b.date }}</td>
                                    <td class="py-4 px-6 font-bold text-slate-900">{{ b.price }}</td>
                                    <td class="py-4 px-6">
                                        <span :class="['px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider', b.badgeClass]">
                                            {{ b.status }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- RIGHT: TOP DESTINATIONS PERFORMANCE & QUICK ACTIONS (4 COLUMNS) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- TOP DESTINATIONS CHART / PROGRESS -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-5">
                        <div>
                            <h3 class="text-base font-black text-slate-900">Destination Performance</h3>
                            <p class="text-xs text-slate-500 mt-0.5 font-medium">Most requested regions this quarter</p>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div v-for="(dest, i) in topDestinations" :key="i" class="space-y-1.5">
                                <div class="flex items-center justify-between text-xs font-bold">
                                    <span class="text-slate-800">{{ dest.name }}</span>
                                    <span class="text-slate-500 font-semibold">{{ dest.count }}</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div :class="['h-full rounded-full', dest.color]" :style="{ width: dest.share + '%' }"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QUICK CONCIERGE ACTIONS -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-xs space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-900">Concierge Quick Actions</h4>
                                <p class="text-[11px] text-slate-500 font-medium">Direct management shortcuts</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2.5 pt-2">
                            <a href="/" target="_blank" class="p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 hover:text-slate-900 flex flex-col items-center justify-center text-center space-y-1.5 transition-all">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <span>Live Website</span>
                            </a>
                            <Link href="/profile" class="p-3 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 hover:text-slate-900 flex flex-col items-center justify-center text-center space-y-1.5 transition-all">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                </svg>
                                <span>Settings</span>
                            </Link>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>
