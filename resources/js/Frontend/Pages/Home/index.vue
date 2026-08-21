<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../../Components/Navbar.vue';

// Props passed from Inertia controller (optional)
const props = defineProps({
    canLogin: { type: Boolean, default: true },
    canRegister: { type: Boolean, default: true },
    auth: { type: Object, default: () => ({ user: null }) },
    dbGlimpseDestinations: { type: Array, default: () => [] },
    dbFeaturedPackages: { type: Array, default: () => [] }
});

// Navigation & UI State
const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activePagesDropdown = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 40;
};

// Hero Multi-Image Carousel Slides Data (Concise Outbound Tour Names)
const defaultHeroSlides = [
    {
        id: 1,
        image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=1400&q=75',
        tagline: 'SYDNEY & GREAT BARRIER REEF',
        title: 'AUSTRALIA TOUR',
        subtitle: 'Explore Sydney Opera House, Gold Coast beaches, and Barrier Reef coral diving.'
    },
    {
        id: 2,
        image: 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=1400&q=75',
        tagline: 'PARIS, SWISS ALPS & ROME',
        title: 'EUROPE SCHENGEN TOUR',
        subtitle: 'Discover Paris Eiffel cruises, snow-capped Swiss Alps, and hassle-free Schengen visas.'
    },
    {
        id: 3,
        image: 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1400&q=75',
        tagline: 'UBUD VILLAS & TROPICAL BEACHES',
        title: 'BALI ISLAND ESCAPE',
        subtitle: 'Unwind in luxury jungle pool villas, sunset ocean temples, and coral reefs.'
    },
    {
        id: 4,
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1400&q=75',
        tagline: 'TOKYO & MOUNT FUJI',
        title: 'JAPAN DISCOVERY TOUR',
        subtitle: 'Experience Tokyo city lights, Mount Fuji views, and Kyoto cherry blossom temples.'
    },
    {
        id: 5,
        image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1400&q=75',
        tagline: 'BURJ KHALIFA & DESERT SAFARI',
        title: 'DUBAI LUXURY HOLIDAY',
        subtitle: 'Witness Burj Khalifa skyscrapers, 4x4 dune bashing, and luxury marina cruises.'
    },
    {
        id: 6,
        image: 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=1400&q=75',
        tagline: 'OVERWATER VILLAS & CORAL REEFS',
        title: 'MALDIVES LUXURY ESCAPE',
        subtitle: 'Indulge in private water villa suites, seaplane lagoon flights, and sunset cruises.'
    }
];

const heroSlides = computed(() => {
    return defaultHeroSlides;
});

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

// About Section Destination Image Showcase Data
const defaultAboutDestinations = [
    {
        country: 'Worldine Expeditions',
        flag: '🌐',
        tagline: 'Over 20 Years of Premier Travel & Visa Expertise',
        image: '/images/Logo/worldineback.png'
    },
    {
        country: 'Sri Lanka',
        flag: '🇱🇰',
        tagline: 'Sigiriya Rock Citadel & UNESCO Ancient Kingdoms',
        image: 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1200&q=80'
    },
    {
        country: 'Australia',
        flag: '🇦🇺',
        tagline: 'Sydney Harbour Opera House & Great Barrier Reef',
        image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=1200&q=80'
    },
    {
        country: 'Japan',
        flag: '🇯🇵',
        tagline: 'Kyoto Zen Temples, Mount Fuji & Shinkansen Trains',
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=80'
    },
    {
        country: 'Thailand',
        flag: '🇹🇭',
        tagline: 'Bangkok Grand Palaces & Turquoise Beach Lagoons',
        image: 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=1200&q=80'
    },
    {
        country: 'Dubai',
        flag: '🇦🇪',
        tagline: 'Burj Khalifa, Desert Dunes & Marina Luxury Yacht Cruises',
        image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80'
    },
    {
        country: 'China',
        flag: '🇨🇳',
        tagline: 'Great Wall of China & Historical Forbidden City',
        image: 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=1200&q=80'
    }
];

const aboutDestinations = computed(() => {
    if (glimpseDestinations.value && glimpseDestinations.value.length > 0) {
        const dynamicDests = glimpseDestinations.value.map(dest => ({
            country: dest.name,
            tagline: dest.subtitle || dest.badge || 'Discover Extraordinary Journeys',
            image: dest.image || '/images/Logo/worldineback.png'
        }));
        return [
            {
                country: 'Worldine Expeditions',
                tagline: 'Over 20 Years of Premier Travel & Visa Expertise',
                image: '/images/Logo/worldineback.png'
            },
            ...dynamicDests
        ];
    }
    return defaultAboutDestinations;
});

const currentAboutSlide = ref(0);
let aboutSlideTimer = null;

const setAboutSlide = (idx) => {
    currentAboutSlide.value = idx;
};

const nextAboutSlide = () => {
    currentAboutSlide.value = (currentAboutSlide.value + 1) % aboutDestinations.value.length;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    typeText();
    destCarouselTimer = setInterval(nextDestSlide, 3500);
    aboutSlideTimer = setInterval(nextAboutSlide, 3500);
    loadAirlineLogos();

    if (window.location.hash === '#about') {
        setTimeout(() => {
            const aboutEl = document.getElementById('about');
            if (aboutEl) {
                aboutEl.scrollIntoView({ behavior: 'smooth' });
            }
        }, 300);
    }
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    if (typewriterTimeout) clearTimeout(typewriterTimeout);
    if (destCarouselTimer) clearInterval(destCarouselTimer);
    if (aboutSlideTimer) clearInterval(aboutSlideTimer);
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

// Dynamic Categories Computed from Backend Database Packages
const getDurationBadgeText = (dest) => {
    if (!dest) return '';
    const days = (dest.itinerary_days && dest.itinerary_days.length > 0) 
        ? dest.itinerary_days.length 
        : (dest.duration_days || 1);
    const nights = (dest.duration_nights !== null && dest.duration_nights !== undefined && dest.duration_nights > 0)
        ? dest.duration_nights
        : Math.max(0, days - 1);
    return nights > 0 ? `${days} Days / ${nights} Nights` : `${days} Day Tour`;
};

const categories = computed(() => {
    const list = props.dbFeaturedPackages || [];
    const inboundCount = list.filter(p => p.category === 'srilanka-inbound' || p.category === 'inbound' || (p.destination && p.destination.type === 'inbound')).length;
    const outboundCount = list.filter(p => p.category === 'global-outbound' || p.category === 'outbound' || (p.destination && p.destination.type === 'outbound') || p.category !== 'srilanka-inbound').length;
    
    return [
        { id: 'all', label: 'All Tour Packages', count: list.length },
        { id: 'inbound', label: 'Sri Lanka Inbound Tours', count: inboundCount },
        { id: 'outbound', label: 'Global Outbound Tours', count: outboundCount }
    ];
});

// Authentic Worldine Destinations Packages Data
const defaultGlimpseDestinations = [
    {
        name: 'Sri Lanka',
        subtitle: 'Pearl of the Indian Ocean & UNESCO Heritage',
        packagesCount: 'Inbound Specialist',
        image: 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1200&q=80',
        badge: 'Inbound Specialist'
    },
    {
        name: 'Maldives',
        subtitle: 'Overwater Tropical Coral Lagoon & Water Villas',
        packagesCount: 'Outbound Escape',
        image: 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
        badge: 'Outbound Escape'
    },
    {
        name: 'Switzerland & Europe',
        subtitle: 'Alpine Snow Peaks & Schengen Grand Expeditions',
        packagesCount: 'European Grand Tour',
        image: 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=800&q=80',
        badge: 'European Grand Tour'
    },
    {
        name: 'Japan & East Asia',
        subtitle: 'Kyoto Temples, Mount Fuji & Shinkansen Bullet Trains',
        packagesCount: 'East Asia Discovery',
        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
        badge: 'Heritage & Culture'
    },
    {
        name: 'Dubai & UAE',
        subtitle: 'Burj Khalifa, Desert Dunes & Marina Luxury Cruises',
        packagesCount: 'Luxury City Escape',
        image: 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
        badge: 'Luxury City Escape'
    },
    {
        name: 'Australia & Pacific',
        subtitle: 'Great Barrier Reef & Sydney Opera House',
        packagesCount: 'Pacific Ocean Escape',
        image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80',
        badge: 'Pacific Ocean Escape'
    }
];

const glimpseDestinations = computed(() => {
    if (props.dbGlimpseDestinations && props.dbGlimpseDestinations.length) {
        return props.dbGlimpseDestinations;
    }
    return defaultGlimpseDestinations;
});

// Destinations Infinite Looping Carousel Engine
const destCarouselIndex = ref(0);
let destCarouselTimer = null;
const isTransitioning = ref(true);

const windowWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1200);

