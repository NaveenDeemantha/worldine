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

        // Fetch all active Sri Lanka Inbound packages directly from database
        $inboundPackages = TourPackage::with(['destination', 'itineraryDays'])
            ->where('is_active', true)
            ->where(function ($q) {
                $q->where('category', 'srilanka-inbound')
                  ->orWhereHas('destination', function ($dq) {
                      $dq->where('type', 'inbound');
                  });
            })
            ->orderBy('title', 'asc')
            ->get();

        return Inertia::render('Frontend/Pages/SriLanka/Index', [
            'destination' => $inboundDestination,
            'packages' => $inboundPackages,
        ]);
    }
}
