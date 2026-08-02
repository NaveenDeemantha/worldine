<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use Inertia\Inertia;
use Inertia\Response;

class SriLankaController extends Controller
{
    public function index(): Response
    {
        $inboundDestination = Destination::where('type', 'inbound')
            ->where('is_active', true)
            ->first();

        $inboundPackages = TourPackage::with(['destination', 'itineraryDays'])
            ->where('is_active', true)
            ->where('category', 'srilanka-inbound')
            ->orderBy('sort_order')
            ->get();

        return Inertia::render('Frontend/Pages/SriLanka/Index', [
            'destination' => $inboundDestination,
            'packages' => $inboundPackages,
        ]);
    }
}
