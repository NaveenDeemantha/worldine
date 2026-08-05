<script setup>
import AuthenticatedLayout from '@/Backend/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
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
        })
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
</script>

<template>
    <Head title="Admin Dashboard - Worldine Destinations" />

    <AuthenticatedLayout>
        <div class="space-y-8 font-aptos">
            
            <!-- 1. SPACIOUS CLEAN METRICS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: Total Destinations -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Destinations</span>
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs">🗺️</div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.totalDestinations }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            <span class="text-blue-700 font-bold">{{ stats.inboundCount }} Inbound</span> • <span class="text-indigo-700 font-bold">{{ stats.outboundCount }} Outbound</span>
                        </p>
                    </div>
                </div>

                <!-- Card 2: Active Packages -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Tour Packages</span>
                        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-black text-xs">🌴</div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.activePackages }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            <span class="text-emerald-700 font-bold">{{ stats.featuredPackages }} Featured</span> • <span>{{ stats.totalPackages }} Total</span>
                        </p>
                    </div>
                </div>

                <!-- Card 3: Average Tour Price -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Avg Package Price</span>
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-black text-xs">💲</div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.avgPackagePrice }}</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Average tour cost</p>
                    </div>
                </div>

                <!-- Card 4: Itineraries -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Itineraries</span>
                        <div class="w-9 h-9 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center font-black text-xs">📅</div>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ stats.totalItineraryDays }} Days</h3>
                        <p class="text-xs text-slate-500 font-medium mt-1">Total itinerary steps</p>
                    </div>
                </div>

            </div>

            <!-- 2. RECENT PACKAGES TABLE & DESTINATIONS LIST (RESPONSIVE GRID) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Recent Tour Packages (8 cols) -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-black text-slate-900">Recent Packages</h2>
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
                                    <td class="py-4 px-4 font-black text-slate-900">{{ pkg.price }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <span 
                                            :class="[
                                                'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border',
                                                pkg.is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200'
                                            ]"
                                        >
                                            {{ pkg.is_active ? 'Active' : 'Draft' }}
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
    </AuthenticatedLayout>
</template>