const handleResize = () => {
    if (typeof window !== 'undefined') {
        windowWidth.value = window.innerWidth;
    }
};

const slideStepPercent = computed(() => {
    if (windowWidth.value < 640) {
        return 100; // Mobile: 1 card per slide (100% width)
    } else if (windowWidth.value < 1024) {
        return 50;  // Tablet: 2 cards per slide (50% width)
    } else {
        return 33.333333; // Desktop: 3 cards per slide (33.3333% width)
    }
});

const touchStartX = ref(0);
const touchEndX = ref(0);

const handleTouchStart = (e) => {
    if (e.changedTouches && e.changedTouches.length > 0) {
        touchStartX.value = e.changedTouches[0].screenX;
    }
};

const handleTouchEnd = (e) => {
    if (e.changedTouches && e.changedTouches.length > 0) {
        touchEndX.value = e.changedTouches[0].screenX;
        const diff = touchStartX.value - touchEndX.value;
        if (diff > 35) {
            nextDestSlide();
        } else if (diff < -35) {
            prevDestSlide();
        }
    }
};

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
    loadAirlineLogos();
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});

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
                const searchUrl = `https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch=${encodeURIComponent(airline.searchQuery + ' filetype:svg')}&srnamespace=6&srlimit=5&format=json&origin=*`;
                const searchRes = await fetch(searchUrl);
                const searchData = await searchRes.json();
                const results = searchData?.query?.search || [];

                const match = results.find(r => 
                    r.title.toLowerCase().includes('logo') && 
                    r.title.toLowerCase().endsWith('.svg')
                ) || results.find(r => r.title.toLowerCase().endsWith('.svg'));

                if (!match) return;

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

// Computed Filtered Destinations (100% Exact Actual Data from Backend)
const filteredDestinations = computed(() => {
    const list = (props.dbFeaturedPackages && Array.isArray(props.dbFeaturedPackages)) 
        ? props.dbFeaturedPackages 
        : [];

    return list.filter(dest => {
        if (!dest) return false;
        const destCat = dest.category || '';
        const destType = dest.destination ? dest.destination.type : '';

        const matchesCategory = searchCategory.value === 'all' 
            || destCat === searchCategory.value 
            || (searchCategory.value === 'inbound' && (destCat === 'srilanka-inbound' || destCat === 'inbound' || destType === 'inbound'))
            || (searchCategory.value === 'outbound' && (destCat === 'global-outbound' || destCat === 'outbound' || destType === 'outbound' || destCat !== 'srilanka-inbound'));
        
        return matchesCategory;
    });
});

