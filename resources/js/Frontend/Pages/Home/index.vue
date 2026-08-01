<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../../Components/Navbar.vue';

// Props passed from Inertia controller (optional)
defineProps({
    canLogin: { type: Boolean, default: true },
    canRegister: { type: Boolean, default: true },
    auth: { type: Object, default: () => ({ user: null }) }
});

// Navigation & UI State
const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activePagesDropdown = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 40;
};

// Hero Multi-Image Carousel Slides Data
const heroSlides = ref([
    {
        id: 1,
        image: 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=2400&q=85',
        tagline: 'DISCOVER THE COLORFUL WORLD',
        title: 'NEW ADVENTURE',
        subtitle: 'Experience breathtaking alpine heights, untouched mountain wilderness, and bespoke expeditions designed for true explorers.'
    },
    {
        id: 2,
        image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=2400&q=85',
        tagline: 'TROPICAL LUXURY ESCAPES',
        title: 'PARADISE ISLANDS',
        subtitle: 'Submerge into crystal turquoise lagoons, awaken to tropical sea life beneath your bedroom floor, and unwind in secluded luxury.'
    },
    {
        id: 3,
        image: 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=2400&q=85',
        tagline: 'MEDITERRANEAN BLISS',
        title: 'SANTORINI SUNSETS',
        subtitle: 'Experience pure Mediterranean bliss with cliffside infinity pools, private yacht tours across volcanic islands, and world-renowned sunsets.'
    },
    {
        id: 4,
        image: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=2400&q=85',
        tagline: 'WILD SAFARI EXPEDITIONS',
        title: 'SERENGETI SAFARI',
        subtitle: 'Witness the Great Migration firsthand, camp under starlit African skies, and capture majestic lion prides and elephant herds in action.'
    },
    {
        id: 5,
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=2400&q=85',
        tagline: 'ANCIENT CULTURAL SANCTUARIES',
        title: 'KYOTO TEMPLES',
        subtitle: 'Immerse in Japan’s historic soul—walk amidst towering bamboo forests, centuries-old zen gardens, and tranquil mountainside shrines.'
    }
]);

const currentHeroSlide = ref(0);

// TYPEWRITER & ERASER ENGINE
const typedTitle = ref('');
const typedTagline = ref('');
const isTyping = ref(false);
let typewriterTimeout = null;

const typeText = async () => {
    isTyping.value = true;
    const currentSlide = heroSlides.value[currentHeroSlide.value];
    
    // Clear initial text
    typedTitle.value = '';
    typedTagline.value = '';

    // Step 1: Type Tagline letter by letter
    const taglineFull = currentSlide.tagline;
    for (let i = 0; i <= taglineFull.length; i++) {
        typedTagline.value = taglineFull.slice(0, i);
        await new Promise(resolve => { typewriterTimeout = setTimeout(resolve, 25); });
    }

    // Step 2: Type Title letter by letter
    const titleFull = currentSlide.title;
    for (let i = 0; i <= titleFull.length; i++) {
        typedTitle.value = titleFull.slice(0, i);
        await new Promise(resolve => { typewriterTimeout = setTimeout(resolve, 55); });
    }

    isTyping.value = false;

    // Step 3: Hold full text on screen
    await new Promise(resolve => { typewriterTimeout = setTimeout(resolve, 3200); });

    // Step 4: Erase Title letter by letter
    for (let i = titleFull.length; i >= 0; i--) {
        typedTitle.value = titleFull.slice(0, i);
        await new Promise(resolve => { typewriterTimeout = setTimeout(resolve, 25); });
    }

    // Step 5: Erase Tagline letter by letter
    for (let i = taglineFull.length; i >= 0; i--) {
        typedTagline.value = taglineFull.slice(0, i);
        await new Promise(resolve => { typewriterTimeout = setTimeout(resolve, 15); });
    }

    // Step 6: Advance to next slide & repeat
    currentHeroSlide.value = (currentHeroSlide.value + 1) % heroSlides.value.length;
    typeText();
};

const goToSlide = (index) => {
    if (typewriterTimeout) clearTimeout(typewriterTimeout);
    currentHeroSlide.value = index;
    typeText();
};

const nextHeroSlide = () => {
    if (typewriterTimeout) clearTimeout(typewriterTimeout);
    currentHeroSlide.value = (currentHeroSlide.value + 1) % heroSlides.value.length;
    typeText();
};

const prevHeroSlide = () => {
    if (typewriterTimeout) clearTimeout(typewriterTimeout);
    currentHeroSlide.value = (currentHeroSlide.value - 1 + heroSlides.value.length) % heroSlides.value.length;
    typeText();
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    typeText();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    if (typewriterTimeout) clearTimeout(typewriterTimeout);
});

// Category & Search State
const searchCategory = ref('all');
const searchBudget = ref(5000);

// Wishlist State
const wishlist = ref([2, 5]);
const toggleWishlist = (id) => {
    if (wishlist.value.includes(id)) {
        wishlist.value = wishlist.value.filter(item => item !== id);
    } else {
        wishlist.value.push(id);
    }
};

// Categories
const categories = [
    { id: 'all', label: '🌟 All Destinations', count: 124 },
    { id: 'tropical', label: '🏝️ Tropical & Islands', count: 38 },
    { id: 'alpine', label: '🏔️ Alpine & Mountains', count: 26 },
    { id: 'cultural', label: '🏛️ Cultural & Historical', count: 31 },
    { id: 'luxury', label: '✨ Luxury Escapes', count: 19 },
    { id: 'wildlife', label: '🦁 Safari & Nature', count: 15 }
];

