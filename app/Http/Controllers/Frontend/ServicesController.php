<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ServicesController extends Controller
{
    /**
     * Display the Frontend Services Page with Core and Value-Added Services.
     */
    public function index(): Response
    {
        $coreServices = [
            [
                'id' => 'airline-ticketing',
                'title' => 'Air Line Ticketing',
                'slug' => 'Air Line Ticketing',
                'icon' => 'plane',
            ],
            [
                'id' => 'worldwide-hotel-reservations',
                'title' => 'World Wide Hotel Reservations',
                'slug' => 'World Wide Hotel Reservations',
                'icon' => 'building',
            ],
            [
                'id' => 'custom-holiday-packages',
                'title' => 'Custom made holiday packages around the world',
                'slug' => 'Custom made holiday packages around the world',
                'icon' => 'compass',
            ],
            [
                'id' => 'sightseeing-tours',
                'title' => 'Sightseeing Tours',
                'slug' => 'Sightseeing Tours',
                'icon' => 'camera',
            ],
            [
                'id' => 'constructing-itineraries',
                'title' => 'Constructing of Itineraries',
                'slug' => 'Constructing of Itineraries',
                'icon' => 'map',
            ],
            [
                'id' => 'air-conditioned-coaches',
                'title' => 'Transport in comfortable air-conditioned coaches',
                'slug' => 'Transport in comfortable air-conditioned coaches',
                'icon' => 'bus',
            ],
            [
                'id' => 'multilingual-guides',
                'title' => 'Services of multilingual guides',
                'slug' => 'Services of multilingual guides',
                'icon' => 'users',
            ],
            [
                'id' => 'airport-pick-up-drop',
                'title' => 'Airport pick up/ Drop Services',
                'slug' => 'Airport pick up/ Drop Services',
                'icon' => 'car',
            ],
        ];

        $valueAddedServices = [
            [
                'id' => 'visa-submission-guidance',
                'title' => 'Visa Submission & Guidance',
                'slug' => 'Visa Submission & Guidance',
                'icon' => 'passport',
            ],
            [
                'id' => 'online-check-in-assistance',
                'title' => 'Online-Check in assistance',
                'slug' => 'Online-Check in assistance',
                'icon' => 'check-circle',
            ],
            [
                'id' => 'travel-insurance',
                'title' => 'Travel Insurance',
                'slug' => 'Travel Insurance',
                'icon' => 'shield',
            ],
            [
                'id' => 'foreign-currency',
                'title' => 'Foreign Currency',
                'slug' => 'Foreign Currency',
                'icon' => 'banknotes',
            ],
            [
                'id' => 'frequent-flyer-programmes',
                'title' => 'Enrollment of passengers on Airline frequent flyer programmes',
                'slug' => 'Enrollment of passengers on Airline frequent flyer programmes',
                'icon' => 'award',
            ],
        ];

        return Inertia::render('Frontend/Pages/Services/Index', [
            'coreServices' => $coreServices,
            'valueAddedServices' => $valueAddedServices,
        ]);
    }
}
