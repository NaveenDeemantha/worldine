<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\PackageItineraryDay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends Controller
{
    /**
     * Display Dedicated Admin Destinations & Carousel Management
     */
    public function index(): Response
    {
        $destinations = Destination::with(['packages'])->orderBy('sort_order')->get();

        return Inertia::render('Backend/Pages/Destinations/Index', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * Display Dedicated Tour Packages Management Page
     */
    public function indexPackages(): Response
    {
        $destinations = Destination::orderBy('sort_order')->get();
        $packages = TourPackage::with(['destination', 'itineraryDays'])->orderBy('sort_order')->get();

        return Inertia::render('Backend/Pages/Packages/Index', [
            'destinations' => $destinations,
            'packages' => $packages,
        ]);
    }

    /**
     * Display Dedicated Day-by-Day Itineraries Builder Page
     */
    public function indexItineraries(): Response
    {
        $packages = TourPackage::with(['destination', 'itineraryDays'])->orderBy('sort_order')->get();

        return Inertia::render('Backend/Pages/Itineraries/Index', [
            'packages' => $packages,
        ]);
    }

    /**
     * Display Dedicated Customer Bookings & Inquiry Leads Page
     */
    public function indexBookings(): Response
    {
        // Sample dynamic bookings data for inquiries
        $bookings = [
            [
                'id' => 'WRD-8021',
                'customer_name' => 'Alexander Wright',
                'email' => 'alex.w@gmail.com',
                'phone' => '+1 (555) 234-5678',
                'package_title' => 'Heritage & Cultural Tour Sri Lanka',
                'travel_date' => '2026-08-15',
                'guests' => 2,
                'status' => 'Confirmed',
                'created_at' => '2 hours ago',
            ],
            [
                'id' => 'WRD-8022',
                'customer_name' => 'Sophia Chen',
                'email' => 'sophia.c@outlook.com',
                'phone' => '+44 7700 900077',
                'package_title' => 'Maldives Luxury Overwater Escape',
                'travel_date' => '2026-09-02',
                'guests' => 2,
                'status' => 'Pending Quote',
                'created_at' => '5 hours ago',
            ],
            [
                'id' => 'WRD-8023',
                'customer_name' => 'Marcus Vance',
                'email' => 'marcus.v@yahoo.com',
                'phone' => '+61 491 570 156',
                'package_title' => 'East Asia Cultural Discovery - Japan',
                'travel_date' => '2026-08-20',
                'guests' => 4,
                'status' => 'Confirmed',
                'created_at' => '1 day ago',
            ],
        ];

        return Inertia::render('Backend/Pages/Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Store a newly created Destination
     */
    public function storeDestination(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:inbound,outbound',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'is_glimpse' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Destination::create($validated);

        return redirect()->back()->with('success', 'Destination created successfully!');
    }

    /**
     * Update an existing Destination
     */
    public function updateDestination(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:inbound,outbound',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'badge' => 'nullable|string|max:255',
            'is_glimpse' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $destination->update($validated);

        return redirect()->back()->with('success', 'Destination updated successfully!');
    }

    /**
     * Delete a Destination
     */
    public function destroyDestination(Destination $destination)
    {
        $destination->delete();
        return redirect()->back()->with('success', 'Destination deleted successfully!');
    }

    /**
     * Store or Update a Tour Package with Itinerary Days
     */
    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:tour_packages,id',
            'destination_id' => 'required|exists:destinations,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'nullable|integer|min:0',
            'badge' => 'nullable|string|max:255',
            'main_image' => 'nullable|string',
            'overview' => 'nullable|string',
            'inclusions' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'days' => 'nullable|array',
            'days.*.day_number' => 'required|integer',
            'days.*.title' => 'required|string|max:255',
            'days.*.description' => 'nullable|string',
            'days.*.image' => 'nullable|string',
            'days.*.accommodation' => 'nullable|string',
            'days.*.meals' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $days = $validated['days'] ?? [];
        unset($validated['days']);

        if (!empty($validated['id'])) {
            $package = TourPackage::findOrFail($validated['id']);
            $package->update($validated);
        } else {
            $package = TourPackage::create($validated);
        }

        // Sync itinerary days if provided
        if ($request->has('days')) {
            $package->itineraryDays()->delete();
            foreach ($days as $dayData) {
                $package->itineraryDays()->create($dayData);
            }
        }

        return redirect()->back()->with('success', 'Tour Package saved successfully!');
    }

    /**
     * Delete a Tour Package
     */
    public function destroyPackage(TourPackage $package)
    {
        $package->delete();
        return redirect()->back()->with('success', 'Tour Package deleted successfully!');
    }
}
