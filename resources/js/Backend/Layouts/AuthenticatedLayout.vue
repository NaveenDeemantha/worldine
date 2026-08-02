<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Backend/Components/Dropdown.vue';
import DropdownLink from '@/Backend/Components/DropdownLink.vue';

const sidebarOpen = ref(false);
const isCollapsed = ref(false);
const page = usePage();

const navItems = [
    {
        name: 'Dashboard',
        href: route('dashboard'),
        activeName: 'dashboard',
        iconPath: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
    },
    {
        name: 'Tours & Packages',
        href: route('dashboard'),
        activeName: 'tours',
        badge: '18 Active',
        iconPath: 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8'
    },
    {
        name: 'Destinations',
        href: route('dashboard'),
        activeName: 'destinations',
        iconPath: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V7a2 2 0 00-2-2h-1.5A2.5 2.5 0 0113 2.5V2M12 21a9 9 0 100-18 9 9 0 000 18z'
    },
    {
        name: 'Bookings & Leads',
        href: route('dashboard'),
        activeName: 'bookings',
        badge: '5 New',
        badgeColor: 'bg-amber-100 text-amber-800 border-amber-200',
        iconPath: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'
    },
    {
        name: 'Airline Partners',
        href: route('dashboard'),
        activeName: 'airlines',
        iconPath: 'M5 13l4 4L19 7'
    },
    {
        name: 'Profile & Settings',
        href: route('profile.edit'),
        activeName: 'profile.edit',
        iconPath: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'
    }
];

const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 text-slate-900 flex font-sans antialiased">
        
        <!-- MOBILE SIDEBAR OVERLAY BACKDROP -->
        <div 
            v-if="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-xs md:hidden transition-opacity"
        ></div>

        <!-- SIDEBAR PANEL (LIGHT THEME) -->
        <aside 
            :class="[
                'fixed md:static inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-slate-200/90 transition-all duration-300 shadow-sm flex-shrink-0',
                isCollapsed ? 'md:w-20' : 'md:w-64',
                sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full md:translate-x-0'
            ]"
        >
            <!-- SIDEBAR HEADER (BRAND LOGO) -->
            <div class="h-20 flex items-center justify-between px-5 border-b border-slate-200/80 bg-slate-50/50">
                <Link href="/dashboard" class="flex items-center space-x-3 overflow-hidden group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0D47A1] to-[#2196F3] flex items-center justify-center font-black text-white text-xl shadow-md flex-shrink-0">
                        W
                    </div>
                    <div v-if="!isCollapsed || sidebarOpen" class="flex flex-col">
                        <span class="font-black text-base tracking-tight text-[#0D47A1] leading-tight">WORLDINE</span>
                        <span class="text-[10px] font-bold text-slate-500 tracking-widest uppercase">Admin Portal</span>
                    </div>
                </Link>

                <!-- Collapse Toggle (Desktop) -->
                <button 
                    @click="toggleCollapse"
                    class="hidden md:flex w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 items-center justify-center transition-colors border border-slate-200"
                    title="Toggle Sidebar"
                >
                    <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': isCollapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- NAVIGATION ITEMS LIST -->
            <div class="flex-1 overflow-y-auto py-6 px-3 space-y-1.5">
                <div v-if="!isCollapsed || sidebarOpen" class="px-3 pb-2 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                    Navigation Menu
                </div>

                <Link
                    v-for="(item, idx) in navItems"
                    :key="idx"
                    :href="item.href"
                    :class="[
                        'flex items-center px-3.5 py-3 rounded-xl font-semibold text-xs transition-all duration-150 group relative',
                        route().current(item.activeName) 
                            ? 'bg-[#0D47A1] text-white shadow-sm font-bold' 
                            : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80'
                    ]"
                    :title="isCollapsed ? item.name : ''"
                >
                    <!-- Vector SVG Icon -->
                    <svg 
                        class="w-5 h-5 flex-shrink-0 transition-transform group-hover:scale-105" 
                        :class="route().current(item.activeName) ? 'text-white' : 'text-slate-400 group-hover:text-[#2196F3]'"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" :d="item.iconPath" />
                    </svg>

                    <!-- Label Text -->
                    <span v-if="!isCollapsed || sidebarOpen" class="ml-3 truncate font-semibold">
                        {{ item.name }}
                    </span>

                    <!-- Badge -->
                    <span 
                        v-if="(item.badge && (!isCollapsed || sidebarOpen))" 
                        :class="[
                            'ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full border',
                            item.badgeColor || 'bg-blue-50 text-blue-700 border-blue-200'
                        ]"
                    >
                        {{ item.badge }}
                    </span>
                </Link>
            </div>

            <!-- SIDEBAR FOOTER CARD (USER PROFILE & LOGOUT) -->
            <div class="p-3 border-t border-slate-200/80 bg-slate-50/70">
                <div :class="['flex items-center p-2 rounded-xl bg-white border border-slate-200 shadow-xs', isCollapsed && !sidebarOpen ? 'justify-center' : 'justify-between']">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#0D47A1] to-[#2196F3] flex items-center justify-center text-white font-bold text-xs shadow-xs flex-shrink-0">
                            {{ $page.props.auth.user.name.charAt(0) }}
                        </div>
                        <div v-if="!isCollapsed || sidebarOpen" class="flex flex-col truncate">
                            <span class="text-xs font-bold text-slate-900 truncate">{{ $page.props.auth.user.name }}</span>
                            <span class="text-[10px] text-slate-500 truncate">{{ $page.props.auth.user.email }}</span>
                        </div>
                    </div>

                    <!-- Quick Logout Button -->
                    <Link 
                        v-if="!isCollapsed || sidebarOpen"
                        :href="route('logout')" 
                        method="post" 
                        as="button"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors"
                        title="Log Out"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </Link>
                </div>
            </div>
        </aside>

        <!-- MAIN LAYOUT CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50 overflow-y-auto">
            
            <!-- TOP NAVBAR STRIP (LIGHT THEME) -->
            <header class="h-20 bg-white border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                
                <!-- Left Header: Mobile Toggle & Page Title/Breadcrumb -->
                <div class="flex items-center space-x-4">
                    <button 
                        @click="sidebarOpen = !sidebarOpen" 
                        class="md:hidden p-2 rounded-xl bg-slate-100 text-slate-600 hover:text-slate-900"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div v-if="$slots.header">
                        <slot name="header" />
                    </div>
                </div>

                <!-- Right Header Actions: Live Website Link & User Dropdown -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    
                    <!-- View Live Website Button (Vector Icon) -->
                    <a 
                        href="/" 
                        target="_blank" 
                        class="hidden sm:inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-slate-700 hover:text-slate-900 transition-all shadow-xs"
                    >
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        <span>View Website</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    <!-- User Account Dropdown -->
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center space-x-2.5 p-1.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-slate-800 transition-colors">
                                <div class="w-6 h-6 rounded-full bg-[#0D47A1] text-white font-bold flex items-center justify-center text-[10px]">
                                    {{ $page.props.auth.user.name.charAt(0) }}
                                </div>
                                <span class="hidden md:inline">{{ $page.props.auth.user.name }}</span>
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-4 py-2 border-b border-slate-100 text-xs text-slate-500">
                                Signed in as <strong class="text-slate-800 font-bold block truncate">{{ $page.props.auth.user.email }}</strong>
                            </div>
                            <DropdownLink :href="route('profile.edit')">
                                Profile Settings
                            </DropdownLink>
                            <DropdownLink href="/" target="_blank">
                                Open Main Website
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- MAIN BODY CONTENT -->
            <main class="flex-1 p-4 sm:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
