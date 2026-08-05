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
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($dest) {
                return [
                    'id' => $dest->id,
                    'name' => $dest->name,
                    'subtitle' => $dest->subtitle,
                    'packagesCount' => $dest->packages()->count() . ' Packages',
                    'image' => $dest->image,
                    'badge' => $dest->badge,
                    'slug' => $dest->slug,
                    'type' => $dest->type,
                ];
            });

        // Featured Tour Packages Grid
        $featuredPackages = TourPackage::with('destination')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($pkg) {
                return [
                    'id' => $pkg->id,
                    'title' => $pkg->title,
                    'slug' => $pkg->slug,
                    'subtitle' => $pkg->subtitle,
                    'category' => $pkg->category,
                    'price' => $pkg->price !== null ? (float) $pkg->price : null,
                    'duration' => $pkg->duration_days . ' Days / ' . $pkg->duration_nights . ' Nights',
                    'badge' => $pkg->badge ?? ($pkg->destination ? $pkg->destination->name : 'Special Tour'),
                    'image' => $pkg->main_image,
                    'overview' => $pkg->overview,
                    'inclusions' => $pkg->inclusions,
                ];
            });

        return Inertia::render('Frontend/Pages/Home/index', [
            'dbGlimpseDestinations' => $glimpseDestinations,
            'dbFeaturedPackages' => $featuredPackages,
        ]);
    }
}
