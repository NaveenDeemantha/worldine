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
        image: 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=2400&q=85',
        tagline: 'DISCOVER PARADISE ISLAND',
        title: 'VISIT SRI LANKA',
        subtitle: 'Experience over 20 years of travel expertise. From ancient rock fortresses to golden palm-fringed beaches, embark on the journey of your lifetime.'
    },
    {
        id: 2,
        image: 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=2400&q=85',
        tagline: 'ANCIENT KINGDOMS & UNESCO HERITAGE',
        title: 'HERITAGE & CULTURAL TOURS',
        subtitle: 'Explore Sigiriya Rock Fortress, Polonnaruwa ancient ruins, Dambulla Cave Temples, and the Sacred Tooth Relic Temple in Kandy.'
    },
    {
        id: 3,
        image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=2400&q=85',
        tagline: 'TROPICAL COASTLINES & SURF BAYS',
        title: 'BEACH ADVENTURE TOURS',
        subtitle: 'Unwind along Negombo, Kalpitiya, Marawilla, Hikkaduwa, and Mirissa. Whale watching, coral snorkeling, and pristine ocean retreats.'
    },
    {
        id: 4,
        image: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=2400&q=85',
        tagline: 'UNTOUCHED BIODIVERSITY & WILD SAFARIS',
        title: 'SRI LANKA WILDLIFE EXPEDITIONS',
        subtitle: 'Track wild elephants in Minneriya, leopards in Yala National Park, and rare endemic birds in lush rainforest sanctuaries.'
    },
    {
        id: 5,
        image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=2400&q=85',
        tagline: 'STUDY IN CANADA, MALTA & DUBAI',
        title: 'WORLDINE EDUCATION & VISAS',
        subtitle: 'Empowering students with global higher education pathways, visa consulting, and admissions at Acadia University, GBS Malta, & GBS Dubai.'
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
    destCarouselTimer = setInterval(nextDestSlide, 3500);
    loadAirlineLogos();
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    if (typewriterTimeout) clearTimeout(typewriterTimeout);
    if (destCarouselTimer) clearInterval(destCarouselTimer);
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
    { id: 'all', label: 'All Featured Tours', count: 8 },
    { id: 'inbound', label: 'Sri Lanka Inbound Tours', count: 4 },
    { id: 'outbound', label: 'Global Outbound Tours', count: 4 }
];

// Authentic Worldine Destinations Packages Data
const glimpseDestinations = ref([
    {
        name: 'Sri Lanka',
        subtitle: 'Pearl of the Indian Ocean & UNESCO Heritage',
        packagesCount: '15+ Packages',
        image: 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
        badge: 'Inbound Specialist'
    },
    {
        name: 'Maldives',
        subtitle: 'Overwater Tropical Coral Lagoon',
        packagesCount: '8 Packages',
        image: 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
        badge: 'Outbound Escape'
    },
    {
        name: 'Canada & North America',
        subtitle: 'Acadia University & Higher Studies Pathways',
        packagesCount: '6 Programs',
        image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
        badge: 'Worldine Education'
    },
    {
        name: 'Malta & Europe',
        subtitle: 'GBS Malta Campus & Schengen Student Visas',
        packagesCount: '5 Programs',
        image: 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=800&q=80',
        badge: 'Study & Work'
    },
    {
        name: 'Dubai & UAE',
        subtitle: 'GBS Dubai & Business Degrees',
        packagesCount: '7 Packages',
        image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
        badge: 'Executive Studies'
    },
    {
        name: 'Japan & East Asia',
        subtitle: 'Kyoto Temples & Cultural Expeditions',
        packagesCount: '9 Packages',
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
        badge: 'Heritage & Culture'
    }
]);

// Destinations Infinite Looping Carousel Engine
const destCarouselIndex = ref(0);
let destCarouselTimer = null;
const isTransitioning = ref(true);

const loopedGlimpseDestinations = computed(() => {
    return [...glimpseDestinations.value, ...glimpseDestinations.value];
});

const nextDestSlide = () => {
    destCarouselIndex.value++;
    if (destCarouselIndex.value >= glimpseDestinations.value.length) {
        setTimeout(() => {
            isTransitioning.value = false;
            destCarouselIndex.value = 0;
            setTimeout(() => { isTransitioning.value = true; }, 50);
        }, 700);
    }
};

const prevDestSlide = () => {
    if (destCarouselIndex.value === 0) {
        isTransitioning.value = false;
        destCarouselIndex.value = glimpseDestinations.value.length;
        setTimeout(() => {
            isTransitioning.value = true;
            destCarouselIndex.value--;
        }, 50);
    } else {
        destCarouselIndex.value--;
    }
};

