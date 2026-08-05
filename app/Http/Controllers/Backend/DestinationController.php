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
        $destinations = Destination::with(['packages'])->orderBy('name', 'asc')->get();
        $packages = TourPackage::with(['destination', 'itineraryDays'])->orderBy('sort_order')->get();

        return Inertia::render('Backend/Pages/Destinations/Index', [
            'destinations' => $destinations,
            'packages' => $packages,
        ]);
    }

    /**
     * Display Dedicated Tour Packages Management Page
     */
    public function indexPackages(): Response
    {
        $destinations = Destination::orderBy('name', 'asc')->get();
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
        $bookings = \App\Models\Inquiry::latest()->get()->map(function ($inq) {
            return [
                'id' => $inq->reference_id,
                'db_id' => $inq->id,
                'type' => $inq->type === 'package_inquiry' ? 'Tour Package Booking' : 'Contact Form Lead',
                'customer_name' => $inq->customer_name,
                'email' => $inq->email,
                'phone' => $inq->phone,
                'package_title' => $inq->package_title ?: ($inq->destination_name ?: 'General Inquiry'),
                'inquiry_type' => $inq->inquiry_type ?: 'General Lead',
                'travel_date' => $inq->travel_date ?: 'Flexible',
                'guests' => $inq->guests,
                'message' => $inq->message,
                'status' => $inq->status,
                'created_at' => $inq->created_at ? $inq->created_at->diffForHumans() : 'Recent',
            ];
        });

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
            'image' => 'nullable',
            'badge' => 'nullable|string|max:255',
            'is_glimpse' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('images/destinations');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $filename);
            $validated['image'] = '/images/destinations/' . $filename;
        }

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
            'image' => 'nullable',
            'badge' => 'nullable|string|max:255',
            'is_glimpse' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $destPath = public_path('images/destinations');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }
            $file->move($destPath, $filename);
            $validated['image'] = '/images/destinations/' . $filename;
        }

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
            'main_image' => 'nullable',
            'overview' => 'nullable|string',
            'inclusions' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'days' => 'nullable|array',
            'days.*.day_number' => 'required|integer',
            'days.*.title' => 'required|string|max:255',
            'days.*.description' => 'nullable|string',
            'days.*.image' => 'nullable',
            'days.*.accommodation' => 'nullable|string',
            'days.*.meals' => 'nullable|string',
        ]);

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $pkgPath = public_path('images/packages');
            if (!file_exists($pkgPath)) {
                mkdir($pkgPath, 0755, true);
            }
            $file->move($pkgPath, $filename);
            $validated['main_image'] = '/images/packages/' . $filename;
        }

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
            foreach ($days as $index => $dayData) {
                if ($request->hasFile("days.{$index}.image")) {
                    $dayFile = $request->file("days.{$index}.image");
                    $dayFilename = time() . "_day_" . ($index + 1) . '_' . Str::slug($validated['title']) . '.' . $dayFile->getClientOriginalExtension();
                    $dayPath = public_path('images/packages');
                    if (!file_exists($dayPath)) {
                        mkdir($dayPath, 0755, true);
                    }
                    $dayFile->move($dayPath, $dayFilename);
                    $dayData['image'] = '/images/packages/' . $dayFilename;
                }
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
