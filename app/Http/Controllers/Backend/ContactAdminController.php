<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactAdminController extends Controller
{
    /**
     * Display Contact Page Content Management Settings in Admin Panel
     */
    public function index(): Response
    {
        $settings = ContactSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_badge' => '24/7 DEDICATED CONCIERGE & SUPPORT',
                'hero_title' => 'Contact Worldine Destinations',
                'hero_subtitle' => 'Have a question about a tour package, visa processing, custom Sri Lanka itinerary, or corporate trip? Our team of travel experts is ready to assist you.',
                'primary_phone' => '+94 766 834 881',
                'outbound_phone' => '+94 718 834 881',
                'inbound_phone' => '+94 778 869 222',
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

        return Inertia::render('Backend/Pages/Contact/Index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update Contact Page Settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'required|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'primary_phone' => 'required|string|max:50',
            'outbound_phone' => 'required|string|max:50',
            'inbound_phone' => 'required|string|max:50',
            'primary_email' => 'required|email|max:255',
            'tours_email' => 'required|email|max:255',
            'office_address' => 'required|string',
            'office_hours_weekday' => 'required|string|max:100',
            'office_hours_saturday' => 'required|string|max:100',
            'office_hours_sunday' => 'required|string|max:100',
            'google_maps_url' => 'nullable|string',
            'form_title' => 'required|string|max:255',
            'form_subtitle' => 'required|string',
        ]);

        $settings = ContactSetting::firstOrCreate(['id' => 1]);
        $settings->update($validated);

        return back()->with('success', 'Contact page content successfully updated!');
    }
}