const destinations = ref([
    // INBOUND TOURS (SRI LANKA)
    {
        id: 1,
        title: 'Heritage & Cultural Tour Sri Lanka',
        location: 'Anuradhapura • Polonnaruwa • Sigiriya • Kandy',
        category: 'inbound',
        price: 850,
        originalPrice: 1050,
        rating: 4.98,
        reviewsCount: 240,
        duration: '5 Days / 4 Nights',
        badge: 'Inbound Tour',
        image: 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80',
        highlights: ['Sigiriya Lion Rock Citadel', 'Dambulla Golden Cave Temple', 'Sacred Tooth Relic Temple', 'Colombo City Sightseeing'],
        description: 'Explore the heart of Sri Lanka’s ancient kingdoms, sacred UNESCO World Heritage sites, and vibrant royal city of Kandy with expert local guides.'
    },
    {
        id: 2,
        title: 'Grand Sri Lanka Heritage Expedition',
        location: 'Negombo • Pinnawala • Sigiriya • Nuwara Eliya',
        category: 'inbound',
        price: 1280,
        originalPrice: 1500,
        rating: 4.96,
        reviewsCount: 310,
        duration: '8 Days / 7 Nights',
        badge: 'Inbound Tour',
        image: 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
        highlights: ['Pinnawala Elephant Sanctuary', 'Minneriya Elephant Gathering', 'Tea Plantation & Factory', 'Nuwara Eliya Little England'],
        description: 'An all-inclusive 8-day island journey spanning lush mist-covered tea hills, ancient ruins, elephant gatherings, and coastal Negombo.'
    },
    {
        id: 3,
        title: 'Sri Lanka Coastal Beach Adventure',
        location: 'Negombo • Kalpitiya • Hikkaduwa • Mirissa',
        category: 'inbound',
        price: 1150,
        originalPrice: 1350,
        rating: 4.92,
        reviewsCount: 185,
        duration: '8 Days / 7 Nights',
        badge: 'Inbound Tour',
        image: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
        highlights: ['Blue Whale Watching Mirissa', 'Kalpitiya Lagoon Kitesurfing', 'Hikkaduwa Coral Snorkeling', 'Beachfront Luxury Resort'],
        description: 'Experience Sri Lanka’s finest coastal waters—from dolphin & whale watching to coral reef diving, seafood banquets, and sunset beach lounges.'
    },
    {
        id: 4,
        title: 'Sri Lanka Wildlife & Nature Safari',
        location: 'Yala National Park • Minneriya • Sinharaja',
        category: 'inbound',
        price: 990,
        originalPrice: 1200,
        rating: 4.97,
        reviewsCount: 195,
        duration: '6 Days / 5 Nights',
        badge: 'Inbound Tour',
        image: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
        highlights: ['Yala Leopard Safari 4x4', 'Minneriya Elephant Gathering', 'Sinharaja Rainforest Trek', 'Eco Luxury Jungle Glamping'],
        description: 'Witness wild leopards, Asian elephants, sloth bears, and endemic tropical flora across Sri Lanka’s world-famous wildlife reserves.'
    },

    // OUTBOUND TOURS (GLOBAL)
    {
        id: 5,
        title: 'Maldives Luxury Overwater Escape',
        location: 'Malé Atoll • Maldives',
        category: 'outbound',
        price: 1850,
        originalPrice: 2200,
        rating: 4.99,
        reviewsCount: 215,
        duration: '5 Days / 4 Nights',
        badge: 'Outbound Tour',
        image: 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
        highlights: ['Overwater Villa Stay', 'Seaplane Airport Transfer', 'Undersea Dining Experience', 'Sunset Dolphin Cruise'],
        description: 'Submerge into crystal turquoise lagoons, private luxury water villas, and world-renowned undersea dining in the Maldives.'
    },
    {
        id: 6,
        title: 'Dubai Sky Towers & Desert Safari',
        location: 'Dubai • United Arab Emirates',
        category: 'outbound',
        price: 1280,
        originalPrice: 1550,
        rating: 4.94,
        reviewsCount: 178,
        duration: '5 Days / 4 Nights',
        badge: 'Outbound Tour',
        image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
        highlights: ['Burj Khalifa Observation Deck', '4x4 Dune Bashing & BBQ', 'Dubai Marina Dinner Cruise', 'Gold & Spice Souk Guided Tour'],
        description: 'Experience futuristic luxury skyscrapers, golden sand dunes, luxury marina cruises, and world-class shopping in Dubai.'
    },
    {
        id: 7,
        title: 'Europe Schengen Grand Expedition',
        location: 'Paris • Swiss Alps • Rome • Europe',
        category: 'outbound',
        price: 2450,
        originalPrice: 2890,
        rating: 4.98,
        reviewsCount: 162,
        duration: '10 Days / 9 Nights',
        badge: 'Outbound Tour',
        image: 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?auto=format&fit=crop&w=800&q=80',
        highlights: ['Eiffel Tower & Seine Cruise', 'Swiss Alps Cable Car Peak', 'Colosseum & Vatican Tour', 'Full Schengen Visa Support'],
        description: 'Journey across iconic European capitals, snow-capped Swiss mountains, and historical UNESCO landmarks with complete visa assistance.'
    },
    {
        id: 8,
        title: 'East Asia Cultural Discovery - Japan',
        location: 'Tokyo • Mount Fuji • Kyoto • Japan',
        category: 'outbound',
        price: 2100,
        originalPrice: 2500,
        rating: 4.97,
        reviewsCount: 145,
        duration: '7 Days / 6 Nights',
        badge: 'Outbound Tour',
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
        highlights: ['Shinkansen Bullet Train Experience', 'Mount Fuji Panoramic View', 'Kyoto Fushimi Inari Shrine', 'Tokyo Skytree & Shibuya'],
        description: 'Discover the perfect harmony of futuristic metropolis and ancient Zen temples with high-speed bullet trains across Japan.'
    }
]);

