<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ServicesController extends Controller
{
    /**
     * Display the Frontend Services Page.
     */
    public function index(): Response
    {
        $services = [
            [
                'id' => 'airline-ticketing',
                'title' => 'AIRLINE TICKETING & RESERVATIONS',
                'category' => 'Flights & Airfare',
                'icon' => 'plane',
                'summary' => 'Best competitive airfares across 100+ major global airlines with instant ticketing and date modification support.',
                'description' => 'Worldine Destinations provides seamless international and domestic flight ticketing. Whether you are traveling for business, leisure, or family visits, our ticketing specialists negotiate exclusive fares with leading airlines including Emirates, Qatar Airways, Singapore Airlines, SriLankan Airlines, and Etihad Airways.',
                'features' => [
                    'International & Domestic flight bookings at lowest available rates',
                    '24/7 flight reissuance, date changes, and routing modifications',
                    'Special seat selection, meal preferences, and extra baggage requests',
                    'Corporate travel management & group flight discounts'
                ]
            ],
            [
                'id' => 'holidays-packages',
                'title' => 'HOLIDAYS PACKAGES',
                'category' => 'Inbound & Outbound',
                'icon' => 'compass',
                'summary' => 'Handcrafted tailor-made Sri Lanka inbound tours and exotic global outbound vacation packages.',
                'description' => 'From misty hill country tea estates in Sri Lanka to overwater villas in the Maldives and romantic European getaways, our holiday experts design personalized travel itineraries that match your exact budget and style.',
                'features' => [
                    'Custom Sri Lanka heritage, beach, wildlife, and adventure itineraries',
                    'Outbound holiday packages for Maldives, Dubai, Europe, Japan, & Asia',
                    'Private air-conditioned transport with English-speaking chauffeur guides',
                    'Flexibility to customize accommodation levels (3-Star to 5-Star Luxury)'
                ]
            ],
            [
                'id' => 'worldwide-hotel-reservations',
                'title' => 'WORLDWIDE HOTEL RESERVATIONS',
                'category' => 'Stays & Luxury Resorts',
                'icon' => 'building',
                'summary' => 'Direct partnerships with over 500,000 hotels, boutique villas, and luxury resorts around the globe.',
                'description' => 'Enjoy preferential rates and VIP benefits at world-renowned hotel chains and private boutique retreats. Our global hotel desk secures instant vouchers, late check-outs, and complimentary room upgrades whenever available.',
                'features' => [
                    'Guaranteed lowest room rates across 500,000+ global properties',
                    'Luxury overwater bungalows, heritage manors, and budget boutique stays',
                    'Instant booking voucher generation with flexible cancellation options',
                    'Group booking rates for weddings, conferences, and corporate retreats'
                ]
            ],
            [
                'id' => 'visa-assistance',
                'title' => 'VISA ASSISTANCE',
                'category' => 'Travel Documentation',
                'icon' => 'passport',
                'summary' => 'Expert visa guidance and document preparation with 98%+ approval success rate for global destinations.',
                'description' => 'Navigating international visa requirements can be complex. Our dedicated visa consultants guide you step-by-step through Schengen Europe, UK, USA, Japan, Australia, UAE, and Asian visa applications with complete document verification.',
                'features' => [
                    'Comprehensive document verification & personalized checklist',
                    'VFS / Embassy appointment booking and biometrics scheduling',
                    'Professional cover letter drafting & flight/hotel itinerary confirmation',
                    'High approval success rate for tourist, business, and transit visas'
                ]
            ],
            [
                'id' => 'travel-insurance',
                'title' => 'TRAVEL INSURANCE',
                'category' => 'Safety & Protection',
                'icon' => 'shield',
                'summary' => 'Comprehensive overseas travel insurance protecting against medical emergencies, flight delays, and lost luggage.',
                'description' => 'Travel with complete peace of mind. Our travel insurance policies are embassy-approved for Schengen visa applications and cover overseas medical treatment, emergency hospital admission, flight cancellations, and baggage loss.',
                'features' => [
                    'Embassy-approved Schengen and worldwide medical cover up to $100,000+',
                    'Coverage for baggage loss, passport theft, and travel delays',
                    '24/7 global emergency hotline support for immediate claims assistance',
                    'Individual, family, and annual multi-trip policy options'
                ]
            ],
            [
                'id' => 'health-insurance',
                'title' => 'HEALTH INSURANCE',
                'category' => 'Medical & Expat',
                'icon' => 'heart',
                'summary' => 'Specialized international health insurance for long-term travelers, ex-pats, and international students.',
                'description' => 'Safeguard your health overseas with flexible international medical policies. We partner with leading global underwriters to provide comprehensive inpatient, outpatient, and emergency medical evacuation insurance.',
                'features' => [
                    'Inpatient hospital stay & emergency surgical procedure coverage',
                    'Outpatient consultations, diagnostic tests, and prescription medicines',
                    'Worldwide hospital network access with cashless direct billing',
                    'Tailored plans for long-term overseas stays and working professionals'
                ]
            ],
            [
                'id' => 'cruise-packages',
                'title' => 'CRUISE PACKAGES',
                'category' => 'Ocean & River Cruises',
                'icon' => 'ship',
                'summary' => 'Luxury ocean liners and scenic river cruise voyages across Europe, the Caribbean, Singapore, and Alaska.',
                'description' => 'Set sail on unforgettable sea voyages with top-tier cruise operators including Royal Caribbean, MSC, Costa Cruises, and Celebrity Cruises. Experience fine dining, Broadway-style shows, and thrilling port excursions.',
                'features' => [
                    'Singapore & South East Asia 3-7 night island cruising',
                    'Mediterranean & European river cruises with guided shore tours',
                    'All-inclusive ocean cabin suites, gourmet meals, & onboard entertainment',
                    'Special honeymoon & anniversary cruise packages with VIP perks'
                ]
            ],
            [
                'id' => 'student-visa-consultation',
                'title' => 'STUDENT VISA CONSULTATION',
                'category' => 'Higher Education',
                'icon' => 'academic',
                'summary' => 'Dedicated educational visa counseling and university admission assistance for global study destinations.',
                'description' => 'Turn your overseas study ambitions into reality. Our education specialists provide end-to-end guidance for students applying to accredited universities in the UK, Australia, Canada, USA, New Zealand, and Europe.',
                'features' => [
                    'University course selection & admission application submission',
                    'Student visa financial documentation & sponsor file auditing',
                    'Pre-departure orientation, health cover setup, & flight booking',
                    'Student accommodation guidance and airport pickup coordination'
                ]
            ]
        ];

        return Inertia::render('Frontend/Pages/Services/Index', [
            'services' => $services,
        ]);
    }
}
