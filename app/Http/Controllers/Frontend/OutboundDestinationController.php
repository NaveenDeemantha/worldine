<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use Inertia\Inertia;
use Inertia\Response;

class OutboundDestinationController extends Controller
{
    public function index(): Response
    {
        $outboundDestinations = Destination::where('type', 'outbound')
            ->where('is_active', true)
            ->with(['packages' => function ($q) {
                $q->where('is_active', true)->with('itineraryDays');
            }])
            ->orderBy('sort_order')
            ->get();

        $outboundPackages = TourPackage::with(['destination', 'itineraryDays'])
            ->where('is_active', true)
            ->where('category', '!=', 'srilanka-inbound')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Frontend/Pages/Destinations/Index', [
            'destinations' => $outboundDestinations,
            'packages' => $outboundPackages,
        ]);
    }
}