// Sample Destinations Data
const destinations = ref([
    {
        id: 1,
        title: 'Santorini Sunset Luxury Escape',
        location: 'Cyclades, Greece',
        category: 'luxury',
        price: 2450,
        originalPrice: 2900,
        rating: 4.96,
        reviewsCount: 342,
        duration: '7 Days / 6 Nights',
        badge: 'Bestseller',
        image: 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?auto=format&fit=crop&w=800&q=80',
        highlights: ['Caldera View Villa', 'Private Catamaran Tour', 'Wine Tasting', 'Helicopter Transfer'],
        description: 'Experience pure Mediterranean bliss with cliffside infinity pools, private yacht tours across volcanic islands, and world-renowned sunsets.'
    },
    {
        id: 2,
        title: 'Bora Bora Overwater Bungalows',
        location: 'French Polynesia',
        category: 'tropical',
        price: 3800,
        originalPrice: 4400,
        rating: 4.99,
        reviewsCount: 218,
        duration: '8 Days / 7 Nights',
        badge: 'Exclusive Deal',
        image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
        highlights: ['Glass Floor Bungalow', 'Shark & Ray Safari', 'Spa Credit $300', 'Full Board Gourmet'],
        description: 'Submerge into crystal turquoise lagoons, awaken to tropical sea life beneath your bedroom floor, and unwind in secluded luxury.'
    },
    {
        id: 3,
        title: 'Kyoto Ancient Temples & Bamboo',
        location: 'Kyoto, Japan',
        category: 'cultural',
        price: 1890,
        originalPrice: 2200,
        rating: 4.91,
        reviewsCount: 412,
        duration: '6 Days / 5 Nights',
        badge: 'Trending',
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
        highlights: ['Ryokan & Onsen Stay', 'Tea Ceremony Masterclass', 'Bullet Train Pass', 'Private Geisha Dinner'],
        description: 'Immerse in Japan’s historic soul—walk amidst towering bamboo forests, centuries-old zen gardens, and tranquil mountainside shrines.'
    },
    {
        id: 4,
        title: 'Swiss Alps & Matterhorn Express',
        location: 'Zermatt, Switzerland',
        category: 'alpine',
        price: 2750,
        originalPrice: 3100,
        rating: 4.94,
        reviewsCount: 189,
        duration: '7 Days / 6 Nights',
        badge: 'Winter Special',
        image: 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=800&q=80',
        highlights: ['Glacier Express First Class', 'Alpine Chalet Suite', 'Ski Pass Included', 'Fondue Gourmet Night'],
        description: 'Marvel at snow-capped peaks, ride scenic panoramic mountain trains, and relax in thermal baths with unobstructed Matterhorn vistas.'
    },
    {
        id: 5,
        title: 'Serengeti Big Five Safari Expedition',
        location: 'Serengeti, Tanzania',
        category: 'wildlife',
        price: 3200,
        originalPrice: 3650,
        rating: 4.98,
        reviewsCount: 156,
        duration: '9 Days / 8 Nights',
        badge: 'Eco Adventure',
        image: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
        highlights: ['Hot Air Balloon Safari', 'Luxury Tented Camp', 'Expert Wildlife Tracker', 'Ngorongoro Crater Tour'],
        description: 'Witness the Great Migration firsthand, camp under starlit African skies, and capture majestic lion prides and elephant herds in action.'
    },
    {
        id: 6,
        title: 'Amalfi Coast Cliffside Villa',
        location: 'Positano, Italy',
        category: 'luxury',
        price: 2150,
        originalPrice: 2500,
        rating: 4.89,
        reviewsCount: 284,
        duration: '6 Days / 5 Nights',
        badge: 'Popular Choice',
        image: 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=800&q=80',
        highlights: ['Private Convertible Car', 'Capri Island Speedboat', 'Cooking Class with Local Chef', 'Limoncello Tasting'],
        description: 'Cruise winding coastline roads overlooking pastel-hued villages, feast on fresh seafood pasta, and swim in emerald sea coves.'
    },
    {
        id: 7,
        title: 'Maldives Overwater Private Sanctuary',
        location: 'Malé Atoll, Maldives',
        category: 'tropical',
        price: 3450,
        originalPrice: 3950,
        rating: 4.97,
        reviewsCount: 310,
        duration: '7 Days / 6 Nights',
        badge: 'Island Sanctuary',
        image: 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
        highlights: ['Seaplane Transfer', 'Undersea Dining', 'Private Infinity Pool', 'Coral Reef Snorkeling'],
        description: 'Escape to ultra-private coral islands surrounded by vivid turquoise waters, coral reefs, and world-class luxury pampering.'
    },
    {
        id: 8,
        title: 'Patagonia Fjords & Glacier Expedition',
        location: 'Torres del Paine, Chile',
        category: 'alpine',
        price: 2950,
        originalPrice: 3300,
        rating: 4.93,
        reviewsCount: 167,
        duration: '8 Days / 7 Nights',
        badge: 'Wild Wilderness',
        image: 'https://images.unsplash.com/photo-1527004013197-933c4bb611b3?auto=format&fit=crop&w=800&q=80',
        highlights: ['Eco-Lodge Stay', 'Glacier Trekking', 'Puma Tracking Guide', 'Private Catamaran Cruise'],
        description: 'Trek towering granite peaks, navigate turquoise glacial lakes, and discover South America’s most dramatic untouched wilderness.'
    }
]);