// Airline Partners Brand Data — logos auto-discovered via Wikipedia Commons search API
const airlinePartners = ref([
    { name: 'Emirates',          searchQuery: 'Emirates airline logo',          accent: '#D71921', img: null },
    { name: 'Qatar Airways',     searchQuery: 'Qatar Airways logo',             accent: '#5C0632', img: null },
    { name: 'Singapore Airlines',searchQuery: 'Singapore Airlines logo',        accent: '#00205B', img: null },
    { name: 'Etihad Airways',    searchQuery: 'Etihad Airways logo',            accent: '#BF9B30', img: null },
    { name: 'British Airways',   searchQuery: 'British Airways logo',           accent: '#2176AE', img: null },
    { name: 'Lufthansa',         searchQuery: 'Lufthansa logo',                 accent: '#05164D', img: null },
    { name: 'Air France',        searchQuery: 'Air France logo',                accent: '#002157', img: null },
    { name: 'Turkish Airlines',  searchQuery: 'Turkish Airlines logo',          accent: '#E81932', img: null },
    { name: 'American Airlines', searchQuery: 'American Airlines logo',         accent: '#0078D2', img: null },
    { name: 'Delta Air Lines',   searchQuery: 'Delta Air Lines logo',           accent: '#003366', img: null },
    { name: 'United Airlines',   searchQuery: 'United Airlines logo',           accent: '#002244', img: null },
    { name: 'Cathay Pacific',    searchQuery: 'Cathay Pacific logo',            accent: '#005155', img: null },
    { name: 'ANA',               searchQuery: 'All Nippon Airways logo',        accent: '#1B3A6B', img: null },
    { name: 'Japan Airlines',    searchQuery: 'Japan Airlines logo',            accent: '#CC0000', img: null },
    { name: 'Korean Air',        searchQuery: 'Korean Air logo',                accent: '#00256C', img: null },
    { name: 'Malaysia Airlines', searchQuery: 'Malaysia Airlines logo',         accent: '#CC0001', img: null },
    { name: 'Thai Airways',      searchQuery: 'Thai Airways logo',              accent: '#6B2D8B', img: null },
    { name: 'SriLankan Airlines',searchQuery: 'SriLankan Airlines logo',        accent: '#1D6FA4', img: null },
    { name: 'Air Arabia',        searchQuery: 'Air Arabia logo',                accent: '#CC0000', img: null },
    { name: 'flydubai',          searchQuery: 'flydubai logo',                  accent: '#FF6600', img: null },
]);

