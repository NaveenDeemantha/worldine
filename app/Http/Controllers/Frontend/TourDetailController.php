<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TourDetailController extends Controller
{
    public function show(string $slug): Response
    {
        $package = TourPackage::with(['destination', 'itineraryDays'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPackages = TourPackage::where('destination_id', $package->destination_id)
            ->where('id', '!=', $package->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return Inertia::render('Frontend/Pages/Tours/Show', [
            'package' => $package,
            'relatedPackages' => $relatedPackages,
        ]);
    }

    public function sendPackageInquiry(Request $request)
    {
        $validated = $request->validate([
            'tour_package_id' => 'nullable|exists:tour_packages,id',
            'package_title' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'travel_date' => 'nullable|string|max:255',
            'guests' => 'nullable|integer|min:1',
            'message' => 'nullable|string',
        ]);

        Inquiry::create([
            'reference_id' => 'WRD-' . rand(1000, 9999),
            'type' => 'package_inquiry',
            'customer_name' => $validated['customer_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'tour_package_id' => $validated['tour_package_id'] ?? null,
            'package_title' => $validated['package_title'],
            'travel_date' => $validated['travel_date'] ?? null,
            'guests' => (int)($validated['guests'] ?? 1),
            'inquiry_type' => 'Tour Package Booking',
            'message' => $validated['message'] ?? null,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Thank you! Your tour inquiry has been submitted. Our travel concierge will contact you shortly.');
    }
}
