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

        // 2. Seed Destinations (Inbound & Outbound)
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
                'name' => 'Switzerland & Europe',
                'slug' => 'switzerland-europe',
                'type' => 'outbound',
                'subtitle' => 'Alpine Snow Peaks & Schengen Grand Expeditions',
                'description' => 'Experience world-class European grandeur, pristine Swiss Alps, and romantic historic cities.',
                'image' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=800&q=80',
                'badge' => 'European Grand Tour',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Japan & East Asia',
                'slug' => 'japan-east-asia',
                'type' => 'outbound',
                'subtitle' => 'Kyoto Temples, Mount Fuji & Shinkansen Bullet Trains',
                'description' => 'Discover futuristic cities, ancient shrines, and cherry blossom avenues across Japan.',
                'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Heritage & Culture',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Dubai & UAE',
                'slug' => 'dubai-uae',
                'type' => 'outbound',
                'subtitle' => 'Burj Khalifa, Desert Dunes & Marina Luxury Cruises',
                'description' => 'Ultra-modern luxury skyscrapers, 4x4 dune bashing, and high-end marina yachts.',
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Luxury City Escape',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Australia & Pacific',
                'slug' => 'australia-pacific',
                'type' => 'outbound',
                'subtitle' => 'Great Barrier Reef & Sydney Opera House',
                'description' => 'Unforgettable Pacific ocean adventures, rainforests, and vibrant coastal cities.',
                'image' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Pacific Ocean Escape',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Maldives Paradise',
                'slug' => 'maldives-paradise',
                'type' => 'outbound',
                'subtitle' => 'Overwater Villas, Crystal Atolls & Sunset Cruises',
                'description' => 'The ultimate tropical island getaway with private overwater bungalows and turquoise lagoons.',
                'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
                'badge' => 'Overwater Bungalow',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

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

                // Seed Itinerary Days for Sri Lanka Heritage Tour
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
                    [
                        'day_number' => 3,
                        'title' => 'Dambulla Cave Temple & Kandy Sacred Temple of the Tooth',
                        'description' => 'Visit the Dambulla Cave Temple complex containing golden Buddha statues. Continue to Kandy city, visit the Royal Botanical Gardens, and witness the sacred Tooth Relic ceremony at sunset.',
                        'image' => 'https://images.unsplash.com/photo-1578637387939-43c525550085?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => 'Earl\'s Regency Kandy (5★)',
                        'meals' => 'Breakfast & Dinner',
                    ],
                    [
                        'day_number' => 4,
                        'title' => 'Scenic Blue Train Journey to Ella & Nine Arch Bridge',
                        'description' => 'Board the iconic blue mountain train through misty Ceylon tea plantations. Arrive in Ella, hike to Little Adam\'s Peak, and photograph the world-famous Nine Arch Railway Viaduct.',
                        'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => '98 Acres Resort & Spa Ella (5★)',
                        'meals' => 'Breakfast & Dinner',
                    ],
                    [
                        'day_number' => 5,
                        'title' => 'Galle Dutch Fort UNESCO Heritage & Mirissa Coastal Sunset',
                        'description' => 'Descend to the southern coast. Stroll along cobblestone ramparts inside 16th-century Galle Fort. Relax at Mirissa beach with fresh seafood and golden ocean sunset views.',
                        'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => 'Mirissa Beachfront Luxury Villa (5★)',
                        'meals' => 'Breakfast & Seafood Dinner',
                    ],
                    [
                        'day_number' => 6,
                        'title' => 'Colombo City Experience & Departure Transfer',
                        'description' => 'Enjoy a short city tour of Colombo including Independence Square and Gangaramaya Temple. Transfer to airport for your onward flight with unforgettable memories.',
                        'image' => 'https://images.unsplash.com/photo-1586611292717-f828b167408c?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => 'Day Use Hotel / Departure',
                        'meals' => 'Breakfast Included',
                    ],
                ];

                foreach ($days as $dayData) {
                    PackageItineraryDay::updateOrCreate(
                        ['tour_package_id' => $pkg1->id, 'day_number' => $dayData['day_number']],
                        $dayData
                    );
                }

                // Seed Wildlife Safari Package
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
            } elseif ($dest->slug === 'switzerland-europe') {
                $pkgEur = TourPackage::updateOrCreate(
                    ['slug' => 'europe-schengen-grand-expedition'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Europe Schengen Grand Expedition',
                        'subtitle' => 'Paris Eiffel Tower, Swiss Alps Jungfraujoch & Venice Canals',
                        'category' => 'europe-schengen',
                        'price' => null,
                        'duration_days' => 9,
                        'duration_nights' => 8,
                        'badge' => 'European Grand Tour',
                        'main_image' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Cross 4 European nations featuring high-speed TGV rail, Swiss mountain cable cars, and romantic Venetian gondolas.',
                        'inclusions' => ['4-Star City Center Hotels', 'Schengen Rail Passes', 'Panoramic Cable Car Tickets', 'Daily European Breakfast'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );

                PackageItineraryDay::updateOrCreate(
                    ['tour_package_id' => $pkgEur->id, 'day_number' => 1],
                    [
                        'day_number' => 1,
                        'title' => 'Arrival in Paris & Seine River Evening Cruise',
                        'description' => 'Welcome to Paris! Check into your hotel near Champs-Élysées. Enjoy a glass of champagne on a illuminated Seine River evening boat cruise.',
                        'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80',
                        'accommodation' => 'Pullman Paris Tour Eiffel (4★)',
                        'meals' => 'Welcome Dinner Included',
                    ]
                );
            } elseif ($dest->slug === 'japan-east-asia') {
                TourPackage::updateOrCreate(
                    ['slug' => 'japan-east-asia-cultural-discovery'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'East Asia Cultural Discovery - Japan',
                        'subtitle' => 'Tokyo Shibuya, Mount Fuji Summit & Kyoto Zen Shrines',
                        'category' => 'east-asia',
                        'price' => null,
                        'duration_days' => 7,
                        'duration_nights' => 6,
                        'badge' => 'Heritage & Culture',
                        'main_image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Immerse in Japanese tradition, bullet train travel, hot spring ryokans, and Michelin-starred dining.',
                        'inclusions' => ['JR Shinkansen Bullet Train Pass', 'Traditional Ryokan Stay with Onsen', 'Guided City Tours', 'Daily Breakfast'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'dubai-uae') {
                TourPackage::updateOrCreate(
                    ['slug' => 'dubai-abu-dhabi-luxury-escape'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Dubai & Abu Dhabi Luxury Escape',
                        'subtitle' => 'Burj Khalifa 148th Floor, Desert Safari & Sheikh Zayed Mosque',
                        'category' => 'luxury-escapes',
                        'price' => null,
                        'duration_days' => 5,
                        'duration_nights' => 4,
                        'badge' => 'Luxury City Escape',
                        'main_image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Experience 5-star Arabian hospitality, VIP desert safaris, and high-tech skyscraper observations.',
                        'inclusions' => ['5-Star Luxury Marina Hotel', 'VIP Private Desert Safari', 'Burj Khalifa Fast-Track Pass', 'Private Transfers'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            } elseif ($dest->slug === 'maldives-paradise') {
                TourPackage::updateOrCreate(
                    ['slug' => 'maldives-luxury-overwater-escape'],
                    [
                        'destination_id' => $dest->id,
                        'title' => 'Maldives Luxury Overwater Escape',
                        'subtitle' => 'Private Ocean Bungalow, Manta Ray Snorkeling & All-Inclusive Dining',
                        'category' => 'luxury-escapes',
                        'price' => null,
                        'duration_days' => 5,
                        'duration_nights' => 4,
                        'badge' => 'Overwater Bungalow',
                        'main_image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
                        'overview' => 'Pure tropical luxury with direct lagoon access, private infinity pool, and gourmet dining.',
                        'inclusions' => ['Water Villa Stay', 'Seaplane Airport Transfers', 'All-Inclusive Meals & Drinks', 'Sunset Dolphin Cruise'],
                        'is_featured' => true,
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            }
        }
    }
}