// Computed Filtered Destinations
const filteredDestinations = computed(() => {
    return destinations.value.filter(dest => {
        const matchesCategory = searchCategory.value === 'all' || dest.category === searchCategory.value;
        const matchesBudget = dest.price <= searchBudget.value;
        return matchesCategory && matchesBudget;
    });
});

// Modal State
const activeModalDestination = ref(null);
const isBookingModalOpen = ref(false);

const openQuickView = (dest) => {
    activeModalDestination.value = dest;
    isBookingModalOpen.value = true;
};

const closeModal = () => {
    isBookingModalOpen.value = false;
    activeModalDestination.value = null;
};

// Interactive Vibe Quiz Engine
const quizStep = ref(1);
const quizAnswers = ref({ climate: '', activity: '', budget: '' });
const quizResult = ref(null);

const setQuizAnswer = (key, val) => {
    quizAnswers.value[key] = val;
};

const resetQuiz = () => {
    quizStep.value = 1;
    quizAnswers.value = { climate: '', activity: '', budget: '' };
    quizResult.value = null;
};

const calculateQuizResult = () => {
    quizStep.value = 4;
    if (quizAnswers.value.climate === 'tropical') {
        quizResult.value = destinations.value[1]; // Bora Bora
    } else if (quizAnswers.value.climate === 'alpine') {
        quizResult.value = destinations.value[3]; // Swiss Alps
    } else if (quizAnswers.value.activity === 'cultural') {
        quizResult.value = destinations.value[2]; // Kyoto
    } else if (quizAnswers.value.activity === 'wildlife') {
        quizResult.value = destinations.value[4]; // Serengeti
    } else {
        quizResult.value = destinations.value[0]; // Santorini
    }
};

// Interactive Cost Estimator
const calcDays = ref(7);
const calcTravelers = ref(2);
const calcTier = ref('luxury');
const calcIncludeGuide = ref(true);

const estimatedCost = computed(() => {
    const baseDailyRate = calcTier.value === 'ultra' ? 450 : calcTier.value === 'luxury' ? 280 : 160;
    const guideFee = calcIncludeGuide.value ? 65 : 0;
    return (baseDailyRate + guideFee) * calcDays.value * calcTravelers.value;
});

// Newsletter Form
const emailInput = ref('');
const newsletterSuccess = ref(false);
const handleSubscribe = () => {
    if (emailInput.value.trim()) {
        newsletterSuccess.value = true;
        emailInput.value = '';
        setTimeout(() => { newsletterSuccess.value = false; }, 4000);
    }
};

// Testimonials Data
const testimonials = [
    {
        name: 'Elena Rostova & Mark',
        location: 'New York, USA',
        destination: 'Bora Bora Overwater Escape',
        rating: 5,
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
        text: 'Adventure handled every single detail flawlessly! From our helicopter transfer to the private champagne dinner on the reef, it was truly a once-in-a-lifetime honeymoon.'
    },
    {
        name: 'David Chen',
        location: 'Singapore',
        destination: 'Swiss Alps & Matterhorn Express',
        rating: 5,
        avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
        text: 'The glacier train ride was breathtaking. Booking through Adventure saved us over $600 compared to other agencies, and their 24/7 concierge was incredibly responsive.'
    },
    {
        name: 'Sophia & Liam Williams',
        location: 'London, UK',
        destination: 'Kyoto Heritage Tour',
        rating: 5,
        avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
        text: 'Unbelievable authenticity! Staying at a traditional Ryokan with private hot springs was the highlight of our trip to Japan. We are already planning our next journey.'
    }
];

// Why Choose Us Features
const features = [
    {
        icon: '🛡️',
        title: '100% Guaranteed Price & Quality',
        desc: 'Direct partnerships with premium resorts and luxury fleets ensure unbeatable rates with zero hidden fees.'
    },
    {
        icon: '💎',
        title: 'Handpicked VIP Experiences',
        desc: 'Every itinerary is inspected and curated by our global team of travel experts for ultimate comfort.'
    },
    {
        icon: '🧭',
        title: 'Personalized Travel Concierge',
        desc: 'Enjoy dedicated round-the-clock support from your personal travel assistant wherever you roam.'
    },
    {
        icon: '🌱',
        title: 'Sustainable & Eco-Conscious',
        desc: 'We plant 10 trees for every booking and support local indigenous conservation initiatives globally.'
    }
];
</script>

