<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\PackageItineraryDay;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // 2. Clean & Seed Destinations Only (Tour Packages will be created manually by user)
        $destinationsData = [
            [
                'name' => 'Sri Lanka',
                'slug' => 'srilanka',
                'type' => 'inbound',
                'subtitle' => 'UNESCO Citadel Fortresses, Tea Estates, Wildlife Safaris & Gold Coast Beaches',
                'description' => 'Explore the wonder of Asia with over 20 years of local Sri Lankan travel trade expertise.',
                'image' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=1200&q=75',
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
                'subtitle' => 'Great Barrier Reef, Sydney Opera House & Coastal Highway Drives',
                'description' => 'Unforgettable Pacific ocean adventures, rainforests, and vibrant Australian coastal cities.',
                'image' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?auto=format&fit=crop&w=1200&q=75',
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
                'subtitle' => 'Tropical Island Villas, Rice Terraces & Sunset Cliff Temples',
                'description' => 'Experience the magic of Bali with luxury oceanfront villas, sacred temples, and coral reef diving.',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=1200&q=75',
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
                'subtitle' => 'Great Wall of China, Forbidden City & Bullet Train Expeditions',
                'description' => 'Explore thousands of years of imperial history, silk roads, modern skylines, and natural wonders.',
                'image' => 'https://images.unsplash.com/photo-1508804185872-d7badad00f7d?auto=format&fit=crop&w=1200&q=75',
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
                'subtitle' => 'Burj Khalifa, Desert Dunes & Marina Luxury Yacht Cruises',
                'description' => 'Ultra-modern luxury skyscrapers, 4x4 dune bashing, and high-end marina yachts.',
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=75',
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
                'image' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=1200&q=75',
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
                'subtitle' => 'Kyoto Zen Shrines, Mount Fuji Summit & Tokyo Shinkansen',
                'description' => 'Discover futuristic cities, ancient shrines, and cherry blossom avenues across Japan.',
                'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=1200&q=75',
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
                'subtitle' => 'Bangkok Grand Palace, Phuket Islands & Speedboat Lagoons',
                'description' => 'Immerse yourself in rich Thai hospitality, bustling night markets, island hopping, and serene temples.',
                'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?auto=format&fit=crop&w=1200&q=75',
                'badge' => 'Golden Land Escape',
                'is_glimpse' => true,
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        // Delete any outdated destinations not in this list
        $validSlugs = collect($destinationsData)->pluck('slug')->toArray();
        Destination::whereNotIn('slug', $validSlugs)->delete();

        foreach ($destinationsData as $destData) {
            Destination::updateOrCreate(['slug' => $destData['slug']], $destData);
        }

        // 3. Seed Default Real Traveller Stories
        $testimonials = [
            [
                'name' => 'Samantha & Richard Vance',
                'location' => 'London, UK',
                'destination' => 'Sri Lanka 8D7N Grand Heritage Tour',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
                'text' => 'Worldine Destinations made our Sri Lanka trip unforgettable! From our private chauffeur guide to the Sigiriya luxury hotel, every detail was handled with top-tier professionalism.',
                'is_active' => true,
            ],
            [
                'name' => 'Kasun & Dilini Wickramasinghe',
                'location' => 'Colombo, Sri Lanka',
                'destination' => 'Australia Sydney & Barrier Reef Tour',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'text' => 'Worldine guided us step-by-step through our Australia visa and holiday package. Their 20+ years of travel trade expertise truly shines!',
                'is_active' => true,
            ],
            [
                'name' => 'Hans & Greta Müller',
                'location' => 'Frankfurt, Germany',
                'destination' => 'Sri Lanka Wildlife & Safari Tour',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80',
                'text' => 'Seeing wild leopards in Yala and hundreds of elephants in Minneriya was magical! Worldine Destinations is definitely the best tour operator in Sri Lanka.',
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], $t);
        }
    }
}
