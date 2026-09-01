<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Services\ImageOptimizerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TestimonialAdminController extends Controller
{
    public function index(): Response
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();

        return Inertia::render('Backend/Pages/Testimonials/Index', [
            'testimonials' => $testimonials,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'avatar' => 'nullable|string|max:1000',
            'text' => 'required|string|max:2000',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['avatar'] = ImageOptimizerService::storeOptimized(
                $request->file('image'),
                'images/testimonials',
                $validated['name']
            );
        }

        unset($validated['image']);

        Testimonial::create($validated);

        return back()->with('success', 'Traveller story added successfully!');
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'avatar' => 'nullable|string|max:1000',
            'text' => 'required|string|max:2000',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['avatar'] = ImageOptimizerService::storeOptimized(
                $request->file('image'),
                'images/testimonials',
                $validated['name']
            );
        }

        unset($validated['image']);

        $testimonial->update($validated);

        return back()->with('success', 'Traveller story updated successfully!');
    }

    public function toggle(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update([
            'is_active' => !$testimonial->is_active,
        ]);

        $statusText = $testimonial->is_active ? 'visible on site' : 'hidden from site';
        return back()->with('success', "Traveller story is now {$statusText}.");
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return back()->with('success', 'Traveller story deleted successfully.');
    }
}
