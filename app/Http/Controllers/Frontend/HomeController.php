<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        // Glimpse Carousel destinations
        $glimpseDestinations = Destination::where('is_active', true)
            ->where('is_glimpse', true)
            ->withCount('packages')
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($dest) {
                return [
                    'id' => $dest->id,
                    'name' => $dest->name,
                    'subtitle' => $dest->subtitle,
                    'packagesCount' => ($dest->packages_count ?? 0) . ' Packages',
                    'image' => $dest->image,
                    'badge' => $dest->badge,
                    'slug' => $dest->slug,
                    'type' => $dest->type,
                ];
            });

        // Featured Tour Packages Grid
        $featuredPackages = TourPackage::with(['destination', 'itineraryDays'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($pkg) {
                return [
                    'id' => $pkg->id,
                    'title' => $pkg->title,
                    'slug' => $pkg->slug,
                    'subtitle' => $pkg->subtitle,
                    'category' => $pkg->category,
                    'price' => $pkg->price !== null ? (float) $pkg->price : null,
                    'duration' => $pkg->duration_days . ' Days' . ($pkg->duration_nights ? ' / ' . $pkg->duration_nights . ' Nights' : ''),
                    'duration_days' => $pkg->duration_days,
                    'duration_nights' => $pkg->duration_nights,
                    'badge' => $pkg->badge ?: ($pkg->destination ? $pkg->destination->name : 'Worldine Tour'),
                    'image' => $pkg->main_image ?: '/images/Logo/worldineback.png',
                    'overview' => $pkg->overview,
                    'inclusions' => is_array($pkg->inclusions) ? $pkg->inclusions : ($pkg->inclusions ? json_decode($pkg->inclusions, true) : []),
                    'is_featured' => (bool) $pkg->is_featured,
                    'destination' => $pkg->destination ? [
                        'id' => $pkg->destination->id,
                        'name' => $pkg->destination->name,
                        'slug' => $pkg->destination->slug,
                        'type' => $pkg->destination->type,
                    ] : null,
                    'itinerary_days' => $pkg->itineraryDays,
                ];
            });

        return Inertia::render('Frontend/Pages/Home/index', [
            'dbGlimpseDestinations' => $glimpseDestinations,
            'dbFeaturedPackages' => $featuredPackages,
        ]);
    }
}
