<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\TourPackage;
use App\Models\PackageItineraryDay;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\ContactSetting;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the Executive Admin Dashboard with real database statistics & inquiries.
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

        // Inquiries Metrics & Real Lists from DB
        $packageInquiries = Inquiry::where('type', 'package_inquiry')
            ->latest()
            ->get()
            ->map(function ($inq) {
                return [
                    'id' => $inq->reference_id,
                    'db_id' => $inq->id,
                    'customer_name' => $inq->customer_name,
                    'email' => $inq->email,
                    'phone' => $inq->phone,
                    'package_title' => $inq->package_title ?: 'Tour Package Inquiry',
                    'travel_date' => $inq->travel_date ?: 'Flexible',
                    'guests' => $inq->guests,
                    'status' => $inq->status,
                    'message' => $inq->message,
                    'created_at' => $inq->created_at ? $inq->created_at->format('M d, Y') : 'Recent',
                ];
            });

        $contactInquiries = Inquiry::where('type', 'general_contact')
            ->latest()
            ->get()
            ->map(function ($inq) {
                return [
                    'id' => $inq->reference_id,
                    'db_id' => $inq->id,
                    'customer_name' => $inq->customer_name,
                    'email' => $inq->email,
                    'phone' => $inq->phone,
                    'destination' => $inq->destination_name ?: 'General Inquiry',
                    'inquiry_type' => $inq->inquiry_type ?: 'General Contact',
                    'travel_date' => $inq->travel_date ?: 'N/A',
                    'guests' => $inq->guests,
                    'status' => $inq->status,
                    'message' => $inq->message,
                    'created_at' => $inq->created_at ? $inq->created_at->format('M d, Y') : 'Recent',
                ];
            });

        $totalPackageInquiries = Inquiry::where('type', 'package_inquiry')->count();
        $totalContactInquiries = Inquiry::where('type', 'general_contact')->count();
        $pendingInquiriesCount = Inquiry::where('status', 'Pending')->count();

        // Real Recent Packages from DB
        $recentPackages = TourPackage::with(['destination', 'itineraryDays'])
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
                    'duration' => ($package->itineraryDays && $package->itineraryDays->count() > 0 ? $package->itineraryDays->count() . ' Days' : $package->duration_days . ' Days'),
                    'price' => ($package->price && (float)$package->price > 0 ? '$' . number_format($package->price, 0) : 'On Request'),
                    'is_featured' => $package->is_featured,
                    'is_active' => $package->is_active,
                    'created_at' => $package->created_at ? $package->created_at->format('M d, Y') : 'Recent',
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
                'totalPackageInquiries' => $totalPackageInquiries,
                'totalContactInquiries' => $totalContactInquiries,
                'pendingInquiriesCount' => $pendingInquiriesCount,
            ],
            'packageInquiries' => $packageInquiries,
            'contactInquiries' => $contactInquiries,
            'recentPackages' => $recentPackages,
            'destinationsSummary' => $destinationsSummary,
        ]);
    }
}
