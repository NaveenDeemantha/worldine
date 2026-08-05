<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '@/Frontend/Components/Navbar.vue';

const props = defineProps({
    settings: {
        type: Object,
        default: () => ({})
    }
});

// Inertia Form State
const form = useForm({
    name: '',
    email: '',
    phone: '',
    inquiry_type: 'Sri Lanka Inbound Tour',
    destination: '',
    travel_dates: '',
    travelers: '1-2 Guests',
    message: ''
});

const isSubmitted = ref(false);
const submitting = ref(false);

const submitForm = () => {
    submitting.value = true;
    
    // Post to backend route
    form.post(route('contact.send'), {
        preserveScroll: true,
        onSuccess: () => {
            submitting.value = false;
            isSubmitted.value = true;
            form.reset();
        },
        onError: () => {
            submitting.value = false;
            isSubmitted.value = true;
        }
    });
};

// Preset Inquiry Quick Fill
const setQuickInquiry = (type, dest) => {
    form.inquiry_type = type;
    if (dest) form.destination = dest;
    const formElement = document.getElementById('contact-form');
    if (formElement) formElement.scrollIntoView({ behavior: 'smooth' });
};

// FAQ Accordion State
const activeFaq = ref(0);
const toggleFaq = (index) => {
    activeFaq.value = activeFaq.value === index ? null : index;
};

const faqs = [
    {
        question: "How quickly will I receive a customized tour quotation?",
        answer: "Our dedicated travel concierges respond to all inquiries within 2 hours during business hours. For urgent travel or emergency bookings, our WhatsApp hotlines (+94 766 834 881 / +94 778 869 222) operate 24/7."
    },
    {
        question: "Do you assist with Tourist Visas & Air Ticketing?",
        answer: "Yes! Worldine Destinations provides end-to-end travel management including Tourist Visa assistance for Schengen Europe, UK, Japan, Australia, UAE, and Asian destinations, along with competitive international airfare ticketing."
    },
    {
        question: "Can I customize an existing package on the site?",
        answer: "Absolutely. All our Sri Lanka inbound and outbound itineraries are 100% customizable. You can request changes to hotel categories, tour duration, specific excursion activities, or private chauffeur transport options."
    },
    {
        question: "What payment methods do you support?",
        answer: "We support secure international credit/debit card payments (Visa, MasterCard), wire bank transfers, and local currency payments. Detailed invoicing and receipt confirmation are provided for every booking."
    },
    {
        question: "Is Worldine Destinations a licensed travel operator?",
        answer: "Yes, Worldine Destinations (Pvt) Ltd is fully licensed by the Sri Lanka Tourism Development Authority (SLTDA) with over 20 years of proven travel trade excellence in inbound expeditions and outbound holiday management."
    }
];
</script>