<template>
    <Head title="Worldine - Travel & Tourism Company" />

    <div class="min-h-screen font-sans bg-slate-50 text-slate-800 selection:bg-amber-500 selection:text-slate-950 w-full overflow-x-hidden">
        
        <!-- HERO SECTION WITH TYPEWRITER & ERASER EFFECT -->
        <section id="hero" class="relative min-h-[85vh] sm:min-h-screen flex flex-col justify-between bg-slate-950 text-white overflow-hidden w-full">
            
            <!-- BACKGROUND IMAGE SLIDES (SMOOTH CROSSFADE) -->
            <div class="absolute inset-0 z-0 overflow-hidden">
                <div 
                    v-for="(slide, index) in heroSlides" 
                    :key="slide.id"
                    :class="[
                        'absolute inset-0 transition-opacity duration-1000 ease-in-out transform',
                        currentHeroSlide === index 
                            ? 'opacity-100 scale-100 z-10' 
                            : 'opacity-0 scale-105 z-0 pointer-events-none'
                    ]"
                >
                    <img 
                        :src="slide.image" 
                        :alt="slide.title" 
                        class="w-full h-full object-cover object-center scale-105"
                    />
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-900/80"></div>
                </div>
            </div>

            <!-- REUSABLE NAVBAR COMPONENT -->
            <Navbar :transparent="true" />



            <!-- HERO LEFT-ALIGNED CONTENT WITH LIVE TYPEWRITER & ERASER EFFECT -->
            <div class="relative z-20 my-auto py-12 sm:py-16 md:py-24 px-6 sm:px-12 lg:px-20 text-left w-full max-w-3xl lg:max-w-4xl min-h-[320px] flex flex-col justify-center items-start">
                
                <!-- Typed Tagline -->
                <p class="text-xs sm:text-sm font-extrabold uppercase tracking-[0.25em] text-[#90CAF9] mb-2 min-h-[20px]">
                    <span>{{ typedTagline }}</span>
                </p>

                <!-- Typed H1 Title with Blinking Cursor -->
                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black tracking-tight text-white uppercase leading-tight drop-shadow-xl min-h-[60px] sm:min-h-[90px] flex items-center justify-start">
                    <span>{{ typedTitle }}</span>
                    <span class="inline-block w-1 sm:w-1.5 h-7 sm:h-12 bg-[#90CAF9] ml-1.5 animate-pulse rounded-full"></span>
                </h1>

                <!-- Subtitle Paragraph with Accent Left Line -->
                <p class="mt-4 text-xs sm:text-sm md:text-base text-white/90 max-w-xl font-normal leading-relaxed border-l-2 border-[#90CAF9] pl-4 py-1">
                    {{ heroSlides[currentHeroSlide].subtitle }}
                </p>

                <!-- CTA Buttons Group -->
                <div class="pt-6 flex flex-wrap items-center gap-3.5">
                    <a 
                        href="#destinations" 
                        class="px-7 py-3 sm:px-8 sm:py-3.5 rounded-full bg-[#2196F3] text-white font-extrabold text-xs uppercase tracking-widest shadow-xl hover:bg-[#90CAF9] hover:text-[#0D47A1] transition-all duration-300 transform hover:scale-105"
                    >
                        DISCOVER NOW
                    </a>
                    <a 
                        href="#estimator" 
                        class="px-7 py-3 sm:px-8 sm:py-3.5 rounded-full bg-white/10 backdrop-blur-md border border-[#90CAF9]/40 text-white font-extrabold text-xs uppercase tracking-widest shadow-lg hover:bg-white/20 transition-all duration-300"
                    >
                        EXPLORE PACKAGES
                    </a>
                </div>
            </div>

            <!-- CAROUSEL BOTTOM-RIGHT CORNER SLIDE INDICATORS -->
            <div class="absolute bottom-6 sm:bottom-8 right-6 sm:right-10 lg:right-16 z-30 flex items-center space-x-2.5 bg-[#0D47A1]/80 backdrop-blur-md px-4 py-2.5 rounded-full border border-[#90CAF9]/30 shadow-2xl">
                <button 
                    v-for="(slide, i) in heroSlides" 
                    :key="'dot-' + slide.id"
                    @click="goToSlide(i)"
                    :class="[
                        'h-2.5 rounded-full transition-all duration-500 ease-out',
                        currentHeroSlide === i ? 'w-8 bg-[#90CAF9] shadow-md' : 'w-2.5 bg-white/40 hover:bg-white/80'
                    ]"
                    :aria-label="'Go to slide ' + (i + 1)"
                ></button>
            </div>
        </section>

        <!-- ABOUT SECTION -->
        <section id="about" class="py-14 sm:py-20 bg-white border-b border-slate-200 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center w-full">
                    <div class="lg:col-span-6 space-y-4">
                        <span class="text-amber-600 text-xs font-black uppercase tracking-widest">ABOUT OUR COMPANY</span>
                        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-snug">
                            We Create Unforgettable Travel Memories
                        </h2>
                        <p class="text-slate-600 text-xs sm:text-sm md:text-base leading-relaxed">
                            Adventure Travel is dedicated to providing high-end luxury expeditions, custom tours, and secret island escapes across 150+ worldwide destinations. Our expert travel concierges take care of every detail so you can focus on exploring.
                        </p>
                        <div class="flex items-center space-x-8 pt-3">
                            <div>
                                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900">15+</div>
                                <div class="text-[11px] sm:text-xs text-slate-500 font-semibold uppercase">Years Experience</div>
                            </div>
                            <div class="h-10 w-px bg-slate-200"></div>
                            <div>
                                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-teal-600">45k+</div>
                                <div class="text-[11px] sm:text-xs text-slate-500 font-semibold uppercase">Happy Explorers</div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-6 relative rounded-2xl overflow-hidden shadow-xl border border-slate-200 w-full">
                        <img 
                            src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1600&q=80" 
                            alt="Adventure About Us Image" 
                            class="w-full h-64 sm:h-80 md:h-96 lg:h-[450px] object-cover"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS BAR -->
        <section class="border-b border-slate-200 bg-slate-100/70 py-10 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-10 text-center">
                <div class="space-y-0.5">
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900">150+</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Global Destinations</div>
                </div>
                <div class="space-y-0.5">
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-teal-600">99.4%</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Satisfaction Rate</div>
                </div>
                <div class="space-y-0.5">
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900">45,000+</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Journeys Booked</div>
                </div>
                <div class="space-y-0.5">
                    <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-amber-600">24/7</div>
                    <div class="text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">VIP Support</div>
                </div>
            </div>
        </section>

        <!-- FEATURED DESTINATIONS SECTION -->
        <section id="destinations" class="py-14 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full flex flex-col md:flex-row md:items-end justify-between mb-8 sm:mb-10">
                <div>
                    <span class="text-teal-700 text-xs font-black uppercase tracking-widest">POPULAR DESTINATIONS</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Featured Travel Packages</h2>
                </div>
                <p class="text-slate-600 text-xs sm:text-sm max-w-md mt-2 md:mt-0 font-medium leading-relaxed">
                    Explore top-rated luxury packages tailored to provide authentic experiences and stress-free travel.
                </p>
            </div>

            <!-- Category Pills Filter -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-3 mb-8 no-scrollbar w-full">
                <button 
                    v-for="cat in categories" 
                    :key="cat.id"
                    @click="searchCategory = cat.id"
                    :class="[
                        'px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all border',
                        searchCategory === cat.id 
                            ? 'bg-slate-900 text-white border-slate-900 shadow-md' 
                            : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300 hover:bg-slate-50'
                    ]"
                >
                    {{ cat.label }} ({{ cat.count }})
                </button>
            </div>

            <!-- Destinations Cards Grid -->
            <div v-if="filteredDestinations.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-4 gap-6 lg:gap-8 w-full">
                <div 
                    v-for="dest in filteredDestinations" 
                    :key="dest.id"
                    class="group bg-white border border-slate-200/80 hover:border-teal-500/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col transform hover:-translate-y-1 w-full"
                >
                    <!-- Image Banner & Badges -->
                    <div class="relative h-48 sm:h-56 lg:h-60 overflow-hidden">
                        <img 
                            :src="dest.image" 
                            :alt="dest.title" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>
                        
                        <!-- Badge Top Left -->
                        <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-md text-slate-900 border border-slate-200 font-extrabold text-[11px] px-2.5 py-0.5 rounded-full shadow">
                            {{ dest.badge }}
                        </span>

                        <!-- Wishlist Toggle Top Right -->
                        <button 
                            @click.stop="toggleWishlist(dest.id)" 
                            class="absolute top-3 right-3 p-2 rounded-full bg-white/80 backdrop-blur-md text-slate-700 hover:text-amber-500 transition-colors shadow"
                        >
                            <svg 
                                class="w-4 h-4" 
                                :fill="wishlist.includes(dest.id) ? '#f59e0b' : 'none'" 
                                :stroke="wishlist.includes(dest.id) ? '#f59e0b' : 'currentColor'" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>

                        <!-- Rating & Location Bottom Image -->
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-[11px] text-white">
                            <span class="flex items-center space-x-1 font-bold">
                                📍 {{ dest.location }}
                            </span>
                            <span class="flex items-center space-x-1 bg-amber-400 text-slate-950 px-1.5 py-0.5 rounded font-black">
                                ⭐ {{ dest.rating }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <div class="text-[11px] font-bold text-teal-700 uppercase tracking-wider mb-1">
                                ⏱️ {{ dest.duration }}
                            </div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-teal-700 transition-colors line-clamp-1">
                                {{ dest.title }}
                            </h3>
                            <p class="text-slate-600 text-xs mt-1.5 line-clamp-2 leading-relaxed">
                                {{ dest.description }}
                            </p>
                        </div>

                        <!-- Highlights Tags -->
                        <div class="flex flex-wrap gap-1 pt-1">
                            <span v-for="(hl, idx) in dest.highlights.slice(0, 3)" :key="idx" class="text-[10px] bg-slate-100 text-slate-700 border border-slate-200/80 px-2 py-0.5 rounded font-semibold">
                                ✓ {{ hl }}
                            </span>
                        </div>

                        <!-- Price & Action Footer -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-500 font-medium block">Starting from</span>
                                <div class="flex items-baseline space-x-1">
                                    <span class="text-xl font-black text-teal-700">${{ dest.price.toLocaleString() }}</span>
                                    <span class="text-[10px] text-slate-400 line-through">${{ dest.originalPrice.toLocaleString() }}</span>
                                </div>
                            </div>

                            <button 
                                @click="openQuickView(dest)"
                                class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-800 font-bold text-xs transition-all duration-300"
                            >
                                Quick View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- INTERACTIVE TRIP FINDER QUIZ WIDGET -->
        <section id="quiz" class="py-14 sm:py-20 bg-gradient-to-b from-slate-100 via-sky-50/50 to-white border-t border-slate-200 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full text-center">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-teal-100 border border-teal-200 text-teal-900 text-xs font-bold uppercase tracking-wider mb-3">
                    <span>✨ AI Matchmaker</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900">Not Sure Where to Travel?</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-1.5 max-w-lg mx-auto font-medium">
                    Take our 30-second Travel Vibe Quiz and let our smart algorithm discover your ideal vacation match!
                </p>

                <!-- Quiz Box Container -->
                <div class="mt-8 bg-white border border-slate-200 rounded-2xl p-5 sm:p-8 shadow-lg text-left relative overflow-hidden w-full">
                    
                    <!-- Step 1: Climate Choice -->
                    <div v-if="quizStep === 1" class="space-y-4">
                        <div class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase">
                            <span>Step 1 of 3</span>
                            <span>Climate Vibe</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">What is your dream holiday environment?</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <button 
                                @click="setQuizAnswer('climate', 'tropical'); quizStep = 2"
                                class="p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-500 text-left hover:bg-teal-50/50 transition-all group"
                            >
                                <div class="text-3xl mb-1.5">🏝️</div>
                                <div class="font-bold text-slate-900 group-hover:text-teal-700 text-sm">Tropical Beach</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Sun, turquoise water & palm trees</div>
                            </button>
                            <button 
                                @click="setQuizAnswer('climate', 'alpine'); quizStep = 2"
                                class="p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-500 text-left hover:bg-teal-50/50 transition-all group"
                            >
                                <div class="text-3xl mb-1.5">🏔️</div>
                                <div class="font-bold text-slate-900 group-hover:text-teal-700 text-sm">Alpine Peak</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Crisp mountain air & chalets</div>
                            </button>
                            <button 
                                @click="setQuizAnswer('climate', 'urban'); quizStep = 2"
                                class="p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-500 text-left hover:bg-teal-50/50 transition-all group"
                            >
                                <div class="text-3xl mb-1.5">🏛️</div>
                                <div class="font-bold text-slate-900 group-hover:text-teal-700 text-sm">Historic City</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Culture, architecture & cuisine</div>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Activity Preference -->
                    <div v-else-if="quizStep === 2" class="space-y-4">
                        <div class="flex items-center justify-between text-xs text-slate-500 font-bold uppercase">
                            <span>Step 2 of 3</span>
                            <span>Pace & Activity</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">How do you prefer to spend your days?</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <button 
                                @click="setQuizAnswer('activity', 'relax'); quizStep = 3"
                                class="p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-500 text-left hover:bg-teal-50/50 transition-all group"
                            >
                                <div class="text-3xl mb-1.5">🧘‍♀️</div>
                                <div class="font-bold text-slate-900 group-hover:text-teal-700 text-sm">Pure Relaxation</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Spas, fine dining & lounging</div>
                            </button>
                            <button 
                                @click="setQuizAnswer('activity', 'wildlife'); quizStep = 3"
                                class="p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-500 text-left hover:bg-teal-50/50 transition-all group"
                            >
                                <div class="text-3xl mb-1.5">🦁</div>
                                <div class="font-bold text-slate-900 group-hover:text-teal-700 text-sm">Thrill & Safari</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Wildlife tracking & trekking</div>
                            </button>
                            <button 
                                @click="setQuizAnswer('activity', 'cultural'); quizStep = 3"
                                class="p-4 rounded-xl bg-slate-50 border border-slate-200 hover:border-teal-500 text-left hover:bg-teal-50/50 transition-all group"
                            >
                                <div class="text-3xl mb-1.5">⛩️</div>
                                <div class="font-bold text-slate-900 group-hover:text-teal-700 text-sm">Immersive Culture</div>
                                <div class="text-[11px] text-slate-500 mt-0.5">Museums, temples & street food</div>
                            </button>
                        </div>
                        <button @click="quizStep = 1" class="text-xs text-slate-500 hover:text-slate-900 underline">← Back to Step 1</button>
                    </div>

                    <!-- Step 3: Calculation trigger -->
                    <div v-else-if="quizStep === 3" class="space-y-4 text-center py-4">
                        <div class="text-3xl animate-bounce">🔮</div>
                        <h3 class="text-xl font-bold text-slate-900">Analyzing Your Travel Profile...</h3>
                        <p class="text-slate-600 text-xs">Matching climate and activity preferences with 150+ luxury packages.</p>
                        <button 
                            @click="calculateQuizResult()"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-bold text-xs shadow-md hover:scale-105 transition-all"
                        >
                            Reveal My Perfect Destination!
                        </button>
                    </div>

                    <!-- Step 4: Result Display -->
                    <div v-else-if="quizStep === 4 && quizResult" class="space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-widest">🎉 99.8% Match Found!</span>
                            <button @click="resetQuiz()" class="text-xs text-slate-500 hover:text-slate-900 underline">Take Quiz Again 🔄</button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-center">
                            <img :src="quizResult.image" :alt="quizResult.title" class="w-full h-48 object-cover rounded-xl shadow-sm" />
                            <div class="space-y-2">
                                <span class="text-[11px] font-bold text-teal-700 uppercase">{{ quizResult.location }}</span>
                                <h3 class="text-xl font-black text-slate-900">{{ quizResult.title }}</h3>
                                <p class="text-slate-600 text-xs leading-relaxed">{{ quizResult.description }}</p>
                                <div class="text-teal-700 font-black text-lg">${{ quizResult.price.toLocaleString() }} <span class="text-[11px] text-slate-500 font-normal">/ person</span></div>
                                <button @click="openQuickView(quizResult)" class="px-5 py-2.5 rounded-xl bg-teal-600 text-white font-bold text-xs hover:bg-teal-700 transition-colors shadow">
                                    Book Recommended Journey
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- INTERACTIVE TRIP BUDGET & COST CALCULATOR SECTION -->
        <section id="estimator" class="py-14 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center w-full">
                    <!-- Left Details -->
                    <div class="lg:col-span-6 space-y-4">
                        <span class="text-teal-700 text-xs font-black uppercase tracking-widest">Instant Estimate</span>
                        <h2 class="text-2xl sm:text-4xl font-black text-slate-900 leading-snug">
                            Customize & Estimate <br />
                            Your Vacation Budget
                        </h2>
                        <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-medium">
                            Use our transparent trip estimator to plan your budget with zero surprises. Adjust days, traveler count, luxury tier, and dedicated guide add-ons in real time.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            <div class="flex items-start space-x-3 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                <span class="text-2xl">⚡</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-xs sm:text-sm">Transparent Pricing</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">Includes taxes, resorts fees & flight credits.</div>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                <span class="text-2xl">🔒</span>
                                <div>
                                    <div class="font-bold text-slate-900 text-xs sm:text-sm">Flexible Cancellations</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">100% refund up to 14 days before trip.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Calculator Controls -->
                    <div class="lg:col-span-6 bg-white border border-slate-200 rounded-2xl p-5 sm:p-8 shadow-lg space-y-5 w-full">
                        <h3 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3">Trip Budget Calculator</h3>

                        <!-- Duration Slider -->
                        <div>
                            <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                                <span>Duration</span>
                                <span class="text-teal-700 font-black">{{ calcDays }} Days</span>
                            </div>
                            <input v-model.number="calcDays" type="range" min="3" max="21" class="w-full accent-teal-600 bg-slate-200 h-2 rounded-lg cursor-pointer" />
                        </div>

                        <!-- Travelers Counter -->
                        <div>
                            <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                                <span>Number of Travelers</span>
                                <span class="text-teal-700 font-black">{{ calcTravelers }} Guests</span>
                            </div>
                            <input v-model.number="calcTravelers" type="range" min="1" max="10" class="w-full accent-teal-600 bg-slate-200 h-2 rounded-lg cursor-pointer" />
                        </div>

                        <!-- Accommodation Tier -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Accommodation Level</label>
                            <div class="grid grid-cols-3 gap-2">
                                <button 
                                    @click="calcTier = 'standard'" 
                                    :class="['py-2.5 rounded-xl text-xs font-bold transition-all border', calcTier === 'standard' ? 'bg-teal-600 text-white border-teal-600 shadow' : 'bg-slate-50 text-slate-700 border-slate-200']"
                                >
                                    🏨 4★ Premium
                                </button>
                                <button 
                                    @click="calcTier = 'luxury'" 
                                    :class="['py-2.5 rounded-xl text-xs font-bold transition-all border', calcTier === 'luxury' ? 'bg-teal-600 text-white border-teal-600 shadow' : 'bg-slate-50 text-slate-700 border-slate-200']"
                                >
                                    ✨ 5★ Luxury
                                </button>
                                <button 
                                    @click="calcTier = 'ultra'" 
                                    :class="['py-2.5 rounded-xl text-xs font-bold transition-all border', calcTier === 'ultra' ? 'bg-teal-600 text-white border-teal-600 shadow' : 'bg-slate-50 text-slate-700 border-slate-200']"
                                >
                                    👑 VIP Villa
                                </button>
                            </div>
                        </div>

                        <!-- Addon Checkbox -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="text-xs font-semibold text-slate-700">Include Private Local Guide ($65/day)</span>
                            <input v-model="calcIncludeGuide" type="checkbox" class="w-4 h-4 accent-teal-600 rounded cursor-pointer" />
                        </div>

                        <!-- Result Box -->
                        <div class="bg-gradient-to-br from-slate-50 to-teal-50/40 border border-teal-200 p-4 sm:p-5 rounded-xl flex items-center justify-between">
                            <div>
                                <span class="text-[11px] text-slate-500 font-semibold block">Total Estimated Cost</span>
                                <span class="text-2xl sm:text-3xl font-black text-teal-700">${{ estimatedCost.toLocaleString() }}</span>
                            </div>
                            <a href="#destinations" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl transition-colors shadow">
                                Lock Rate Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WHY CHOOSE US / FEATURES GRID -->
        <section class="py-14 sm:py-20 bg-slate-100/60 border-t border-slate-200 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full">
                <div class="text-center max-w-xl mx-auto mb-12">
                    <span class="text-teal-700 text-xs font-black uppercase tracking-widest">Why Travel With Us</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">The Adventure Advantage</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                    <div 
                        v-for="(feat, i) in features" 
                        :key="i"
                        class="bg-white border border-slate-200/80 p-6 rounded-2xl hover:border-teal-400 transition-all duration-300 space-y-3 shadow-sm hover:-translate-y-1 w-full"
                    >
                        <div class="text-3xl">{{ feat.icon }}</div>
                        <h3 class="text-base font-bold text-slate-900">{{ feat.title }}</h3>
                        <p class="text-slate-600 text-xs leading-relaxed">{{ feat.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CUSTOMER REVIEWS & TESTIMONIALS SECTION -->
        <section id="testimonials" class="py-14 sm:py-20 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full">
                <div class="text-center max-w-xl mx-auto mb-12">
                    <span class="text-teal-700 text-xs font-black uppercase tracking-widest">REAL TRAVELER STORIES</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Loved By Over 45,000+ Explorers</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                    <div 
                        v-for="(t, idx) in testimonials" 
                        :key="idx"
                        class="bg-white border border-slate-200 p-6 rounded-2xl space-y-4 flex flex-col justify-between shadow-sm w-full"
                    >
                        <div class="space-y-3">
                            <div class="flex text-amber-400 space-x-1 text-sm">
                                <span v-for="star in t.rating" :key="star">★</span>
                            </div>
                            <p class="text-slate-700 text-xs sm:text-sm italic leading-relaxed">
                                "{{ t.text }}"
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center space-x-3">
                            <img :src="t.avatar" :alt="t.name" class="w-10 h-10 rounded-full object-cover border-2 border-teal-500" />
                            <div>
                                <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ t.name }}</div>
                                <div class="text-[11px] text-slate-500">{{ t.location }} • <span class="text-teal-700 font-semibold">{{ t.destination }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- NEWSLETTER SUBSCRIPTION CARD -->
        <section class="py-12 sm:py-16 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full relative rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-teal-900 p-6 sm:p-12 overflow-hidden shadow-xl text-white">
                <div class="relative z-10 max-w-3xl">
                    <span class="bg-amber-400 text-slate-950 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">VIP Traveler Club</span>
                    <h2 class="text-2xl sm:text-4xl font-black mt-2 leading-tight">
                        Receive $150 Voucher Off Your First Expedition
                    </h2>
                    <p class="mt-2 text-white/80 font-medium text-xs sm:text-sm">
                        Subscribe to secret flash sales, travel guides, and luxury itinerary drops twice a month. No spam, ever.
                    </p>

                    <form @submit.prevent="handleSubscribe" class="mt-6 flex flex-col sm:flex-row gap-2.5">
                        <input 
                            v-model="emailInput"
                            type="email" 
                            required 
                            placeholder="Enter your email address..."
                            class="flex-1 bg-white text-slate-900 placeholder-slate-400 px-4 py-3 rounded-xl border border-slate-200 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-400"
                        />
                        <button type="submit" class="px-6 py-3 bg-amber-400 hover:bg-amber-500 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md">
                            Claim My $150 Voucher
                        </button>
                    </form>

                    <div v-if="newsletterSuccess" class="mt-3 p-2.5 bg-white/20 text-white text-xs font-bold rounded-xl animate-fade-in">
                        🎉 Welcome! Check your inbox for your $150 voucher code.
                    </div>
                </div>

                <!-- Decorative Globe Pattern -->
                <div class="absolute -right-10 -bottom-10 opacity-15 text-8xl pointer-events-none hidden md:block">
                    🌍
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-slate-950 border-t border-slate-900 pt-12 pb-10 text-slate-400 text-xs w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Column 1: Brand -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center">
                        <img src="/images/Logo/worldine.png" alt="Worldine Logo" class="h-16 sm:h-24 md:h-28 w-auto object-contain filter drop-shadow-xl" />
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        Worldine Travel is a premier luxury tour operator delivering bespoke travel experiences, private mountain retreats, and cultural expeditions around the world.
                    </p>
                    <div class="flex space-x-3 text-base text-slate-300">
                        <a href="#" class="hover:text-amber-400">🌐</a>
                        <a href="#" class="hover:text-amber-400">📸</a>
                        <a href="#" class="hover:text-amber-400">✈️</a>
                        <a href="#" class="hover:text-amber-400">💬</a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider">Navigation</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#hero" class="hover:text-amber-400 transition-colors">Home</a></li>
                        <li><a href="#about" class="hover:text-amber-400 transition-colors">About Us</a></li>
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Services</a></li>
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Gallery</a></li>
                        <li><a href="#quiz" class="hover:text-amber-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Column 3: Travel Styles -->
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider">Travel Styles</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Luxury Island Escapes</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Alpine Chalet Tours</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Cultural Heritage Tours</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Honeymoon Specials</a></li>
                    </ul>
                </div>

                <!-- Column 4: Support -->
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider">Support</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Contact Concierge</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Cancellation Policy</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Travel Insurance</a></li>
                        <li><a href="#" class="hover:text-amber-400 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="w-full mt-10 pt-5 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500">
                <div>© 2026 Worldine Travel Inc. All Rights Reserved.</div>
                <div class="mt-2 sm:mt-0 flex space-x-3">
                    <span>💳 Visa</span>
                    <span>💳 Mastercard</span>
                    <span>💳 American Express</span>
                    <span>🔒 256-Bit SSL Encrypted</span>
                </div>
            </div>
        </footer>

        <!-- QUICK VIEW / BOOKING MODAL -->
        <div v-if="isBookingModalOpen && activeModalDestination" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white border border-slate-200 rounded-2xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-5 sm:p-7 space-y-5 shadow-2xl relative">
                <!-- Close Button -->
                <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900 p-1.5 text-lg font-bold">
                    ✕
                </button>

                <!-- Modal Content Header -->
                <div class="flex items-center space-x-3">
                    <span class="bg-slate-900 text-white font-extrabold text-[10px] px-2.5 py-0.5 rounded-full uppercase">
                        {{ activeModalDestination.badge }}
                    </span>
                    <span class="text-xs text-slate-500 font-bold">📍 {{ activeModalDestination.location }}</span>
                </div>

                <h3 class="text-xl sm:text-2xl font-black text-slate-900">
                    {{ activeModalDestination.title }}
                </h3>

                <!-- Modal Image -->
                <img :src="activeModalDestination.image" :alt="activeModalDestination.title" class="w-full h-52 object-cover rounded-xl shadow-sm" />

                <!-- Description & Highlights -->
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed">
                    {{ activeModalDestination.description }}
                </p>

                <div>
                    <h4 class="text-[11px] font-bold text-teal-700 uppercase tracking-wider mb-1.5">Package Inclusions:</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div v-for="(hl, i) in activeModalDestination.highlights" :key="i" class="text-xs bg-slate-50 p-2 rounded-lg border border-slate-200 text-slate-700 flex items-center space-x-1.5 font-medium">
                            <span>✨</span>
                            <span>{{ hl }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price & Modal Action -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-500">Total Price / Person</span>
                        <div class="text-xl font-black text-teal-700">${{ activeModalDestination.price.toLocaleString() }}</div>
                    </div>
                    <div class="flex space-x-2">
                        <button @click="closeModal" class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200">
                            Close
                        </button>
                        <button @click="alert('Booking request initiated for ' + activeModalDestination.title + '! Our concierge team will contact you shortly.'); closeModal()" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow">
                            Confirm Reservation
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
/* Custom scrollbar hiding for categories pill row */
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
