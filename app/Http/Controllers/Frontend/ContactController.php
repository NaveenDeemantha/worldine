<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * Display the Contact Us page with dynamic settings from Database.
     */
    public function index(): Response
    {
        $settings = ContactSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_badge' => '24/7 DEDICATED CONCIERGE & SUPPORT',
                'hero_title' => 'Contact Worldine Destinations',
                'hero_subtitle' => 'Have a question about a tour package, visa processing, custom Sri Lanka itinerary, or corporate trip? Our team of travel experts is ready to assist you.',
                'landline_phone' => '+94 11 263 6558',
                'primary_phone' => '+94 766 834 881',
                'outbound_phone' => '+94 718 834 881',
                'inbound_phone' => '+94 778 692 229',
                'primary_email' => 'info@worldinedestinations.com',
                'tours_email' => 'tours@worldinedestinations.com',
                'office_address' => 'Worldine Destinations (Pvt) Ltd, Galle Road, Colombo 03, Sri Lanka.',
                'office_hours_weekday' => '8:30 AM – 6:30 PM',
                'office_hours_saturday' => '9:00 AM – 4:00 PM',
                'office_hours_sunday' => '24/7 On-Call Support',
                'google_maps_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798485292415!2d79.848888!3d6.914722!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2594000000001%3A0x0!2zNsKwNTQnNTMuMCJOIDc5wrA1MCc1Ni4wIkU!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk',
                'form_title' => 'Send Us A Message',
                'form_subtitle' => 'Complete the inquiry form and our travel experts will curate a personalized itinerary, flight options, or visa guidance tailored to your budget.',
            ]
        );

        return Inertia::render('Frontend/Pages/Contact/Index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Handle incoming contact / inquiry form submissions.
     */
    public function sendInquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'inquiry_type' => 'nullable|string',
            'destination' => 'nullable|string|max:255',
            'travel_dates' => 'nullable|string|max:255',
            'travelers' => 'nullable|string|max:50',
            'message' => 'nullable|string',
        ]);

        Inquiry::create([
            'reference_id' => 'WRD-' . rand(1000, 9999),
            'type' => 'general_contact',
            'customer_name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'inquiry_type' => $validated['inquiry_type'] ?? 'General Contact',
            'destination_name' => $validated['destination'] ?? null,
            'travel_date' => $validated['travel_dates'] ?? null,
            'guests' => (int)($validated['travelers'] ?? 1),
            'message' => $validated['message'] ?? null,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Thank you! Your inquiry has been received. Our travel concierge will reach out to you within 2 hours.');
    }
}