const displayedFilteredDestinations = computed(() => {
    const list = filteredDestinations.value || [];
    if (windowWidth.value < 640) {
        return list.slice(0, 5);
    }
    return list;
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
        
        <!-- REUSABLE NAVBAR COMPONENT -->
        <Navbar />

        <!-- HERO SECTION WITH TYPEWRITER & ERASER EFFECT -->
        <section id="hero" class="relative min-h-[80vh] sm:min-h-[calc(100vh-76px)] flex flex-col justify-between bg-slate-950 text-white overflow-hidden w-full">
            
            <!-- STATIC HERO BACKGROUND IMAGE -->
            <div class="absolute inset-0 z-0 overflow-hidden">
                <!--
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
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-slate-950/35 to-slate-950/90"></div>
                </div>
                -->
                <img 
                    src="/images/Logo/worldineback.png" 
                    alt="Worldine Hero" 
                    class="w-full h-full object-cover object-top"
                    fetchpriority="high"
                    decoding="async"
                />
                <!-- Mobile-Only Soft Contrast Mask directly on Background Image for Legibility (Subtle bg-white/20) -->
                <div class="block sm:hidden absolute inset-0 bg-white/20 pointer-events-none z-10"></div>
                <!-- Ultra-Smooth Top Fade Gradient (No Hard Horizontal Seams/Cutoffs Under Navbar) -->
                <div class="absolute top-0 left-0 right-0 h-20 sm:h-28 bg-gradient-to-b from-white via-white/25 to-transparent pointer-events-none z-10"></div>
                <!-- Subtle Soft Protection Overlay Gradient for Text Contrast -->
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/15 via-transparent to-slate-950/30 pointer-events-none"></div>
            </div>

            <!-- HERO LEFT-ALIGNED CONTENT WITH LIVE TYPEWRITER & ERASER EFFECT -->
            <div class="relative z-20 my-auto py-12 sm:py-16 md:py-24 px-6 sm:px-12 lg:px-20 text-left w-full max-w-3xl lg:max-w-4xl min-h-[320px] flex flex-col justify-center items-start">
                
                <!-- Typed Tagline -->
                <p class="text-xs sm:text-sm font-black uppercase tracking-[0.25em] text-[#0D47A1] mb-2 min-h-[20px]">
                    <span class="font-black">{{ typedTagline }}</span>
                </p>

                <!-- Typed H1 Title with Blinking Cursor -->
                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-black tracking-tight text-slate-950 uppercase leading-tight drop-shadow-md min-h-[60px] sm:min-h-[90px] flex items-center justify-start font-sans">
                    <span class="font-black tracking-tight">{{ typedTitle }}</span>
                    <span class="inline-block w-1.5 sm:w-2 h-7 sm:h-12 bg-[#2B70B4] ml-2 animate-pulse rounded-full"></span>
                </h1>

                <!-- Subtitle Paragraph with Accent Left Line -->
                <p class="mt-4 text-xs sm:text-sm md:text-base text-slate-950 max-w-xl font-black leading-relaxed border-l-4 border-[#2B70B4] pl-4 py-1">
                    {{ heroSlides[currentHeroSlide].subtitle }}
                </p>

                <!-- CTA Buttons Group -->
                <div class="pt-6 flex flex-wrap items-center gap-3.5">
                    <a 
                        href="#destinations" 
                        class="px-7 py-3 sm:px-8 sm:py-3.5 rounded-full bg-[#2B70B4] text-white font-extrabold text-xs uppercase tracking-widest shadow-xl hover:bg-[#1E5288] transition-all duration-300 transform hover:scale-105"
                    >
                        DISCOVER NOW
                    </a>
                    <a 
                        href="#estimator" 
                        class="px-7 py-3 sm:px-8 sm:py-3.5 rounded-full bg-slate-900/10 backdrop-blur-md border border-[#2B70B4]/40 text-slate-900 font-extrabold text-xs uppercase tracking-widest shadow-lg hover:bg-slate-900/20 transition-all duration-300"
                    >
                        EXPLORE PACKAGES
                    </a>
                </div>
            </div>

        </section>

        <!-- GLIMPSE OF DESTINATIONS SECTION (3-CARD DESKTOP, 2-CARD TABLET, 1-CARD MOBILE CAROUSEL) -->
        <section id="glimpse-destinations" class="py-12 sm:py-20 lg:py-24 bg-white w-full px-5 sm:px-10 md:px-12 lg:px-14 xl:px-16 overflow-hidden">
            <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-8 items-center">
                
                <!-- Left Side: Text Content & Carousel Controls -->
                <div class="lg:col-span-4 space-y-4 sm:space-y-5 text-left">
                    <span class="text-xs font-black uppercase tracking-[0.25em] text-[#2196F3] bg-[#E3F2FD] px-4 py-1.5 rounded-full border border-[#90CAF9]/40 inline-block">
                        DESTINATIONS
                    </span>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-[#0D47A1] tracking-tight leading-tight">
                        A glimpse of destinations
                    </h2>
                    <p class="text-slate-600 text-xs sm:text-sm md:text-base leading-relaxed">
                        Explore handpicked world-class travel destinations, tropical beach escapes, and tailored international holiday packages. Our curated itineraries offer unforgettable memories with 20+ years of travel expertise.
                    </p>

                    <!-- Interactive Slider Controls & Counter -->
                    <div class="pt-2 sm:pt-4 flex items-center space-x-3 sm:space-x-4">
                        <button 
                            @click="prevDestSlide" 
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-[#E3F2FD] hover:bg-[#2196F3] text-[#0D47A1] hover:text-white flex items-center justify-center font-black transition-all shadow-md border border-[#90CAF9]/40 active:scale-95"
                            aria-label="Previous destination"
                        >
                            ←
                        </button>
                        <button 
                            @click="nextDestSlide" 
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-[#2196F3] hover:bg-[#0D47A1] text-white flex items-center justify-center font-black transition-all shadow-md active:scale-95"
                            aria-label="Next destination"
                        >
                            →
                        </button>
                        <span class="text-xs font-extrabold text-slate-400 font-mono tracking-widest pl-2">
                            0{{ (destCarouselIndex % glimpseDestinations.length) + 1 }} / 0{{ glimpseDestinations.length }}
                        </span>
                    </div>
                </div>

                <!-- Right Side: 3 Cards View (Desktop), 2 Cards (Tablet), 1 Card (Mobile) -->
                <div 
                    class="lg:col-span-8 w-full overflow-hidden pt-2 sm:pt-0"
                    @touchstart="handleTouchStart"
                    @touchend="handleTouchEnd"
                >
                    <div 
                        class="flex -mx-1 sm:-mx-2 lg:-mx-2.5"
                        :class="{ 'transition-transform duration-500 ease-out': isTransitioning }"
                        :style="{ transform: 'translateX(-' + (destCarouselIndex * slideStepPercent) + '%)' }"
                    >
                        <div 
                            v-for="(dest, i) in loopedGlimpseDestinations" 
                            :key="i"
                            class="w-full sm:w-1/2 lg:w-1/3 flex-shrink-0 px-1 sm:px-2 lg:px-2.5"
                        >
                            <div 
                                class="relative rounded-3xl overflow-hidden shadow-xl h-72 sm:h-88 lg:h-96 cursor-pointer border border-slate-200/50 group"
                                @click="searchCategory = 'all'"
                            >
                                <!-- Background Image -->
                                <img 
                                    :src="dest.image" 
                                    :alt="dest.name" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                />
                                <!-- Sleek Dark Gradient Protection Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/20 to-transparent"></div>

                                <!-- Top Right Glassmorphic Package Counter Pill -->
                                <div class="absolute top-4 right-4 sm:top-5 sm:right-5">
                                    <span class="bg-slate-950/50 backdrop-blur-md text-white font-extrabold text-[11px] px-3.5 py-1.5 rounded-full border border-white/20 shadow-sm">
                                        {{ dest.packagesCount }}
                                    </span>
                                </div>

                                <!-- Bottom Content: Clean Title, Subtitle & Static Glass Arrow -->
                                <div class="absolute bottom-5 sm:bottom-6 left-5 sm:left-6 right-5 sm:right-6 text-white space-y-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xl sm:text-2xl lg:text-xl xl:text-2xl font-black tracking-tight line-clamp-1">
                                            {{ dest.name }}
                                        </h3>
                                        <span class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/15 backdrop-blur-md flex items-center justify-center text-xs sm:text-sm font-bold text-white shadow-md border border-white/30 flex-shrink-0 ml-2">
                                            →
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-300 font-medium line-clamp-1 leading-relaxed">
                                        {{ dest.subtitle }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ABOUT SECTION WITH DYNAMIC BACKGROUND FADED SEAMLESSLY AT TOP & BOTTOM -->
        <section id="about" class="relative py-16 sm:py-24 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24 overflow-hidden bg-white">
            <!-- Full-Section Background Images with Seamless Top/Bottom Gradient Masking -->
            <div class="absolute inset-0 pointer-events-none z-0 [mask-image:linear-gradient(to_bottom,transparent_0%,black_12%,black_88%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_bottom,transparent_0%,black_12%,black_88%,transparent_100%)]">
                <img 
                    v-for="(dest, idx) in aboutDestinations" 
                    :key="'bg-img-' + idx" 
                    :src="dest.image"
                    :alt="dest.country"
                    :class="[
                        'absolute inset-0 w-full h-full object-cover transition-all duration-1000 transform filter blur-sm',
                        currentAboutSlide === idx ? 'opacity-80 scale-100' : 'opacity-0 scale-105'
                    ]"
                />

                <!-- Soft Ambient Light Gradient Overlay for Content Contrast -->
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/80 to-white/30"></div>
            </div>

            <div class="relative z-10 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center w-full">
                    <!-- Left Column: Clean Unboxed Text -->
                    <div class="lg:col-span-6 space-y-4">
                        <span class="text-amber-600 text-xs font-black uppercase tracking-widest">ABOUT OUR COMPANY</span>
                        <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-snug">
                            We Create Unforgettable Travel Memories
                        </h2>
                        <p class="text-slate-600 text-xs sm:text-sm md:text-base leading-relaxed">
                            Experience like never seen before we take you on the journey of your lifetime. 
                            Worldine Destinations Comprises of a dynamic team with an abundance of international experience in the travel industry. 
                            Our expertise is to deliver excellence service with the highest standards possible, all at excellent value for your money. 
                            Over 20 years of experience in the travel trade with knowledge in various fields Eg: Ticketing, Visas, outbound & inbound tours & Travel Insurance. 
                            have worked in top Iata agents,
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

                    <!-- Interactive About Section Destination Gallery Carousel with Smooth Edge Fade -->
                    <div class="lg:col-span-6 relative rounded-3xl overflow-hidden shadow-2xl w-full group smooth-card-edge-fade">
                        <!-- Image Container with Smooth Cross-Fade -->
                        <div class="relative h-72 sm:h-96 lg:h-[480px] w-full overflow-hidden bg-slate-950">
                            <img 
                                v-for="(dest, idx) in aboutDestinations"
                                :key="idx"
                                :src="dest.image" 
                                :alt="dest.country" 
                                :class="[
                                    'absolute inset-0 w-full h-full object-cover transition-all duration-1000 transform group-hover:scale-110',
                                    currentAboutSlide === idx ? 'opacity-100 z-10 scale-100' : 'opacity-0 z-0'
                                ]"
                            />
                            <!-- Dark Gradient Protection Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent z-20 pointer-events-none"></div>

                            <!-- Bottom Info Caption -->
                            <div v-if="aboutDestinations[currentAboutSlide]" class="absolute bottom-6 left-6 right-6 z-30 text-white space-y-1">
                                <h3 class="text-xl sm:text-3xl font-black tracking-wide">{{ aboutDestinations[currentAboutSlide]?.country }}</h3>
                                <p class="text-xs sm:text-sm text-slate-200 font-medium leading-tight">
                                    {{ aboutDestinations[currentAboutSlide]?.tagline }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATS BAR (FADED & BLENDED SEAMLESSLY WITHOUT BORDER OUTLINES) -->
        <section class="relative bg-gradient-to-b from-white via-slate-50/80 to-white py-10 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
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

            <!-- Destinations Cards Grid (100% Exact Actual Data from Backend) -->
            <div v-if="filteredDestinations && filteredDestinations.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-4 gap-6 lg:gap-8 w-full">
                <div 
                    v-for="dest in displayedFilteredDestinations" 
                    :key="dest.id"
                    class="group bg-white border border-slate-200/80 hover:border-[#2196F3]/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col transform hover:-translate-y-1 w-full"
                >
                    <!-- Image Banner & Badges (Clickable -> Opens Quick View) -->
                    <div @click="openQuickView(dest)" class="relative h-48 sm:h-56 lg:h-60 overflow-hidden bg-slate-100 cursor-pointer">
                        <img 
                            :src="dest.image || dest.main_image || '/images/Logo/worldineback.png'" 
                            :alt="dest.title" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-transparent to-transparent"></div>
                        
                        <!-- Badge Top Left -->
                        <span class="absolute top-3 left-3 bg-white/95 backdrop-blur-md text-slate-900 border border-slate-200 font-extrabold text-[11px] px-2.5 py-0.5 rounded-full shadow">
                            {{ dest.badge || (dest.destination ? dest.destination.name : 'Worldine Tour') }}
                        </span>

                        <!-- Location & Duration Bottom Image -->
                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-[11px] text-white">
                            <span class="flex items-center space-x-1 font-bold truncate max-w-[60%]">
                                <svg class="w-3.5 h-3.5 text-[#2196F3] fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>{{ dest.destination ? dest.destination.name : (dest.subtitle || 'Global Expedition') }}</span>
                            </span>
                            <span class="flex items-center space-x-1 bg-slate-900/85 backdrop-blur-md text-white px-2.5 py-1 rounded-md font-bold text-[10px] border border-white/20 shadow-xs">
                                <svg class="w-3 h-3 text-sky-400 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span>{{ getDurationBadgeText(dest) }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div class="space-y-1.5">
                            <Link :href="route('tours.show', dest.slug || dest.id)" class="block">
                                <h3 class="text-base font-extrabold text-slate-900 hover:text-[#2196F3] transition-colors line-clamp-1">
                                    {{ dest.title }}
                                </h3>
                            </Link>
                            <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed font-medium">
                                {{ dest.subtitle || dest.overview }}
                            </p>
                        </div>

                        <!-- Price & Action Footer -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <template v-if="dest.price && Number(dest.price) > 0">
                                    <span class="text-[10px] text-slate-500 font-medium block">Starting from</span>
                                    <div class="flex items-baseline space-x-1">
                                        <span class="text-lg sm:text-xl font-black text-[#0D47A1]">${{ Number(dest.price).toLocaleString() }}</span>
                                    </div>
                                </template>
                                <template v-else>
                                    <span class="text-[10px] font-extrabold text-[#0D47A1] bg-blue-50 px-2 py-1 rounded-md border border-blue-100 block whitespace-nowrap">
                                        Inquire Quote
                                    </span>
                                </template>
                            </div>

                            <div class="flex items-center space-x-1.5 flex-shrink-0">
                                <button 
                                    @click.stop="openQuickView(dest)"
                                    class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all whitespace-nowrap shadow-2xs"
                                >
                                    Quick View
                                </button>
                                <Link 
                                    :href="route('tours.show', dest.slug || dest.id)"
                                    @click.stop
                                    class="px-3 py-1.5 rounded-xl bg-[#0D47A1] hover:bg-[#1565C0] text-white font-extrabold text-xs shadow-md hover:shadow-lg transition-all flex items-center space-x-1 whitespace-nowrap"
                                >
                                    <span>Details</span>
                                    <span>→</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Empty state if no backend packages match -->
            <div v-else class="text-center py-16 bg-white rounded-3xl border border-slate-200/80 p-8 shadow-xs">
                <div class="text-4xl mb-3">🌍</div>
                <h3 class="text-lg font-bold text-slate-800">No Tour Packages Found</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Active tour packages added in the backend admin panel will appear here.</p>
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

                <!-- Floating Animated Airplanes & Dotted Flight Trail (Native SVG animateMotion + mpath - Hidden on Mobile) -->
                <div class="hidden sm:block absolute inset-0 pointer-events-none z-[1] overflow-hidden">
                    <svg class="w-full h-full" viewBox="0 0 1200 220" preserveAspectRatio="none">
                        <!-- Curved Dotted Trajectory Line -->
                        <path 
                            id="flightPathCurve" 
                            d="M -60 160 Q 350 40, 750 160 T 1260 50" 
                            stroke="rgba(255, 255, 255, 0.45)" 
                            stroke-width="3" 
                            stroke-dasharray="8,8" 
                            fill="none" 
                        />

                        <!-- Plane 1 (Primary Flight) -->
                        <g class="filter drop-shadow-[0_6px_14px_rgba(0,0,0,0.7)]">
                            <path 
                                d="M 28 0 C 23 -2.2 13 -3.8 2 -3.8 L -2 -3.8 L -14 -22 L -20 -22 L -11 -3.8 L -24 -3.8 L -29 -11 L -34 -11 L -30 0 L -34 11 L -29 11 L -24 3.8 L -11 3.8 L -20 22 L -14 22 L -2 3.8 L 2 3.8 C 13 3.8 23 2.2 28 0 Z" 
                                fill="#FFFFFF" 
                                stroke="#1E88E5" 
                                stroke-width="1.3" 
                                stroke-linejoin="round"
                            />
                            <path d="M 19 -1.2 C 22 -0.8 24 0 24 0 C 24 0 22 0.8 19 1.2 Z" fill="#0D47A1" />
                            <rect x="-3" y="-12" width="8" height="3" rx="1.5" fill="#38BDF8" />
                            <rect x="-3" y="9" width="8" height="3" rx="1.5" fill="#38BDF8" />
                            <animateMotion dur="7s" repeatCount="indefinite" rotate="auto">
                                <mpath href="#flightPathCurve" />
                            </animateMotion>
                        </g>

                        <!-- Plane 2 (Staggered Flight) -->
                        <g class="filter drop-shadow-[0_6px_14px_rgba(0,0,0,0.7)]">
                            <path 
                                d="M 28 0 C 23 -2.2 13 -3.8 2 -3.8 L -2 -3.8 L -14 -22 L -20 -22 L -11 -3.8 L -24 -3.8 L -29 -11 L -34 -11 L -30 0 L -34 11 L -29 11 L -24 3.8 L -11 3.8 L -20 22 L -14 22 L -2 3.8 L 2 3.8 C 13 3.8 23 2.2 28 0 Z" 
                                fill="#FFFFFF" 
                                stroke="#1E88E5" 
                                stroke-width="1.3" 
                                stroke-linejoin="round"
                            />
                            <path d="M 19 -1.2 C 22 -0.8 24 0 24 0 C 24 0 22 0.8 19 1.2 Z" fill="#0D47A1" />
                            <rect x="-3" y="-12" width="8" height="3" rx="1.5" fill="#38BDF8" />
                            <rect x="-3" y="9" width="8" height="3" rx="1.5" fill="#38BDF8" />
                            <animateMotion dur="7s" begin="-3.5s" repeatCount="indefinite" rotate="auto">
                                <mpath href="#flightPathCurve" />
                            </animateMotion>
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

                <!-- 4 White Feature Cards Grid with High-Visibility Topics -->
                <div class="w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    
                    <!-- Card 1 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide mb-3.5 leading-snug min-h-[48px] flex items-center justify-center border-b border-slate-100 pb-3">
                            DEDICATED SINGLE POINT OF CONTACT
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Eliminate the complexity of coordinating with multiple airlines, hotels, and visa services. Worldine Destinations provides a single, professional consultant who manages your entire international itinerary ensuring a seamless, stress-free planning experience.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide mb-3.5 leading-snug min-h-[48px] flex items-center justify-center border-b border-slate-100 pb-3">
                            GUARANTEED VALUE FOR YOUR BUDGET
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Thanks to our extensive network of airline and hotel partners, we secure the most competitive rates for your holiday packages. Whether you are planning a cost-conscious getaway or an opulent luxury vacation, we maximize the value of your travel investment.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide mb-3.5 leading-snug min-h-[48px] flex items-center justify-center border-b border-slate-100 pb-3">
                            AROUND THE CLOCK TRAVEL SUPPORT
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            Travel should be about excitement, not anxiety. Our 24/7 dedicated support hotline ensures that expert assistance from our Sri Lanka-based team is always available, regardless of your time zone or the specific travel challenges you may encounter.
                        </p>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white p-7 sm:p-8 rounded-3xl shadow-lg border border-slate-200/80 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col text-center">
                        <h3 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide mb-3.5 leading-snug min-h-[48px] flex items-center justify-center border-b border-slate-100 pb-3">
                            COMMITMENT TO SUSTAINABLE TOURISM
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-normal">
                            At Worldine Destinations, we prioritize travel that creates a positive impact. Building on a long-standing dedication to responsible tourism, every international holiday we curate is thoughtfully designed to be mindful of both local communities and the environment.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- CUSTOMER REVIEWS & TESTIMONIALS SECTION (MOVED HERE AFTER WHY CHOOSE WORLDINE SECTION) -->
        <section id="testimonials" class="py-16 sm:py-24 bg-white border-b border-slate-100 w-full px-6 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full">
                <div class="text-center max-w-xl mx-auto mb-12">
                    <span class="text-[#2B70B4] text-xs font-black uppercase tracking-widest">REAL TRAVELER STORIES</span>
                    <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-1">Loved By Over 45,000+ Explorers</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 w-full">
                    <div 
                        v-for="(t, idx) in testimonials" 
                        :key="idx"
                        class="bg-slate-50/80 border border-slate-200/80 hover:border-[#2B70B4]/40 p-6 sm:p-7 rounded-3xl space-y-4 flex flex-col justify-between shadow-sm hover:shadow-md transition-all duration-300 w-full"
                    >
                        <div class="space-y-3">
                            <div class="flex text-amber-400 space-x-1 text-sm">
                                <span v-for="star in t.rating" :key="star">★</span>
                            </div>
                            <p class="text-slate-700 text-xs sm:text-sm italic leading-relaxed">
                                "{{ t.text }}"
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-200/60 flex items-center space-x-3">
                            <img :src="t.avatar" :alt="t.name" class="w-10 h-10 rounded-full object-cover border-2 border-[#2B70B4]" />
                            <div>
                                <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ t.name }}</div>
                                <div class="text-[11px] text-slate-500">{{ t.location }} • <span class="text-[#2B70B4] font-semibold">{{ t.destination }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- READY TO START YOUR ADVENTURE CTA BANNER WITH ANIMATED AIRPLANES & DESTINATION MARKS -->
        <section class="py-8 sm:py-20 w-full px-4 sm:px-10 md:px-14 lg:px-20 xl:px-24">
            <div class="w-full relative rounded-3xl bg-gradient-to-r from-slate-950 via-[#0A2540] to-[#0D47A1] p-6 sm:p-12 md:p-14 overflow-hidden shadow-2xl text-white border border-blue-900/50">
                
                <!-- Background Radial Grid Pattern & Glow -->
                <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#38bdf8_1.5px,transparent_1.5px)] [background-size:24px_24px] pointer-events-none"></div>
                <div class="absolute -top-28 -right-28 w-80 sm:w-96 h-80 sm:h-96 bg-[#2196F3]/25 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
                <div class="absolute -bottom-28 -left-28 w-80 sm:w-96 h-80 sm:h-96 bg-teal-500/15 rounded-full blur-3xl animate-pulse pointer-events-none" style="animation-delay: 3s;"></div>

                <!-- ANIMATED SVG FLIGHT PATH, AIRPLANES & DESTINATION LOCATION PINS (Hidden on Mobile) -->
                <div class="hidden sm:block absolute inset-0 pointer-events-none overflow-hidden z-[1]">
                    <svg class="w-full h-full" viewBox="0 0 1200 280" preserveAspectRatio="none">
                        <defs>
                            <!-- Linear Gradients & Shadow Filters for Pins & Trails -->
                            <linearGradient id="pinGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#38BDF8" />
                                <stop offset="100%" stop-color="#0284C7" />
                            </linearGradient>
                            <linearGradient id="pinGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#F59E0B" />
                                <stop offset="100%" stop-color="#D97706" />
                            </linearGradient>
                            <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                <feGaussianBlur stdDeviation="3" result="blur" />
                                <feComposite in="SourceGraphic" in2="blur" operator="over" />
                            </filter>
                        </defs>

                        <!-- Curved Dotted Trajectory Flight Path -->
                        <path 
                            id="ctaFlightPath" 
                            d="M -50 200 Q 350 50, 750 170 T 1250 70" 
                            stroke="rgba(255, 255, 255, 0.4)" 
                            stroke-width="2.5" 
                            stroke-dasharray="8,8" 
                            fill="none" 
                        />

                        <!-- DESTINATION PIN MARK 1 (Left-Center Node) -->
                        <g transform="translate(280, 100)" filter="url(#glow)">
                            <!-- Ripple Animation Ring 1 -->
                            <circle cx="0" cy="0" r="16" fill="none" stroke="#38BDF8" stroke-width="2" opacity="0.6">
                                <animate attributeName="r" values="8;24;32" dur="3s" repeatCount="indefinite" />
                                <animate attributeName="opacity" values="0.8;0.3;0" dur="3s" repeatCount="indefinite" />
                            </circle>
                            <!-- Ripple Animation Ring 2 -->
                            <circle cx="0" cy="0" r="12" fill="none" stroke="#F59E0B" stroke-width="1.5" opacity="0.6">
                                <animate attributeName="r" values="6;18;26" dur="3s" begin="1.5s" repeatCount="indefinite" />
                                <animate attributeName="opacity" values="0.8;0.3;0" dur="3s" begin="1.5s" repeatCount="indefinite" />
                            </circle>
                            <!-- Pin Base Point -->
                            <circle cx="0" cy="0" r="4" fill="#FFFFFF" />
                            <!-- Pin Icon SVG -->
                            <path 
                                d="M 0 -22 C -6 -22 -10 -18 -10 -12 C -10 -4 0 4 0 4 C 0 4 10 -4 10 -12 C 10 -18 6 -22 0 -22 Z" 
                                fill="url(#pinGrad)" 
                                stroke="#FFFFFF" 
                                stroke-width="1.2"
                            />
                            <circle cx="0" cy="-12" r="3.5" fill="#FFFFFF" />
                        </g>

                        <!-- DESTINATION PIN MARK 2 (Right Node) -->
                        <g transform="translate(920, 120)" class="hidden md:block" filter="url(#glow)">
                            <!-- Ripple Ring -->
                            <circle cx="0" cy="0" r="18" fill="none" stroke="#38BDF8" stroke-width="2" opacity="0.7">
                                <animate attributeName="r" values="10;28;38" dur="3.5s" repeatCount="indefinite" />
                                <animate attributeName="opacity" values="0.9;0.4;0" dur="3.5s" repeatCount="indefinite" />
                            </circle>
                            <!-- Pin Base -->
                            <circle cx="0" cy="0" r="5" fill="#FFFFFF" />
                            <!-- Pin Icon -->
                            <path 
                                d="M 0 -28 C -8 -28 -14 -22 -14 -14 C -14 -4 0 6 0 6 C 0 6 14 -4 14 -14 C 14 -22 8 -28 0 -28 Z" 
                                fill="url(#pinGrad2)" 
                                stroke="#FFFFFF" 
                                stroke-width="1.5"
                            />
                            <circle cx="0" cy="-14" r="4.5" fill="#FFFFFF" />
                        </g>

                        <!-- DESTINATION PIN MARK 3 (Far Right Top Node) -->
                        <g transform="translate(1100, 70)" class="hidden lg:block" filter="url(#glow)">
                            <circle cx="0" cy="0" r="12" fill="none" stroke="#34D399" stroke-width="1.5" opacity="0.5">
                                <animate attributeName="r" values="6;16;22" dur="2.5s" repeatCount="indefinite" />
                                <animate attributeName="opacity" values="0.8;0.2;0" dur="2.5s" repeatCount="indefinite" />
                            </circle>
                            <circle cx="0" cy="0" r="3" fill="#FFFFFF" />
                            <path 
                                d="M 0 -18 C -5 -18 -8 -14 -8 -9 C -8 -3 0 3 0 3 C 0 3 8 -3 8 -9 C 8 -14 5 -18 0 -18 Z" 
                                fill="#10B981" 
                                stroke="#FFFFFF" 
                                stroke-width="1"
                            />
                        </g>

                        <!-- ANIMATED AIRPLANE 1 (Sleek Commercial Airliner Jet) -->
                        <g class="filter drop-shadow-[0_8px_16px_rgba(0,0,0,0.8)]">
                            <!-- Main Airframe -->
                            <path 
                                d="M 28 0 C 23 -2.2 13 -3.8 2 -3.8 L -2 -3.8 L -14 -22 L -20 -22 L -11 -3.8 L -24 -3.8 L -29 -11 L -34 -11 L -30 0 L -34 11 L -29 11 L -24 3.8 L -11 3.8 L -20 22 L -14 22 L -2 3.8 L 2 3.8 C 13 3.8 23 2.2 28 0 Z" 
                                fill="#FFFFFF" 
                                stroke="#1E88E5" 
                                stroke-width="1.3" 
                                stroke-linejoin="round"
                            />
                            <!-- Cockpit Windshield -->
                            <path d="M 19 -1.2 C 22 -0.8 24 0 24 0 C 24 0 22 0.8 19 1.2 Z" fill="#0D47A1" />
                            <!-- Underwing Jet Engines -->
                            <rect x="-3" y="-12" width="8" height="3" rx="1.5" fill="#38BDF8" />
                            <rect x="-3" y="9" width="8" height="3" rx="1.5" fill="#38BDF8" />
                            
                            <animateMotion dur="8.5s" repeatCount="indefinite" rotate="auto">
                                <mpath href="#ctaFlightPath" />
                            </animateMotion>
                        </g>

                        <!-- ANIMATED AIRPLANE 2 (Trailing Sleek Jet Airliner) -->
                        <g class="filter drop-shadow-[0_8px_16px_rgba(0,0,0,0.8)]">
                            <!-- Main Airframe -->
                            <path 
                                d="M 28 0 C 23 -2.2 13 -3.8 2 -3.8 L -2 -3.8 L -14 -22 L -20 -22 L -11 -3.8 L -24 -3.8 L -29 -11 L -34 -11 L -30 0 L -34 11 L -29 11 L -24 3.8 L -11 3.8 L -20 22 L -14 22 L -2 3.8 L 2 3.8 C 13 3.8 23 2.2 28 0 Z" 
                                fill="#F8FAFC" 
                                stroke="#F59E0B" 
                                stroke-width="1.3" 
                                stroke-linejoin="round"
                            />
                            <!-- Cockpit Windshield -->
                            <path d="M 19 -1.2 C 22 -0.8 24 0 24 0 C 24 0 22 0.8 19 1.2 Z" fill="#D97706" />
                            <!-- Underwing Jet Engines -->
                            <rect x="-3" y="-12" width="8" height="3" rx="1.5" fill="#F59E0B" />
                            <rect x="-3" y="9" width="8" height="3" rx="1.5" fill="#F59E0B" />

                            <animateMotion dur="8.5s" begin="-4.25s" repeatCount="indefinite" rotate="auto">
                                <mpath href="#ctaFlightPath" />
                            </animateMotion>
                        </g>
                    </svg>
                </div>

                <!-- Banner Content Grid -->
                <div class="relative z-10 max-w-2xl space-y-3.5 sm:space-y-4">
                    <span class="bg-[#2B70B4] text-white text-[10px] sm:text-[11px] font-extrabold px-3 sm:px-3.5 py-1 rounded-full uppercase tracking-widest shadow-sm inline-block">
                        START YOUR JOURNEY
                    </span>
                    <h2 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight text-white">
                        Ready to start your adventure?
                    </h2>
                    <p class="text-slate-300 font-normal text-xs sm:text-base max-w-xl leading-relaxed">
                        Get in touch with our dedicated travel experts today. We curate bespoke tours, visa assistance, and luxury holiday packages tailored specifically to your dream destinations.
                    </p>

                    <div class="pt-3 sm:pt-4">
                        <a 
                            href="#footer" 
                            class="inline-flex items-center justify-center space-x-2.5 px-6 sm:px-8 py-3.5 sm:py-4 rounded-full bg-[#2196F3] text-white font-extrabold text-xs sm:text-sm uppercase tracking-wider shadow-xl hover:bg-[#1E5288] transition-all duration-300 transform hover:scale-105 w-full sm:w-auto text-center"
                        >
                            <span>CONTACT US NOW</span>
                            <span class="text-base">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER WITH SITE THEME (RESPONSIVE: DESKTOP 4-COLUMN + MOBILE 3-ROW) -->
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

            <!-- DESKTOP FOOTER VIEW (md:block hidden) -->
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
                                <a href="https://www.facebook.com/worldinedestinations/" target="_blank" class="w-7 h-7 rounded-full bg-white/10 hover:bg-[#2196F3] text-white flex items-center justify-center font-bold text-xs transition-all border border-white/15 shadow-sm" aria-label="Facebook">
                                    f
                                </a>
                                <a href="https://www.instagram.com/worldinedestinations" target="_blank" class="w-7 h-7 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center font-bold text-xs transition-all border border-white/15 shadow-sm" aria-label="Instagram">
                                    📷
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
                            <li><a href="#hero" class="hover:text-[#90CAF9] transition-colors">Home</a></li>
                            <li><a href="#about" class="hover:text-[#90CAF9] transition-colors">About Us</a></li>
                            <li><a href="#glimpse-destinations" class="hover:text-[#90CAF9] transition-colors">Destinations</a></li>
                            <li><Link href="/contact" class="hover:text-[#90CAF9] transition-colors">Contact Us</Link></li>
                            <li><a href="#testimonials" class="hover:text-[#90CAF9] transition-colors">Traveler Stories</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Inbound & Outbound Tours -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Tour Expeditions
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Sri Lanka Heritage Tours</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Maldives Luxury Escapes</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Dubai & UAE Safaris</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Europe Schengen Tours</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Japan & East Asia Tours</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: Contact & Hotlines -->
                    <div class="space-y-3">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-xs uppercase tracking-wider border-b border-white/15 pb-1.5">
                            Contact & Support
                        </h4>
                        <ul class="space-y-2 text-xs font-semibold text-slate-200">
                            <li>
                                <a href="tel:+94766834881" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <span>📞</span>
                                    <span>+94 766 834 881</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:+94718834881" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <span>📞</span>
                                    <span>+94 718 834 881</span>
                                </a>
                            </li>
                            <li>
                                <a href="tel:+94778692229" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <span>📞</span>
                                    <span>+94 778 869 222</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:info@worldinedestinations.com" class="flex items-center space-x-2 hover:text-[#90CAF9] transition-colors">
                                    <span>✉️</span>
                                    <span class="truncate">info@worldinedestinations.com</span>
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

            <!-- MOBILE FOOTER VIEW (block md:hidden) -->
            <div class="block md:hidden relative z-10 pt-6 pb-4 w-full px-4 space-y-5 font-spinnaker">
                
                <!-- ROW 1: Logo & Social Links -->
                <div class="flex items-center justify-between border-b border-white/15 pb-4">
                    <Link href="/" class="inline-block group">
                        <img 
                            src="/images/Logo/worldine.png" 
                            alt="Worldine Destinations Logo" 
                            class="h-12 w-auto object-contain filter drop-shadow-md" 
                        />
                    </Link>

                    <!-- Social Media Links -->
                    <div class="flex items-center space-x-2">
                        <a href="https://www.facebook.com/worldinedestinations/" target="_blank" class="w-7 h-7 rounded-full bg-white/10 hover:bg-[#2196F3] text-white flex items-center justify-center font-bold text-xs transition-all border border-white/15 shadow-sm" aria-label="Facebook">
                            f
                        </a>
                        <a href="https://www.instagram.com/worldinedestinations" target="_blank" class="w-7 h-7 rounded-full bg-white/10 hover:bg-rose-500 text-white flex items-center justify-center font-bold text-xs transition-all border border-white/15 shadow-sm" aria-label="Instagram">
                            📷
                        </a>
                    </div>
                </div>

                <!-- ROW 2: 3 Columns for Contents and Links -->
                <div class="grid grid-cols-3 gap-2">
                    <!-- Column 1: Quick Links -->
                    <div class="space-y-2">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-[10px] uppercase tracking-wider border-b border-white/15 pb-1">
                            Quick Links
                        </h4>
                        <ul class="space-y-1.5 text-[9.5px] font-semibold text-slate-200">
                            <li><a href="#hero" class="hover:text-[#90CAF9] transition-colors">Home</a></li>
                            <li><a href="#about" class="hover:text-[#90CAF9] transition-colors">About Us</a></li>
                            <li><a href="#glimpse-destinations" class="hover:text-[#90CAF9] transition-colors">Tours</a></li>
                            <li><a href="#estimator" class="hover:text-[#90CAF9] transition-colors">Education</a></li>
                            <li><a href="#testimonials" class="hover:text-[#90CAF9] transition-colors">Stories</a></li>
                        </ul>
                    </div>

                    <!-- Column 2: Tour Expeditions -->
                    <div class="space-y-2">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-[10px] uppercase tracking-wider border-b border-white/15 pb-1">
                            Tours
                        </h4>
                        <ul class="space-y-1.5 text-[9.5px] font-semibold text-slate-200">
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Sri Lanka</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Maldives</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Dubai</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Schengen</a></li>
                            <li><a href="#destinations" class="hover:text-[#90CAF9] transition-colors">Japan</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Contact & Support -->
                    <div class="space-y-2">
                        <h4 class="text-[#90CAF9] font-spinnaker font-bold text-[10px] uppercase tracking-wider border-b border-white/15 pb-1">
                            Contact
                        </h4>
                        <ul class="space-y-1.5 text-[9.5px] font-semibold text-slate-200">
                            <li><a href="tel:+94766834881" class="hover:text-[#90CAF9] transition-colors block truncate">+94 766 834 881</a></li>
                            <li><a href="tel:+94718834881" class="hover:text-[#90CAF9] transition-colors block truncate">+94 718 834 881</a></li>
                            <li><a href="tel:+94778692229" class="hover:text-[#90CAF9] transition-colors block truncate">+94 778 869 222</a></li>
                            <li><a href="mailto:info@worldinedestinations.com" class="hover:text-[#90CAF9] transition-colors block truncate">Email Us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- ROW 3: Bottom Copyright Bar -->
                <div class="pt-3 border-t border-white/15 text-center text-[10px] text-slate-400 font-spinnaker">
                    <div>Copyright © 2026 Worldine Destinations (Pvt) Ltd. All Rights Reserved.</div>
                </div>
            </div>
        </footer>

        <!-- QUICK VIEW MODAL (100% Exact Actual Data from Backend) -->
        <div v-if="isBookingModalOpen && activeModalDestination" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-xs">
            <div class="bg-white border border-slate-200 rounded-3xl max-w-xl w-full max-h-[90vh] overflow-y-auto p-6 sm:p-8 space-y-5 shadow-2xl relative">
                <!-- Close Button -->
                <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900 p-1.5 text-lg font-bold">
                    ✕
                </button>

                <!-- Modal Content Header -->
                <div class="flex items-center space-x-3">
                    <span class="bg-[#0D47A1] text-white font-extrabold text-[10px] px-3 py-1 rounded-full uppercase shadow-xs">
                        {{ activeModalDestination.badge || (activeModalDestination.destination ? activeModalDestination.destination.name : 'Worldine Tour') }}
                    </span>
                    <span class="text-xs text-slate-600 font-bold">📍 {{ activeModalDestination.destination ? activeModalDestination.destination.name : (activeModalDestination.subtitle || 'Global Expedition') }}</span>
                    <span class="text-xs text-[#0D47A1] font-extrabold ml-auto">⏱️ {{ activeModalDestination.duration || (activeModalDestination.duration_days + ' Days') }}</span>
                </div>

                <h3 class="text-xl sm:text-2xl font-black text-slate-900">
                    {{ activeModalDestination.title }}
                </h3>

                <!-- Modal Image -->
                <img 
                    :src="activeModalDestination.image || activeModalDestination.main_image || '/images/Logo/worldineback.png'" 
                    :alt="activeModalDestination.title" 
                    class="w-full h-56 object-cover rounded-2xl shadow-sm" 
                />

                <!-- Description & Highlights -->
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed font-medium">
                    {{ activeModalDestination.overview || activeModalDestination.subtitle }}
                </p>

                <div v-if="activeModalDestination.inclusions && activeModalDestination.inclusions.length">
                    <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-wider mb-2">Package Inclusions:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div v-for="(inc, i) in activeModalDestination.inclusions" :key="i" class="text-xs bg-slate-50 p-2.5 rounded-xl border border-slate-200/80 text-slate-700 flex items-center space-x-2 font-medium">
                            <span class="text-blue-600 font-bold">✓</span>
                            <span>{{ inc }}</span>
                        </div>
                    </div>
                </div>

                <!-- Price & Modal Action -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-500 font-medium block">Starting Price</span>
                        <div v-if="activeModalDestination.price && Number(activeModalDestination.price) > 0" class="text-2xl font-black text-[#0D47A1]">
                            ${{ Number(activeModalDestination.price).toLocaleString() }} USD
                        </div>
                        <div v-else class="text-xs font-black bg-blue-50 text-[#0D47A1] px-3 py-1 rounded-lg border border-blue-100">
                            Inquire for Quote
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button @click="closeModal" class="px-4 py-2.5 rounded-full bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200">
                            Close
                        </button>
                        <Link 
                            :href="route('tours.show', activeModalDestination.slug)"
                            class="px-5 py-2.5 rounded-full bg-[#0D47A1] hover:bg-[#1565C0] text-white font-extrabold text-xs shadow-md transition-all flex items-center space-x-1.5"
                        >
                            <span>View Full Itinerary</span>
                            <span>→</span>
                        </Link>
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

/* Smooth Feathered Edge Mask for About Image Container */
.smooth-card-edge-fade {
    -webkit-mask-image: radial-gradient(ellipse 94% 94% at 50% 50%, rgba(0, 0, 0, 1) 65%, rgba(0, 0, 0, 0) 100%);
    mask-image: radial-gradient(ellipse 94% 94% at 50% 50%, rgba(0, 0, 0, 1) 65%, rgba(0, 0, 0, 0) 100%);
}

</style>
