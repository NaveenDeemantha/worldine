<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $navDestinations = [];
        $navInboundPackages = [];

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('destinations')) {
                $navDestinations = \App\Models\Destination::where('is_active', true)
                    ->where('type', 'outbound')
                    ->orderBy('name', 'asc')
                    ->get(['id', 'name', 'slug', 'type']);
            }
            if (\Illuminate\Support\Facades\Schema::hasTable('tour_packages')) {
                $navInboundPackages = \App\Models\TourPackage::where('is_active', true)
                    ->where(function ($q) {
                        $q->where('category', 'srilanka-inbound')
                          ->orWhereHas('destination', function ($dq) {
                              $dq->where('type', 'inbound');
                          });
                    })
                    ->orderBy('title', 'asc')
                    ->get(['id', 'title', 'slug']);
            }
        } catch (\Throwable $e) {
            // Gracefully ignore database connection or schema errors before migration
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'navDestinations' => $navDestinations,
            'navInboundPackages' => $navInboundPackages,
        ];
    }
}