// Auto-discover airline logo via Wikipedia Commons search API, then fetch thumbnail URL
const loadAirlineLogos = async () => {
    await Promise.allSettled(
        airlinePartners.value.map(async (airline, index) => {
            try {
                // Step 1: Search for the SVG logo file by airline name
                const searchUrl = `https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch=${encodeURIComponent(airline.searchQuery + ' filetype:svg')}&srnamespace=6&srlimit=5&format=json&origin=*`;
                const searchRes = await fetch(searchUrl);
                const searchData = await searchRes.json();
                const results = searchData?.query?.search || [];

                // Pick first SVG result whose title contains 'logo' or 'Logo'
                const match = results.find(r => 
                    r.title.toLowerCase().includes('logo') && 
                    r.title.toLowerCase().endsWith('.svg')
                ) || results.find(r => r.title.toLowerCase().endsWith('.svg'));

                if (!match) return;

                // Step 2: Get the thumbnail URL for that file
                const fileTitle = match.title;
                const infoUrl = `https://commons.wikimedia.org/w/api.php?action=query&titles=${encodeURIComponent(fileTitle)}&prop=imageinfo&iiprop=url&iiurlwidth=240&format=json&origin=*`;
                const infoRes = await fetch(infoUrl);
                const infoData = await infoRes.json();
                const pages = infoData?.query?.pages;
                const page = pages ? Object.values(pages)[0] : null;
                const thumburl = page?.imageinfo?.[0]?.thumburl;

                if (thumburl) {
                    airlinePartners.value[index] = { ...airlinePartners.value[index], img: thumburl };
                }
            } catch (e) {
                // Silently fall back to brand pill
            }
        })
    );
};

const loopedAirlinePartners = computed(() => {
    return [...airlinePartners.value, ...airlinePartners.value, ...airlinePartners.value];
});

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
        name: 'Samantha & Richard Vance',
        location: 'London, UK',
        destination: 'Sri Lanka 8D7N Grand Heritage Tour',
        rating: 5,
        avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
        text: 'Worldine Destinations made our Sri Lanka trip unforgettable! From our private chauffeur guide to the Sigiriya luxury hotel, every detail was handled with top-tier professionalism.'
    },
    {
        name: 'Kasun & Dilini Wickramasinghe',
        location: 'Colombo, Sri Lanka',
        destination: 'Canada Student Visa (Acadia Univ)',
        rating: 5,
        avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
        text: 'Worldine Education guided me step-by-step through my Acadia University application and Canada student visa approval. Their 20+ years of travel trade expertise truly shines!'
    },
    {
        name: 'Hans & Greta Müller',
        location: 'Frankfurt, Germany',
        destination: 'Sri Lanka Wildlife & Safari Tour',
        rating: 5,
        avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
        text: 'Seeing wild leopards in Yala and hundreds of elephants in Minneriya was magical! Worldine Destinations is definitely the best tour operator in Sri Lanka.'
    }
];