<template>
    <Head title="Contact Us & 24/7 Travel Desk - Worldine Destinations" />

    <div class="min-h-screen font-spinnaker bg-slate-50 text-slate-800 selection:bg-[#2196F3] selection:text-white w-full overflow-x-hidden">
        <Navbar />

        <!-- 1. HERO BANNER SECTION (DYNAMIC CONTENT FROM ADMIN PANEL) -->
        <section class="relative h-[48vh] min-h-[350px] sm:min-h-[400px] flex items-center justify-center bg-slate-950 text-white overflow-hidden w-full">
            <div class="absolute inset-0 z-0">
                <img 
                    src="/images/Logo/worldineback.png" 
                    alt="Worldine Travel Desk" 
                    class="w-full h-full object-cover object-center filter brightness-90"
                    fetchpriority="high"
                />
                <!-- Smooth White Top Fade for Navbar -->
                <div class="absolute top-0 left-0 right-0 h-20 sm:h-28 bg-gradient-to-b from-white via-white/20 to-transparent pointer-events-none z-10"></div>
                <!-- Soft Dark Protection Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-950/40 z-10"></div>
            </div>

            <div class="relative z-20 text-center w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 space-y-4 pt-10 sm:pt-14 max-w-5xl mx-auto">
                <span class="text-[11px] sm:text-xs font-black uppercase tracking-[0.3em] text-[#2196F3] bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full inline-block">
                    {{ settings?.hero_badge || '24/7 DEDICATED CONCIERGE & SUPPORT' }}
                </span>
                <h1 class="text-3xl sm:text-5xl md:text-6xl font-black tracking-tight text-white uppercase leading-tight">
                    {{ settings?.hero_title || 'Contact Worldine Destinations' }}
                </h1>
                <p class="text-slate-200 text-xs sm:text-base max-w-2xl mx-auto font-medium leading-relaxed">
                    {{ settings?.hero_subtitle || 'Have a question about a tour package, visa processing, custom Sri Lanka itinerary, or corporate trip? Our team of travel experts is ready to assist you.' }}
                </p>
                
                <!-- Quick Action Buttons -->
                <div class="pt-2 flex flex-wrap items-center justify-center gap-3">
                    <a 
                        :href="`https://wa.me/${(settings?.primary_phone || '+94766834881').replace(/[^0-9]/g, '')}`" 
                        target="_blank"
                        class="px-6 py-2.5 rounded-full bg-[#25D366] hover:bg-[#20bd5a] text-white font-extrabold text-xs uppercase tracking-wider transition-all flex items-center space-x-2"
                    >
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l.999 1.595-1.152 4.21 4.316-1.132 1.58.994z"/>
                        </svg>
                        <span>WhatsApp Chat</span>
                    </a>
                    <a 
                        :href="`tel:${settings?.primary_phone || '+94766834881'}`" 
                        class="px-6 py-2.5 rounded-full bg-[#2B70B4] hover:bg-[#1E5288] text-white font-extrabold text-xs uppercase tracking-wider transition-all flex items-center space-x-2"
                    >
                        <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span>Call {{ settings?.primary_phone || '+94 766 834 881' }}</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- 2. CONTACT INFORMATION DETAILS (DYNAMIC EDITABLE VALUES) -->
        <section class="py-16 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 bg-white">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10">
                
                <!-- Column 1: WhatsApp & Hotlines -->
                <div class="space-y-4">
                    <div class="w-10 h-10 rounded-xl bg-[#2B70B4]/10 text-[#2B70B4] flex items-center justify-center">
                        <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#2196F3] block">24/7 SUPPORT DESK</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">Phone & WhatsApp</h3>
                    </div>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        Connect directly with our senior travel concierges for instant quotes & tour assistance.
                    </p>
                    <div class="space-y-2 text-xs font-bold text-slate-800 pt-1">
                        <a :href="`tel:${settings?.primary_phone || '+94766834881'}`" class="flex items-center justify-between hover:text-[#2196F3] transition-colors py-1">
                            <span class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>{{ settings?.primary_phone || '+94 766 834 881' }}</span>
                            </span>
                            <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-md font-extrabold">Primary</span>
                        </a>
                        <a :href="`tel:${settings?.outbound_phone || '+94718834881'}`" class="flex items-center justify-between hover:text-[#2196F3] transition-colors py-1">
                            <span class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>{{ settings?.outbound_phone || '+94 718 834 881' }}</span>
                            </span>
                            <span class="text-[10px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded-md font-extrabold">Outbound</span>
                        </a>
                        <a :href="`tel:${settings?.inbound_phone || '+94778869222'}`" class="flex items-center justify-between hover:text-[#2196F3] transition-colors py-1">
                            <span class="flex items-center space-x-2">
                                <svg class="w-3.5 h-3.5 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>{{ settings?.inbound_phone || '+94 778 869 222' }}</span>
                            </span>
                            <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-md font-extrabold">Inbound</span>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Official Email -->
                <div class="space-y-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 block">DIGITAL INQUIRIES</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">Email Support</h3>
                    </div>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        Send us your custom itinerary specifications, visa documents, or partnership requests.
                    </p>
                    <div class="space-y-3 text-xs font-bold text-slate-800 pt-1">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">General Inquiries</span>
                            <a :href="`mailto:${settings?.primary_email || 'info@worldinedestinations.com'}`" class="text-slate-900 hover:text-[#2196F3] transition-colors break-all">{{ settings?.primary_email || 'info@worldinedestinations.com' }}</a>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">Tour Quotations</span>
                            <a :href="`mailto:${settings?.tours_email || 'tours@worldinedestinations.com'}`" class="text-slate-900 hover:text-[#2196F3] transition-colors break-all">{{ settings?.tours_email || 'tours@worldinedestinations.com' }}</a>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Headquarter Address -->
                <div class="space-y-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-amber-600 block">HEADQUARTER OFFICE</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">Visit Our Office</h3>
                    </div>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        Visit our central travel center in Colombo for face-to-face consultation & visa processing.
                    </p>
                    <div class="space-y-1 text-xs font-bold text-slate-900 pt-1">
                        <div class="text-[11px] text-slate-700 font-semibold leading-normal">
                            {{ settings?.office_address || 'Worldine Destinations (Pvt) Ltd, Galle Road, Colombo 03, Sri Lanka.' }}
                        </div>
                        <a href="#location-map" class="inline-flex items-center space-x-1.5 text-xs text-[#2196F3] font-extrabold hover:underline pt-1">
                            <span>View Directions</span>
                            <span>↓</span>
                        </a>
                    </div>
                </div>

                <!-- Column 4: Working Hours & Emergency Desk -->
                <div class="space-y-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 block">SERVICE TIMINGS</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">Office Hours</h3>
                    </div>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        Our office welcomes clients during standard working hours; emergency desks run 24/7.
                    </p>
                    <div class="space-y-2 text-xs font-medium text-slate-700 pt-1">
                        <div class="flex justify-between items-center py-0.5">
                            <span class="font-bold text-slate-900">Mon – Fri</span>
                            <span class="text-[11px] font-semibold text-slate-600">{{ settings?.office_hours_weekday || '8:30 AM – 6:30 PM' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-0.5">
                            <span class="font-bold text-slate-900">Saturday</span>
                            <span class="text-[11px] font-semibold text-slate-600">{{ settings?.office_hours_saturday || '9:00 AM – 4:00 PM' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-0.5">
                            <span class="font-bold text-slate-900">Sunday</span>
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">{{ settings?.office_hours_sunday || '24/7 On-Call Support' }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 3. INTERACTIVE CONTACT & INQUIRY FORM SECTION (DYNAMIC FORM HEADINGS) -->
        <section id="contact-form" class="py-16 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 bg-slate-100/60">
            <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-start">
                
                <!-- Left Sidebar / Info & Presets (5 cols) -->
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <span class="text-xs font-black uppercase tracking-[0.25em] text-[#2196F3]">QUICK CONSULTATION</span>
                        <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-slate-900 mt-1">{{ settings?.form_title || 'Send Us A Message' }}</h2>
                        <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed mt-3">
                            {{ settings?.form_subtitle || 'Complete the inquiry form and our travel experts will curate a personalized itinerary, flight options, or visa guidance tailored to your budget.' }}
                        </p>
                    </div>

                    <!-- Quick Category Presets -->
                    <div class="space-y-2.5 pt-2">
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Popular Inquiry Types:</span>
                        <div class="flex flex-wrap gap-2">
                            <button 
                                @click="setQuickInquiry('Sri Lanka Inbound Tour', 'Sigiriya & Kandy Heritage')"
                                class="px-3.5 py-1.5 rounded-full bg-white hover:bg-[#2196F3] text-slate-700 hover:text-white text-xs font-bold transition-all flex items-center space-x-1.5"
                            >
                                <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                                <span>Sri Lanka Inbound</span>
                            </button>
                            <button 
                                @click="setQuickInquiry('Outbound Tour Package', 'Maldives Luxury Escape')"
                                class="px-3.5 py-1.5 rounded-full bg-white hover:bg-[#2196F3] text-slate-700 hover:text-white text-xs font-bold transition-all flex items-center space-x-1.5"
                            >
                                <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                                <span>Maldives Escape</span>
                            </button>
                            <button 
                                @click="setQuickInquiry('Outbound Tour Package', 'Dubai & UAE Explorer')"
                                class="px-3.5 py-1.5 rounded-full bg-white hover:bg-[#2196F3] text-slate-700 hover:text-white text-xs font-bold transition-all flex items-center space-x-1.5"
                            >
                                <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/></svg>
                                <span>Dubai Safari</span>
                            </button>
                            <button 
                                @click="setQuickInquiry('Visa & Air Ticketing', '')"
                                class="px-3.5 py-1.5 rounded-full bg-white hover:bg-[#2196F3] text-slate-700 hover:text-white text-xs font-bold transition-all flex items-center space-x-1.5"
                            >
                                <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3.5c-.5-.5-2.5 0-4 1.5L13.5 8.5 5.3 6.7c-.9-.2-1.8.1-2.4.7l-.4.4c-.6.6-.5 1.6.2 2.1l4.9 3.5-3.3 3.3-2.6-.5c-.4-.1-.8.1-1.1.4l-.3.3c-.4.4-.3 1.1.2 1.4l3.8 2.5 2.5 3.8c.3.5 1 .6 1.4.2l.3-.3c.3-.3.5-.7.4-1.1l-.5-2.6 3.3-3.3 3.5 4.9c.5.7 1.5.8 2.1.2l.4-.4c.6-.6.9-1.5.7-2.4Z"/></svg>
                                <span>Visa & Flights</span>
                            </button>
                        </div>
                    </div>

                    <!-- Service Commitments -->
                    <div class="space-y-3 pt-4 border-t border-slate-200 text-xs text-slate-700">
                        <div class="flex items-center space-x-3">
                            <span class="w-5 h-5 rounded-full bg-[#2196F3] text-white flex items-center justify-center text-[10px] font-black">✓</span>
                            <span class="font-medium">Guaranteed response within 2 business hours</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-5 h-5 rounded-full bg-[#2196F3] text-white flex items-center justify-center text-[10px] font-black">✓</span>
                            <span class="font-medium">100% Free custom itinerary quote with zero obligation</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-5 h-5 rounded-full bg-[#2196F3] text-white flex items-center justify-center text-[10px] font-black">✓</span>
                            <span class="font-medium">Dedicated personal travel concierge assigned to you</span>
                        </div>
                    </div>
                </div>

                <!-- Right Form Area (7 cols) -->
                <div class="lg:col-span-7">
                    
                    <!-- Success Notification Banner -->
                    <div v-if="isSubmitted" class="p-6 rounded-2xl bg-emerald-50 text-emerald-950 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center">
                                <svg class="w-5 h-5 stroke-current" viewBox="0 0 24 24" stroke-width="3" fill="none"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            <div>
                                <h4 class="text-base font-black text-emerald-900">Inquiry Successfully Submitted!</h4>
                                <p class="text-xs text-emerald-700 font-medium">Reference ID: <span class="font-mono font-bold">WLD-INQ-{{ Math.floor(100000 + Math.random() * 900000) }}</span></p>
                            </div>
                        </div>
                        <p class="text-xs text-emerald-800 font-normal leading-relaxed">
                            Thank you for reaching out to Worldine Destinations! Our travel concierge team has received your message and will contact you via Phone/Email within 2 hours with customized details.
                        </p>
                        <button 
                            @click="isSubmitted = false" 
                            class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition-all"
                        >
                            Send Another Inquiry
                        </button>
                    </div>

                    <!-- Form Controls -->
                    <form v-else @submit.prevent="submitForm" class="space-y-5">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    v-model="form.name"
                                    type="text"
                                    required
                                    placeholder="e.g. John Doe"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-medium text-slate-900 transition-all"
                                />
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    Email Address <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    v-model="form.email"
                                    type="email"
                                    required
                                    placeholder="e.g. john@example.com"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-medium text-slate-900 transition-all"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Phone / WhatsApp -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    Phone / WhatsApp Number <span class="text-rose-500">*</span>
                                </label>
                                <input 
                                    v-model="form.phone"
                                    type="tel"
                                    required
                                    placeholder="e.g. +94 77 123 4567"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-medium text-slate-900 transition-all"
                                />
                            </div>

                            <!-- Inquiry Type -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    Inquiry Category
                                </label>
                                <select 
                                    v-model="form.inquiry_type"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-semibold text-slate-900 transition-all"
                                >
                                    <option value="Sri Lanka Inbound Tour">Sri Lanka Inbound Tour</option>
                                    <option value="Outbound Tour Package">Outbound Tour Package</option>
                                    <option value="Custom Tailor-Made Itinerary">Custom Tailor-Made Itinerary</option>
                                    <option value="Visa & Air Ticketing">Visa & Air Ticketing</option>
                                    <option value="Corporate / Group Travel">Corporate & Group Expeditions</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <!-- Destination of Interest -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    Destination
                                </label>
                                <input 
                                    v-model="form.destination"
                                    type="text"
                                    placeholder="e.g. Sri Lanka, Maldives"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-medium text-slate-900 transition-all"
                                />
                            </div>

                            <!-- Travel Dates / Month -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    Preferred Travel Dates
                                </label>
                                <input 
                                    v-model="form.travel_dates"
                                    type="text"
                                    placeholder="e.g. Oct 2026 / Flexible"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-medium text-slate-900 transition-all"
                                />
                            </div>

                            <!-- Number of Travelers -->
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                    No. of Guests
                                </label>
                                <select 
                                    v-model="form.travelers"
                                    class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-semibold text-slate-900 transition-all"
                                >
                                    <option value="1 Solo Traveler">1 Solo Traveler</option>
                                    <option value="2 Guests (Couple/Friends)">2 Guests (Couple/Friends)</option>
                                    <option value="3-5 Small Family/Group">3-5 Small Family/Group</option>
                                    <option value="6-12 Large Group">6-12 Large Group</option>
                                    <option value="15+ Corporate / Group Tour">15+ Corporate / Group Tour</option>
                                </select>
                            </div>
                        </div>

                        <!-- Message Textarea -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">
                                Message & Special Requests
                            </label>
                            <textarea 
                                v-model="form.message"
                                rows="4"
                                placeholder="Please describe your trip preferences, preferred hotel standard (3-Star, 4-Star, 5-Star Luxury), meal plans, places to visit, or any special requirements..."
                                class="w-full px-4 py-3 rounded-xl bg-white border-0 outline-none ring-1 ring-slate-300 focus:ring-2 focus:ring-[#2196F3] text-xs font-medium text-slate-900 transition-all leading-relaxed"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button 
                                type="submit"
                                :disabled="submitting"
                                class="w-full py-4 rounded-xl bg-[#2B70B4] hover:bg-[#1E5288] disabled:bg-slate-400 text-white font-extrabold text-xs uppercase tracking-widest transition-all flex items-center justify-center space-x-2"
                            >
                                <span v-if="submitting" class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                <span>{{ submitting ? 'Submitting Inquiry...' : 'Submit Inquiry & Request Quote →' }}</span>
                            </button>
                        </div>

                        <p class="text-[11px] text-slate-500 text-center font-medium pt-1 flex items-center justify-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <span>Your personal information is strictly confidential and protected by Worldine Destinations privacy guidelines.</span>
                        </p>
                    </form>

                </div>

            </div>
        </section>

        <!-- 4. FREQUENTLY ASKED QUESTIONS -->
        <section class="py-16 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 bg-white">
            <div class="w-full max-w-4xl mx-auto space-y-8">
                <div class="text-center space-y-2">
                    <span class="text-xs font-black uppercase tracking-widest text-[#2196F3]">HAVE QUESTIONS?</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900">Frequently Asked Questions</h2>
                    <p class="text-slate-600 text-xs sm:text-sm font-medium max-w-xl mx-auto">
                        Quick answers regarding tour consultations, custom itineraries, visa processing, and booking guarantees.
                    </p>
                </div>

                <div class="divide-y divide-slate-200 w-full border-t border-b border-slate-200">
                    <div 
                        v-for="(faq, index) in faqs" 
                        :key="index"
                        class="py-5"
                    >
                        <button 
                            @click="toggleFaq(index)"
                            class="w-full text-left flex items-center justify-between font-bold text-sm sm:text-base text-slate-900 hover:text-[#2B70B4] transition-colors focus:outline-none"
                        >
                            <span class="pr-4">{{ faq.question }}</span>
                            <span class="text-lg font-black text-slate-400 flex-shrink-0">
                                {{ activeFaq === index ? '−' : '+' }}
                            </span>
                        </button>
                        <div 
                            v-if="activeFaq === index" 
                            class="mt-3 text-xs sm:text-sm text-slate-600 font-normal leading-relaxed pr-6"
                        >
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. LOCATION & GOOGLE MAP CONTAINER (DYNAMIC MAP IFRAME URL) -->
        <section id="location-map" class="py-16 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 bg-slate-50">
            <div class="w-full space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-black uppercase tracking-widest text-[#2196F3]">LOCATE OUR HEADQUARTERS</span>
                        
                        <p class="text-xs sm:text-sm text-slate-600 font-medium">{{ settings?.office_address || 'Worldine Destinations (Pvt) Ltd • Galle Road, Colombo 03, Sri Lanka' }}</p>
                    </div>
                    <a 
                        href="https://maps.google.com/?q=Colombo+03+Sri+Lanka" 
                        target="_blank"
                        class="px-6 py-2.5 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs uppercase tracking-wider transition-colors inline-flex items-center space-x-2 self-start md:self-auto"
                    >
                        <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
                        <span>Directions on Google Maps</span>
                    </a>
                </div>

                <!-- Dynamic Map View -->
                <div class="w-full h-80 sm:h-96 rounded-2xl overflow-hidden bg-slate-200">
                    <iframe 
                        title="Worldine Destinations Location Map"
                        :src="settings?.google_maps_url || 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798485292415!2d79.848888!3d6.914722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2594000000001%3A0x0!2zNsKwNTQnNTMuMCJOIDc5wrA1MCc1Ni4wIkU!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk'"
                        class="w-full h-full border-0 filter brightness-95 contrast-105"
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </section>

        <!-- 6. TRUST & ACCREDITATION STRIP -->
        <section class="py-12 bg-slate-900 text-white w-full font-spinnaker">
            <div class="w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">20+</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">Years Industry Expertise</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">100%</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">SLTDA Licensed & Approved</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">24/7</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">Personal Travel Concierge</div>
                </div>
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-[#90CAF9]">50,000+</span>
                    <div class="text-xs font-bold uppercase tracking-wider text-slate-300">Happy Global Travelers</div>
                </div>
            </div>
        </section>

        <!-- 7. SITE FOOTER -->
        <footer id="footer" class="relative bg-slate-950 text-white text-xs w-full overflow-hidden font-spinnaker">
            <!-- Background Image with Very Low Opacity (10%) & Dark Blue Protection Gradient Overlay -->
            <div class="absolute inset-0 z-0">
                <img 
                    src="/images/Logo/worldineback.png" 
                    alt="Footer Background" 
                    class="w-full h-full object-cover object-center filter blur-[1px] opacity-10 scale-105"
                />
                <div class="absolute inset-0 bg-gradient-to-b from-[#0A2540]/95 via-[#0B2E59]/97 to-slate-950/99"></div>
            </div>

            <!-- DESKTOP FOOTER VIEW -->
            <div class="hidden md:block relative z-10 pt-8 sm:pt-10 pb-4 sm:pb-5 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 font-spinnaker">
                <div class="w-full grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    
                    <!-- Column 1: Logo & Branding -->
                    <div class="space-y-3">
                        <Link href="/" class="inline-block group">
                            <img 
                                src="/images/Logo/worldine.png" 
                                alt="Worldine Destinations Logo" 
                                class="h-16 sm:h-20 w-auto object-contain filter drop-shadow-md group-hover:scale-105 transition-transform" 
                            />
                        </Link>
                        <p class="text-slate-300 text-xs leading-relaxed font-normal">
                            Worldine Destinations (Pvt) Ltd. Over 20 years of experience in the travel trade with deep knowledge in Ticketing, Visas, Outbound & Inbound tours, and Travel Insurance.
                        </p>

                        <!-- Social Media Section -->
                        <div class="pt-1">
                            <h5 class="text-[11px] font-bold text-[#90CAF9] uppercase tracking-wider mb-2 font-spinnaker">Follow Us</h5>
                            <div class="flex items-center space-x-2.5">
                                <a href="https://www.facebook.com/worldinedestinations/" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-[#2196F3] text-white flex items-center justify-center transition-all border border-white/15" aria-label="Facebook">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <a href="https://www.instagram.com/worldinedestinations" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center transition-all border border-white/15" aria-label="Instagram">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Quick Links -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Quick Links
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li><Link href="/" class="hover:text-[#90CAF9] transition-colors">Home</Link></li>
                            <li><Link href="/srilanka" class="hover:text-[#90CAF9] transition-colors">Sri Lanka Inbound</Link></li>
                            <li><Link href="/destinations" class="hover:text-[#90CAF9] transition-colors">Global Destinations</Link></li>
                            <li><Link href="/contact" class="hover:text-[#90CAF9] transition-colors">Contact & Support</Link></li>
                        </ul>
                    </div>

                    <!-- Column 3: Inbound & Outbound Tours -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Tour Expeditions
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li><Link href="/srilanka" class="hover:text-[#90CAF9] transition-colors">Sri Lanka Heritage Tours</Link></li>
                            <li><Link href="/destinations?region=maldives-paradise" class="hover:text-[#90CAF9] transition-colors">Maldives Luxury Escapes</Link></li>
                            <li><Link href="/destinations?region=dubai-uae" class="hover:text-[#90CAF9] transition-colors">Dubai & UAE Safaris</Link></li>
                            <li><Link href="/destinations?region=switzerland-europe" class="hover:text-[#90CAF9] transition-colors">Europe Schengen Tours</Link></li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact & Hotlines -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Hotline & Office
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li>
                                <a :href="`tel:${settings?.primary_phone || '+94766834881'}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>{{ settings?.primary_phone || '+94 766 834 881' }}</span>
                                </a>
                            </li>
                            <li>
                                <a :href="`tel:${settings?.outbound_phone || '+94718834881'}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <span>{{ settings?.outbound_phone || '+94 718 834 881' }}</span>
                                </a>
                            </li>
                            <li>
                                <a :href="`mailto:${settings?.primary_email || 'info@worldinedestinations.com'}`" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <svg class="w-3.5 h-3.5 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    <span class="truncate">{{ settings?.primary_email || 'info@worldinedestinations.com' }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Copyright Bar -->
                <div class="mt-5 pt-2.5 border-t border-white/15 flex flex-row items-center justify-between gap-2 text-[11px] text-slate-400 font-spinnaker">
                    <div>
                        Copyright © 2026 Worldine Destinations (Pvt) Ltd. All Rights Reserved.
                    </div>
                </div>
            </div>

            <!-- MOBILE FOOTER VIEW -->
            <div class="block md:hidden relative z-10 pt-6 pb-4 w-full px-4 space-y-5 font-spinnaker">
                <div class="text-center space-y-2">
                    <img 
                        src="/images/Logo/worldine.png" 
                        alt="Worldine Destinations Logo" 
                        class="h-14 w-auto mx-auto object-contain" 
                    />
                    <p class="text-slate-300 text-[11px] font-normal leading-relaxed">
                        Worldine Destinations (Pvt) Ltd. Over 20 years of travel trade excellence.
                    </p>
                </div>
                <div class="text-center border-t border-white/15 pt-3 text-[11px] text-slate-400">
                    Copyright © 2026 Worldine Destinations (Pvt) Ltd.
                </div>
            </div>
        </footer>

    </div>
</template>
