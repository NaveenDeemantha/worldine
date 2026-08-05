<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\PackageItineraryDay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Clean Outbound & Inbound Destinations (Alphabetical Order for Outbound)
        $destinations = [
            [
                'name' => 'Sri Lanka',
                'slug' => 'srilanka',
                'type' => 'inbound',
                'subtitle' => 'UNESCO Ruins, Tea Estates, Wildlife Safaris & Gold Beaches',
                'description' => 'Explore the wonder of Asia with 20+ years of local Sri Lankan travel expertise.',
                'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Sri Lanka Inbound #1',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Australia',
                'slug' => 'australia',
                'type' => 'outbound',
                'subtitle' => 'Great Barrier Reef, Sydney Opera House & Coastal Drives',
                'description' => 'Unforgettable Pacific ocean adventures, rainforests, and vibrant Australian coastal cities.',
                'image' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Pacific Wonder',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Bali',
                'slug' => 'bali',
                'type' => 'outbound',
                'subtitle' => 'Tropical Island Resorts, Rice Terraces & Sunset Temples',
                'description' => 'Experience the magic of Bali with luxury oceanfront villas, sacred temples, and coral reef diving.',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Tropical Island Escape',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'China',
                'slug' => 'china',
                'type' => 'outbound',
                'subtitle' => 'Great Wall of China, Forbidden City & Yangtze River Cruises',
                'description' => 'Explore thousands of years of imperial history, silk roads, modern skylines, and natural wonders.',
                'image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Imperial History',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Dubai',
                'slug' => 'dubai',
                'type' => 'outbound',
                'subtitle' => 'Burj Khalifa, Desert Dunes & Marina Luxury Cruises',
                'description' => 'Ultra-modern luxury skyscrapers, 4x4 dune bashing, and high-end marina yachts.',
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Luxury City Escape',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Egypt',
                'slug' => 'egypt',
                'type' => 'outbound',
                'subtitle' => 'Great Pyramids of Giza, Sphinx & Nile River Expeditions',
                'description' => 'Witness ancient pharaonic monuments, Valley of the Kings, and romantic Nile River cruises.',
                'image' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Pharaonic History',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Japan',
                'slug' => 'japan',
                'type' => 'outbound',
                'subtitle' => 'Kyoto Zen Shrines, Mount Fuji & Tokyo Bullet Trains',
                'description' => 'Discover futuristic cities, ancient shrines, and cherry blossom avenues across Japan.',
                'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
                'badge' => 'East Asia Discovery',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Thailand',
                'slug' => 'thailand',
                'type' => 'outbound',
                'subtitle' => 'Bangkok Grand Palace, Phuket Islands & Golden Temples',
                'description' => 'Immerse yourself in rich Thai hospitality, bustling night markets, island hopping, and serene temples.',
                'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Golden Land Escape',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        // Clean up any unlisted/old dummy destinations
        $validSlugs = collect($destinations)->pluck('slug')->toArray();
        Destination::whereNotIn('slug', $validSlugs)->delete();

        foreach ($destinations as $destData) {
            $dest = Destination::updateOrCreate(['slug' => $destData['slug']], $destData);

            // Seed Packages for each destination
            if ($dest->slug === 'srilanka') {
                $pkg1 = TourPackage::updateOrCreate(
                    ['slug' => 'srilanka-heritage-cultural-tour'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Heritage & Cultural Tour Sri Lanka',
                        'subtitle' => 'Sigiriya Rock, Polonnaruwa Ruins & Temple of the Tooth',
                        'category' => 'srilanka-inbound',
                        'price' => null,
                        'duration_days' => 6,
                        'duration_nights' => 5,
                        'badge' => 'Best Value Sri Lanka',
                        'main_image' => 'https://images.unsplash.com/photo-1586611292717-f828b167408c?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Journey through 2,500 years of royal Sri Lankan history, ancient UNESCO fortresses, lush tea highlands, and sacred Buddhist sanctuaries.',
                        'inclusions' => ['4-Star Luxury Hotel Stays', 'Private Air-Conditioned Vehicle', 'English Speaking Tour Guide', 'Daily Breakfast & Dinner', 'Entrance Tickets & Safaris'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );

                $days = [
                    [
                        'day_number' => 1,
                        'title' => 'Arrival in Colombo & Transfer to Sigiriya Ancient Rock Fortress',
                        'description' => 'Warm welcome at Bandaranaike International Airport (CMB). Scenic drive to Sigiriya through coconut plantations. Evening climb to the 5th-century Sigiriya Lion Rock Citadel overlooking emerald jungle vistas.',
                        'image' => 'https://images.unsplash.com/photo-1586611292717-f828b167408c?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => 'Sigiriya King\'s Resort (5★)',
                        'meals' => 'Dinner Included',
                    ],
                    [
                        'day_number' => 2,
                        'title' => 'Ancient Polonnaruwa Royal Kingdom & Minneriya Elephant Safari',
                        'description' => 'Explore the ancient stone stupas and royal palaces of Polonnaruwa. In the afternoon, embark on an open 4x4 Jeep Safari in Minneriya National Park to witness hundreds of wild Asian elephants.',
                        'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => 'Sigiriya King\'s Resort (5★)',
                        'meals' => 'Breakfast & Dinner',
                    ],
                ];

                foreach ($days as $dayData) {
                    PackageItineraryDay::updateOrCreate(
                        ['tour_package_id' => $pkg1->id, 'day_number' => $dayData['day_number']],
                        $dayData
                    );
                }

                TourPackage::updateOrCreate(
                    ['slug' => 'srilanka-wildlife-nature-safari'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Sri Lanka Wildlife & Nature Safari',
                        'subtitle' => 'Yala Leopard Safaris, Udawalawe Elephants & Sinharaja Rainforest',
                        'category' => 'srilanka-inbound',
                        'price' => null,
                        'duration_days' => 5,
                        'duration_nights' => 4,
                        'badge' => 'Wildlife Expedition',
                        'main_image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Track wild leopards, sloth bears, and herds of elephants across Sri Lanka premier national reserves.',
                        'inclusions' => ['4x4 Safari Jeeps', 'Luxury Eco-Lodge Stays', 'Expert Wildlife Tracker', 'All Meals & Park Fees'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 2,
                    ]
                );
            } elseif ($dest->slug === 'australia') {
                TourPackage::updateOrCreate(
                    ['slug' => 'australia-coastal-great-barrier-reef'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Australia Coastal & Great Barrier Reef Expedition',
                        'subtitle' => 'Sydney Opera House, Great Barrier Reef & Gold Coast',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 8,
                        'duration_nights' => 7,
                        'badge' => 'Pacific Escape',
                        'main_image' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Discover Australia\'s iconic coastlines, Sydney Harbor cruises, and tropical barrier reef diving.',
                        'inclusions' => ['4-Star City Hotels', 'Reef Cruise Ticket', 'Internal Australian Flights'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'bali') {
                TourPackage::updateOrCreate(
                    ['slug' => 'bali-tropical-island-wellness-escape'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Bali Tropical Island & Wellness Escape',
                        'subtitle' => 'Ubud Rice Terraces, Uluwatu Sunset Temple & Beach Resorts',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 6,
                        'duration_nights' => 5,
                        'badge' => 'Island Paradise',
                        'main_image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Relax in luxury Ubud jungle pool villas and beachfront resorts with traditional Balinese spa treatments.',
                        'inclusions' => ['Private Pool Villa', 'Airport Transfers', 'Daily Breakfast & Spa Coupon'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'china') {
                TourPackage::updateOrCreate(
                    ['slug' => 'china-imperial-wonders-great-wall'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'China Imperial Wonders & Great Wall Expedition',
                        'subtitle' => 'Beijing Great Wall, Forbidden City & Shanghai Bund',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 7,
                        'duration_nights' => 6,
                        'badge' => 'Imperial History',
                        'main_image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Explore the ancient wonders of Beijing and modern skyscrapers of Shanghai with VIP bullet train travel.',
                        'inclusions' => ['5-Star Luxury Hotels', 'High-Speed Bullet Train', 'VIP Sightseeing Passes'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'dubai') {
                TourPackage::updateOrCreate(
                    ['slug' => 'dubai-luxury-desert-skyscraper-escape'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Dubai Luxury Desert & Skyscraper Escape',
                        'subtitle' => 'Burj Khalifa 148th Floor, 4x4 Desert Safari & Marina Yacht',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 5,
                        'duration_nights' => 4,
                        'badge' => 'Luxury City Escape',
                        'main_image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Experience Dubai\'s ultimate luxury attractions, private desert dune dinners, and world-class shopping.',
                        'inclusions' => ['5-Star Luxury Hotel', 'Desert Safari with Dinner', 'Burj Khalifa Fast-Track Entry'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'egypt') {
                TourPackage::updateOrCreate(
                    ['slug' => 'egypt-pharaohs-pyramids-nile-cruise'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Egypt Pharaohs, Pyramids & Nile Cruise',
                        'subtitle' => 'Giza Pyramids, Sphinx, Luxor Temples & 5-Star Nile Cruise',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 8,
                        'duration_nights' => 7,
                        'badge' => 'Pharaonic History',
                        'main_image' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Sail along the historic Nile River visiting Valley of the Kings, Karnak Temple, and ancient Giza pyramids.',
                        'inclusions' => ['Cairo 5-Star Hotel', '5-Star Nile Cruise Ship', 'Egyptologist Tour Guide'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'japan') {
                TourPackage::updateOrCreate(
                    ['slug' => 'japan-cultural-discovery-shinkansen'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Japan Cultural Discovery & Mount Fuji Tour',
                        'subtitle' => 'Tokyo Shibuya, Mount Fuji Summit & Kyoto Zen Shrines',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 7,
                        'duration_nights' => 6,
                        'badge' => 'East Asia Discovery',
                        'main_image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Discover the harmony of ancient Japanese traditions and futuristic Tokyo technology with Shinkansen bullet train rides.',
                        'inclusions' => ['City Center Hotel Stays', 'JR Bullet Train Pass', 'Guided Kyoto & Tokyo Tours'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'thailand') {
                TourPackage::updateOrCreate(
                    ['slug' => 'thailand-bangkok-phuket-island-escape'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Thailand Bangkok & Phuket Island Escape',
                        'subtitle' => 'Grand Palace Temples, Phi Phi Island Speedboat & Markets',
                        'category' => 'global-outbound',
                        'price' => null,
                        'duration_days' => 6,
                        'duration_nights' => 5,
                        'badge' => 'Golden Land Escape',
                        'main_image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Experience the rich culture of Bangkok and tropical beaches of Phuket with Phi Phi Island speedboat tours.',
                        'inclusions' => ['4-Star Hotels', 'Speedboat Island Tour', 'Domestic Flight Bangkok-Phuket'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            }
        }

        // 3. Seed Sample Package-Wise & Contact Form Inquiries
        $sriLankaPkg = TourPackage::where('slug', 'srilanka-heritage-cultural-tour')->first();
        $dubaiPkg = TourPackage::where('slug', 'dubai-luxury-desert-skyscraper-escape')->first();

        \App\Models\Inquiry::updateOrCreate(
            ['reference_id' => 'WRD-8021'],
            [
                'type' => 'package_inquiry',
                'customer_name' => 'Alexander Wright',
                'email' => 'alex.w@gmail.com',
                'phone' => '+1 (555) 234-5678',
                'tour_package_id' => $sriLankaPkg ? $sriLankaPkg->id : null,
                'package_title' => $sriLankaPkg ? $sriLankaPkg->title : 'Heritage & Cultural Tour Sri Lanka',
                'travel_date' => '2026-08-15',
                'guests' => 2,
                'inquiry_type' => 'Tour Package Booking',
                'status' => 'Confirmed',
                'message' => 'Interested in booking the 6-day heritage tour for 2 adults. Requesting hotel upgrades.',
            ]
        );

        \App\Models\Inquiry::updateOrCreate(
            ['reference_id' => 'WRD-8022'],
            [
                'type' => 'package_inquiry',
                'customer_name' => 'Sophia Chen',
                'email' => 'sophia.c@outlook.com',
                'phone' => '+44 7700 900077',
                'tour_package_id' => $dubaiPkg ? $dubaiPkg->id : null,
                'package_title' => $dubaiPkg ? $dubaiPkg->title : 'Dubai Luxury Desert & Skyscraper Escape',
                'travel_date' => '2026-09-02',
                'guests' => 4,
                'inquiry_type' => 'Luxury Escape Inquiry',
                'status' => 'Pending',
                'message' => 'Family travel inquiry for 4 guests including Burj Khalifa tickets.',
            ]
        );

        \App\Models\Inquiry::updateOrCreate(
            ['reference_id' => 'WRD-9105'],
            [
                'type' => 'general_contact',
                'customer_name' => 'Michael Scott',
                'email' => 'm.scott@dundermifflin.com',
                'phone' => '+1 (555) 987-6543',
                'destination_name' => 'Custom Sri Lanka & Maldives Combo',
                'inquiry_type' => 'Custom Tour Package',
                'travel_date' => '2026-10-10',
                'guests' => 6,
                'status' => 'Contacted',
                'message' => 'Looking for a custom 10-day honeymoon package combining Sri Lanka tea highlands with Maldives overwater villa.',
            ]
        );

        \App\Models\Inquiry::updateOrCreate(
            ['reference_id' => 'WRD-9106'],
            [
                'type' => 'general_contact',
                'customer_name' => 'Elena Rostova',
                'email' => 'elena.rostova@travel.de',
                'phone' => '+49 30 123456',
                'destination_name' => 'Corporate Group Outbound',
                'inquiry_type' => 'Corporate Travel',
                'status' => 'Pending',
                'message' => 'Requesting quote and itinerary for 15 executives traveling to Japan in November.',
            ]
        );
    }
}
