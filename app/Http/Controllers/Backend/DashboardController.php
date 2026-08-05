<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\PackageItineraryDay;
use App\Models\User;
use App\Models\ContactSetting;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the Executive Admin Dashboard with real database statistics & metrics.
     */
    public function index(): Response
    {
        // Real Counts & Analytics
        $totalDestinations = Destination::count();
        $inboundCount = Destination::where('type', 'inbound')->count();
        $outboundCount = Destination::where('type', 'outbound')->count();

        $totalPackages = TourPackage::count();
        $activePackages = TourPackage::where('is_active', true)->count();
        $featuredPackages = TourPackage::where('is_featured', true)->count();
        $avgPackagePrice = TourPackage::where('is_active', true)->avg('price') ?: 0;

        $totalItineraryDays = PackageItineraryDay::count();
        $totalAdminUsers = User::count();
        $contactSettingsConfigured = ContactSetting::exists();

        // Real Recent Packages from DB
        $recentPackages = TourPackage::with('destination')
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($package) {
                return [
                    'id' => $package->id,
                    'title' => $package->title,
                    'slug' => $package->slug,
                    'destination' => $package->destination ? $package->destination->name : 'N/A',
                    'category' => $package->category,
                    'duration' => "{$package->duration_days} Days / {$package->duration_nights} Nights",
                    'price' => '$' . number_format($package->price, 0),
                    'is_featured' => $package->is_featured,
                    'is_active' => $package->is_active,
                    'created_at' => $package->created_at->format('M d, Y'),
                ];
            });

        // Real Destinations Breakdown
        $destinationsSummary = Destination::withCount('packages')
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($dest) {
                return [
                    'id' => $dest->id,
                    'name' => $dest->name,
                    'type' => ucfirst($dest->type),
                    'badge' => $dest->badge ?: ($dest->type === 'inbound' ? 'Inbound' : 'Global'),
                    'packages_count' => $dest->packages_count,
                    'is_glimpse' => $dest->is_glimpse,
                    'is_active' => $dest->is_active,
                ];
            });

        return Inertia::render('Backend/Pages/Dashboard', [
            'stats' => [
                'totalDestinations' => $totalDestinations,
                'inboundCount' => $inboundCount,
                'outboundCount' => $outboundCount,
                'totalPackages' => $totalPackages,
                'activePackages' => $activePackages,
                'featuredPackages' => $featuredPackages,
                'avgPackagePrice' => '$' . number_format($avgPackagePrice, 0),
                'totalItineraryDays' => $totalItineraryDays,
                'totalAdminUsers' => $totalAdminUsers,
                'contactSettingsConfigured' => $contactSettingsConfigured,
            ],
            'recentPackages' => $recentPackages,
            'destinationsSummary' => $destinationsSummary,
        ]);
    }
}
