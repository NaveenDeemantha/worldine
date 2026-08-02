<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
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
}