// Why Choose Us Features
const features = [
    {
        icon: '🏆',
        title: '20+ Years Travel Trade Expertise',
        desc: 'Over two decades of excellence in IATA ticketing, visa consulting, inbound & outbound tours, and travel insurance.'
    },
    {
        icon: '🇱🇰',
        title: 'Official Sri Lanka Inbound Specialists',
        desc: 'Bespoke Sri Lanka tour packages—Heritage & Cultural, Beach Adventures, Wildlife Safaris, and Ramayana Trails.'
    },
    {
        icon: '🎓',
        title: 'Worldine Global Education Portal',
        desc: 'Direct university admissions and student visa processing for Canada (Acadia Univ), Malta (GBS Malta), & Dubai.'
    },
    {
        icon: '📞',
        title: '24/7 Dedicated Concierge Hotline',
        desc: 'Immediate customer assistance via our Sri Lanka hotlines (+94 766 834 881 | +94 718 834 881) and global support.'
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

        <!-- GLIMPSE OF DESTINATIONS SECTION (SIDE-BY-SIDE SLIDING CAROUSEL IN SAME ROW) -->
        <section id="glimpse-destinations" class="py-16 sm:py-24 bg-white border-b border-slate-200 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 overflow-hidden">
            <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Side: Text Content & Carousel Controls -->
                <div class="lg:col-span-5 space-y-5 text-left">
                    <span class="text-xs font-black uppercase tracking-[0.25em] text-[#2196F3] bg-[#E3F2FD] px-4 py-1.5 rounded-full border border-[#90CAF9]/40 inline-block">
                        DESTINATIONS
                    </span>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#0D47A1] tracking-tight leading-tight">
                        A glimpse of destinations
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm md:text-base leading-relaxed">
                        Explore handpicked world-class travel destinations, tropical beach escapes, and higher education portals. Our curated packages offer unforgettable memories with 20+ years of travel expertise.
                    </p>

                    <!-- Interactive Slider Controls & Counter -->
                    <div class="pt-4 flex items-center space-x-4">
                        <button 
                            @click="prevDestSlide" 
                            class="w-12 h-12 rounded-full bg-[#E3F2FD] hover:bg-[#2196F3] text-[#0D47A1] hover:text-white flex items-center justify-center font-black transition-all shadow-md border border-[#90CAF9]/40"
                            aria-label="Previous destination"
                        >
                            ←
                        </button>
                        <button 
                            @click="nextDestSlide" 
                            class="w-12 h-12 rounded-full bg-[#2196F3] hover:bg-[#0D47A1] text-white flex items-center justify-center font-black transition-all shadow-md"
                            aria-label="Next destination"
                        >
                            →
                        </button>
                        <span class="text-xs font-extrabold text-slate-400 font-mono tracking-widest pl-2">
                            0{{ destCarouselIndex + 1 }} / 0{{ glimpseDestinations.length }}
                        </span>
                    </div>
                </div>

                <!-- Right Side: Auto-Sliding Image Cards Carousel (Infinite Seamless Loop) -->
                <div class="lg:col-span-7 w-full overflow-hidden">
                    <div 
                        class="flex gap-6"
                        :class="{ 'transition-transform duration-700 ease-out': isTransitioning }"
                        :style="{ transform: 'translateX(-' + (destCarouselIndex * 85) + '%)' }"
                    >
                        <div 
                            v-for="(dest, i) in loopedGlimpseDestinations" 
                            :key="i"
                            class="min-w-[85%] sm:min-w-[48%] group relative rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 h-88 sm:h-96 cursor-pointer border border-slate-100 flex-shrink-0"
                            @click="searchCategory = 'all'"
                        >
                            <!-- Background Image -->
                            <img 
                                :src="dest.image" 
                                :alt="dest.name" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            />
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>

                            <!-- Top Left Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="bg-[#2196F3] text-white font-black text-[10px] uppercase tracking-wider px-3.5 py-1.5 rounded-full shadow-md">
                                    {{ dest.badge }}
                                </span>
                            </div>

                            <!-- Top Right Package Count Pill -->
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/95 backdrop-blur-md text-[#0D47A1] font-black text-xs px-3.5 py-1.5 rounded-full shadow-md border border-white">
                                    {{ dest.packagesCount }}
                                </span>
                            </div>

                            <!-- Bottom Content -->
                            <div class="absolute bottom-5 left-5 right-5 text-white">
                                <h3 class="text-2xl font-black tracking-tight group-hover:text-[#90CAF9] transition-colors">
                                    {{ dest.name }}
                                </h3>
                                <p class="text-xs text-slate-300 font-medium mt-1 leading-snug">
                                    {{ dest.subtitle }}
                                </p>
                                <div class="mt-3 flex items-center justify-between pt-3 border-t border-white/20">
                                    <span class="text-[11px] font-bold text-amber-400">⭐ 4.9+ Top Rated</span>
                                    <span class="text-xs font-extrabold uppercase text-[#90CAF9] group-hover:translate-x-1 transition-transform inline-flex items-center">
                                        Explore &rarr;
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BLUE VALUE PROPOSITION STRIP BANNER & WHY CHOOSE WORLDINE DESTINATIONS SECTION -->
        <section id="why-choose-us-section" class="w-full overflow-hidden">
            
            <!-- TOP OCEAN BLUE ICON BANNER STRIP WITH SUBTLE BACKGROUND ANIMATION & SVG PATTERN -->
            <div class="relative bg-gradient-to-r from-[#0D47A1] via-[#1e6cb8] to-[#1565C0] text-white py-12 sm:py-16 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 overflow-hidden">
                
                <!-- Low-Visibility Subtle SVG World Map Grid Pattern Overlay -->
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1.5px,transparent_1.5px)] [background-size:24px_24px] pointer-events-none"></div>

                <!-- Animated Subtle Floating Ambient Glow Orbs -->
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-amber-400/15 rounded-full blur-3xl animate-pulse pointer-events-none" style="animation-delay: 2s;"></div>

                <!-- Subtle Decorative World Compass Watermark -->
                <div class="absolute right-10 top-1/2 -translate-y-1/2 opacity-5 pointer-events-none hidden md:block">
                    <svg class="w-96 h-96 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 21a9 9 0 100-18 9 9 0 000 18zM12 3v3m0 12v3M3 12h3m12 0h3m-3.414-5.586l-2.121 2.121m-6.93 6.93l-2.121 2.121m0-11.172l2.121 2.121m6.93 6.93l2.121 2.121"></path>
                    </svg>
                </div>

                <!-- Floating Animated Airplane & Dotted Flight Trail -->
                <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
                    <svg class="w-full h-full text-white/20" fill="none" viewBox="0 0 1200 160" preserveAspectRatio="none">
                        <!-- Trajectory Dotted Curved Line -->
                        <path id="flightTrajectoryPath" d="M -50 120 Q 350 10, 800 90 T 1300 20" stroke="currentColor" stroke-width="2.5" stroke-dasharray="8,8" fill="none"></path>

                        <!-- Animated Passenger Airliner Jet Group (Pointing forward in exact direction of motion) -->
                        <g>
                            <g class="filter drop-shadow-[0_4px_12px_rgba(0,0,0,0.6)]">
                                <!-- Main Aircraft Fuselage & Wings -->
                                <path 
                                    d="M 22 0 L -2 -7 L -16 -20 L -22 -20 L -14 -4 L -24 -4 L -29 -10 L -34 -10 L -30 0 L -34 10 L -29 10 L -24 4 L -14 4 L -22 20 L -16 20 L -2 7 Z" 
                                    fill="#FFFFFF" 
                                    stroke="#E2E8F0"
                                    stroke-width="1.2"
                                    stroke-linejoin="round"
                                />
                                <!-- Jet Engine Glow Accents -->
                                <circle cx="-6" cy="-11" r="2" fill="#38BDF8" />
                                <circle cx="-6" cy="11" r="2" fill="#38BDF8" />
                            </g>
                            <animateMotion 
                                path="M -50 120 Q 350 10, 800 90 T 1300 20" 
                                dur="12s" 
                                repeatCount="indefinite" 
                                rotate="auto"
                            />
                        </g>
                    </svg>
                </div>

                <!-- Content Grid -->
                <div class="relative z-10 w-full grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 text-center items-center">
                    
                    <!-- Item 1: Globe -->
                    <div class="flex flex-col items-center space-y-3 group">
                        <div class="group-hover:scale-110 transition-transform p-2">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-white filter drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V7a2 2 0 00-2-2h-1.5A2.5 2.5 0 0113 2.5V2M12 21a9 9 0 100-18 9 9 0 000 18z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs sm:text-sm font-black uppercase tracking-wider max-w-[160px] leading-tight">
                            300+ Amazing Destinations
                        </h4>
                    </div>

                    <!-- Item 2: Hotels -->
                    <div class="flex flex-col items-center space-y-3 group">
                        <div class="group-hover:scale-110 transition-transform p-2">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-white filter drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0v10m-4-10h4m-4 0V5m8 6h-4m4 0v10m-4-10v10"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs sm:text-sm font-black uppercase tracking-wider max-w-[160px] leading-tight">
                            Comfortable Hotels
                        </h4>
                    </div>

                    <!-- Item 3: Fast Bookings -->
                    <div class="flex flex-col items-center space-y-3 group">
                        <div class="group-hover:scale-110 transition-transform p-2">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-white filter drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs sm:text-sm font-black uppercase tracking-wider max-w-[160px] leading-tight">
                            Super Fast Bookings
                        </h4>
                    </div>

                    <!-- Item 4: Tour Guides -->
                    <div class="flex flex-col items-center space-y-3 group">
                        <div class="group-hover:scale-110 transition-transform p-2">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 text-white filter drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xs sm:text-sm font-black uppercase tracking-wider max-w-[160px] leading-tight">
                            Friendly Tour Guides
                        </h4>
                    </div>
                </div>
            </div>

            <!-- BOTTOM WHY CHOOSE WORLDINE DESTINATIONS SECTION -->
            <div class="bg-slate-100/90 py-16 sm:py-24 border-b border-slate-200 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
                <div class="w-full text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-800 tracking-tight leading-snug">
                        Why Choose <span class="text-[#2196F3]">Worldine Destinations</span>
                    </h2>
                </div>

                <!-- 4 White Feature Cards Grid -->
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    
                    <!-- Card 1 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-sm font-black text-[#1e6cb8] uppercase tracking-wider mb-3 leading-snug min-h-[40px] flex items-center justify-center">
                            DEDICATED SINGLE POINT OF CONTACT
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Eliminate the complexity of coordinating with multiple airlines, hotels, and visa services. Worldine Destinations provides a single, professional consultant who manages your entire international itinerary ensuring a seamless, stress-free planning experience.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-sm font-black text-[#1e6cb8] uppercase tracking-wider mb-3 leading-snug min-h-[40px] flex items-center justify-center">
                            GUARANTEED VALUE FOR YOUR BUDGET
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Thanks to our extensive network of airline and hotel partners, we secure the most competitive rates for your holiday packages. Whether you are planning a cost-conscious getaway or an opulent luxury vacation, we maximize the value of your travel investment.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-sm font-black text-[#1e6cb8] uppercase tracking-wider mb-3 leading-snug min-h-[40px] flex items-center justify-center">
                            AROUND THE CLOCK TRAVEL SUPPORT
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            Travel should be about excitement, not anxiety. Our 24/7 dedicated support hotline ensures that expert assistance from our Sri Lanka-based team is always available, regardless of your time zone or the specific travel challenges you may encounter.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-sm font-black text-[#1e6cb8] uppercase tracking-wider mb-3 leading-snug min-h-[40px] flex items-center justify-center">
                            COMMITMENT TO SUSTAINABLE TOURISM
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">
                            At Worldine Destinations, we prioritize travel that creates a positive impact. Building on a long-standing dedication to responsible tourism, every international holiday we curate is thoughtfully designed to be mindful of both local communities and the environment.
                        </p>
                    </div>

                </div>
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
                    <span class="text-[#2196F3] text-xs font-black uppercase tracking-widest">WORLDINE DESTINATIONS</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-slate-900 mt-1">Inbound & Outbound Tour Packages</h2>
                </div>
                <p class="text-slate-600 text-xs sm:text-sm max-w-md mt-2 md:mt-0 font-medium leading-relaxed">
                    Discover authentic Sri Lanka Inbound expeditions and premier Global Outbound tour packages curated with 20+ years of travel expertise.
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

        <!-- WE ARE FEATURED IN / OUR AIRLINE PARTNERS CAROUSEL SECTION -->
        <section id="airline-partners-section" class="py-10 sm:py-16 bg-white border-t border-b border-slate-100 w-full overflow-hidden">
            <!-- Section Headers -->
            <div class="w-full text-center max-w-3xl mx-auto mb-8 sm:mb-12 px-4">
                <h2 class="text-xl sm:text-3xl lg:text-4xl font-black text-[#00A3E0] tracking-wider uppercase mb-1">
                    WE ARE FEATURED IN
                </h2>
                <h3 class="text-[10px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest">
                    OUR AIRLINE PARTNERS
                </h3>
                <div class="w-12 sm:w-16 h-0.5 sm:h-1 bg-[#00A3E0] mx-auto mt-2.5 rounded-full"></div>
            </div>

            <!-- Marquee Wrapper -->
            <div class="relative w-full overflow-hidden">
                <!-- Left/Right Fade Edges -->
                <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

                <!-- ROW 1: Left to Right (forward) -->
                <div class="marquee-row mb-6">
                    <div class="marquee-track marquee-forward">
                        <!-- Two identical copies for seamless looping -->
                        <template v-for="copy in 2" :key="'fwd-copy-' + copy">
                            <div 
                                v-for="(airline, idx) in airlinePartners" 
                                :key="'fwd-' + copy + '-' + idx"
                                class="marquee-item"
                            >
                                <img 
                                    v-if="airline.img"
                                    :src="airline.img" 
                                    :alt="airline.name"
                                    class="h-7 sm:h-10 lg:h-12 w-auto max-w-[100px] sm:max-w-[130px] object-contain"
                                />
                                <div 
                                    v-else
                                    :style="{ backgroundColor: airline.accent }"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg shadow-sm"
                                >
                                    <svg class="w-3 h-3 text-white/90 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                    </svg>
                                    <span class="text-white text-[10px] font-bold uppercase tracking-wide">{{ airline.name }}</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- ROW 2: Right to Left (reverse) with slight offset start -->
                <div class="marquee-row">
                    <div class="marquee-track marquee-reverse">
                        <template v-for="copy in 2" :key="'rev-copy-' + copy">
                            <div 
                                v-for="(airline, idx) in airlinePartners" 
                                :key="'rev-' + copy + '-' + idx"
                                class="marquee-item"
                            >
                                <img 
                                    v-if="airline.img"
                                    :src="airline.img" 
                                    :alt="airline.name"
                                    class="h-7 sm:h-10 lg:h-12 w-auto max-w-[100px] sm:max-w-[130px] object-contain"
                                />
                                <div 
                                    v-else
                                    :style="{ backgroundColor: airline.accent }"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg shadow-sm"
                                >
                                    <svg class="w-3 h-3 text-white/90 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/>
                                    </svg>
                                    <span class="text-white text-[10px] font-bold uppercase tracking-wide">{{ airline.name }}</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>




        <!-- WHY CHOOSE US / FEATURES GRID -->
        <section id="services" class="py-14 sm:py-20 bg-slate-100/60 border-t border-slate-200 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
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
        <footer id="footer" class="bg-slate-950 border-t border-slate-900 pt-12 pb-10 text-slate-400 text-xs w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full grid grid-cols-1 md:grid-cols-5 gap-8">
                <!-- Column 1: Brand -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center">
                        <img src="/images/Logo/worldine.png" alt="Worldine Destinations Logo" class="h-16 sm:h-24 md:h-28 w-auto object-contain filter drop-shadow-xl" />
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        Worldine Destinations (Pvt) Ltd. Over 20 years of experience in the travel trade with deep knowledge in Ticketing, Visas, Outbound & Inbound tours, and Travel Insurance.
                    </p>
                    <div class="flex space-x-3 text-base text-slate-300">
                        <a href="https://www.facebook.com/worldinedestinations/" target="_blank" class="hover:text-amber-400">🌐</a>
                        <a href="https://www.instagram.com/worldinedestinations" target="_blank" class="hover:text-amber-400">📸</a>
                        <a href="https://eservices.immigration.gov.lk/emb/eEmbarkation/#/home-page" target="_blank" class="hover:text-amber-400" title="Digital Arrival Portal">🛂</a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider">Navigation</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#hero" class="hover:text-amber-400 transition-colors">Home</a></li>
                        <li><a href="#about" class="hover:text-amber-400 transition-colors">About Us</a></li>
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Sri Lanka Tours</a></li>
                        <li><a href="#education" class="hover:text-amber-400 transition-colors">Worldine Education</a></li>
                        <li><a href="#quiz" class="hover:text-amber-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Column 3: Inbound Packages -->
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider">Sri Lanka Inbound</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Heritage & Cultural (5D4N)</a></li>
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Grand Heritage (8D7N)</a></li>
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Beach Adventure (8D7N)</a></li>
                        <li><a href="#destinations" class="hover:text-amber-400 transition-colors">Wildlife Safari (6D5N)</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact Hotlines -->
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider">Contact & Hotlines</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="tel:+94766834881" class="hover:text-amber-400 transition-colors">📞 +94 766 834 881</a></li>
                        <li><a href="tel:+94718834881" class="hover:text-amber-400 transition-colors">📞 +94 718 834 881</a></li>
                        <li><a href="tel:+94778692229" class="hover:text-amber-400 transition-colors">📞 +94 778 869 222</a></li>
                        <li><a href="mailto:info@worldinedestinations.com" class="hover:text-amber-400 transition-colors">✉️ info@worldinedestinations.com</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="w-full mt-10 pt-5 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500">
                <div>Copyright © 2026 Worldine Destinations (Pvt) Ltd | All Rights Reserved</div>
                <div class="mt-2 sm:mt-0 flex space-x-3">
                    <a href="https://eservices.immigration.gov.lk/emb/eEmbarkation/#/home-page" target="_blank" class="hover:text-amber-400 transition-colors">🛂 Digital Arrival Portal ↗</a>
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

/* =============================================
   AIRLINE MARQUEE — SMOOTH SEAMLESS LOOP
   Each row holds 2 copies of the list.
   -50% translation = exactly one copy = seamless.
   ============================================= */

.marquee-row {
    width: 100%;
    overflow: hidden;
}

.marquee-track {
    display: flex;
    align-items: center;
    gap: 24px;
    width: max-content;
    will-change: transform;
}

@media (min-width: 640px) {
    .marquee-track { gap: 48px; }
}

.marquee-item {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 90px;
    height: 52px;
    flex-shrink: 0;
    /* Snappy 120ms hover response */
    transition: transform 0.12s cubic-bezier(0.34, 1.56, 0.64, 1),
                filter 0.12s ease;
    cursor: pointer;
}

@media (min-width: 640px) {
    .marquee-item {
        min-width: 130px;
        height: 64px;
    }
}

.marquee-item:hover {
    transform: scale(1.18);
    filter: drop-shadow(0 6px 16px rgba(0,0,0,0.18));
}

/* Forward: scroll left — 14s for a faster, energetic feel */
@keyframes marqueeForward {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* Reverse: scroll right — 18s slightly slower for visual contrast */
@keyframes marqueeReverse {
    0%   { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}

.marquee-forward {
    animation: marqueeForward 35s linear infinite;
}

.marquee-reverse {
    animation: marqueeReverse 35s linear infinite;
}

.marquee-forward:hover,
.marquee-reverse:hover {
    animation-play-state: paused;
}
</style>
