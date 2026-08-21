<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|string|max:1000',
            'text' => 'required|string|max:2000',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'location' => $validated['location'] ?? 'Explorer',
            'destination' => $validated['destination'] ?? 'Worldine Experience',
            'rating' => $validated['rating'],
            'avatar' => $validated['avatar'] ?: null,
            'text' => $validated['text'],
            'is_active' => true, // Enabled by default; admin can toggle show/hide anytime in Admin Dashboard
        ]);

        return back()->with('success', 'Thank you for sharing your story! Your experience has been published.');
    }
}
