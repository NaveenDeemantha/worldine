<?php

namespace App\Services;

use App\Mail\NewInquiryNotification;
use App\Mail\NewStoryNotification;
use App\Models\Inquiry;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class BrevoMailerService
{
    /**
     * Send Inquiry Notification via SMTP with automatic Brevo REST API fallback over HTTPS (Port 443)
     */
    public static function sendInquiry(Inquiry $inquiry, string $adminEmail, array $ccEmails = []): void
    {
        $smtpSucceeded = false;

        // 1. Try Laravel standard SMTP Mail first
        try {
            $pendingMail = Mail::to($adminEmail);
            if (!empty($ccEmails)) {
                $pendingMail->cc($ccEmails);
            }
            $pendingMail->send(new NewInquiryNotification($inquiry));
            $smtpSucceeded = true;
            Log::info("Brevo SMTP: Inquiry notification email sent for {$inquiry->reference_id} to {$adminEmail}");
        } catch (\Throwable $e) {
            Log::warning("Brevo SMTP failed for inquiry {$inquiry->reference_id}: " . $e->getMessage() . " - Attempting Brevo HTTPS REST API fallback...");
        }

        // 2. If SMTP failed or timed out, fallback to Brevo HTTPS REST API (Port 443)
        if (!$smtpSucceeded) {
            self::sendInquiryViaApi($inquiry, $adminEmail, $ccEmails);
        }
    }

    /**
     * Send Traveller Story Notification via SMTP with automatic Brevo REST API fallback over HTTPS
     */
    public static function sendStory(Testimonial $testimonial, string $adminEmail, array $ccEmails = []): void
    {
        $smtpSucceeded = false;

        // 1. Try standard SMTP first
        try {
            $pendingMail = Mail::to($adminEmail);
            if (!empty($ccEmails)) {
                $pendingMail->cc($ccEmails);
            }
            $pendingMail->send(new NewStoryNotification($testimonial));
            $smtpSucceeded = true;
            Log::info("Brevo SMTP: Story notification email sent for {$testimonial->name} to {$adminEmail}");
        } catch (\Throwable $e) {
            Log::warning("Brevo SMTP failed for story {$testimonial->name}: " . $e->getMessage() . " - Attempting Brevo HTTPS REST API fallback...");
        }

        // 2. If SMTP failed, fallback to Brevo HTTPS REST API
        if (!$smtpSucceeded) {
            self::sendStoryViaApi($testimonial, $adminEmail, $ccEmails);
        }
    }

    /**
     * Send Inquiry via Brevo REST API (HTTPS port 443 - never blocked by VPS firewalls)
     */
    public static function sendInquiryViaApi(Inquiry $inquiry, string $adminEmail, array $ccEmails = []): bool
    {
        $apiKey = env('BREVO_API_KEY') ?: config('mail.mailers.smtp.password');
        if (empty($apiKey)) {
            Log::error("Brevo API: No API key found in BREVO_API_KEY or MAIL_PASSWORD.");
            return false;
        }

        $typeLabel = $inquiry->type === 'package_inquiry' ? 'New Booking Inquiry' : 'New Contact Lead';
        $ref = $inquiry->reference_id ?? 'WRD';
        $customer = $inquiry->customer_name ?? 'Guest';
        $subject = "[{$typeLabel}] {$ref} - {$customer}";

        $htmlContent = View::make('emails.new_inquiry', ['inquiry' => $inquiry])->render();

        return self::sendViaBrevoApi($adminEmail, $subject, $htmlContent, $ccEmails);
    }

    /**
     * Send Story via Brevo REST API (HTTPS port 443)
     */
    public static function sendStoryViaApi(Testimonial $testimonial, string $adminEmail, array $ccEmails = []): bool
    {
        $apiKey = env('BREVO_API_KEY') ?: config('mail.mailers.smtp.password');
        if (empty($apiKey)) {
            Log::error("Brevo API: No API key found in BREVO_API_KEY or MAIL_PASSWORD.");
            return false;
        }

        $subject = "[New Traveller Story] " . ($testimonial->title ?? 'New Story Submission') . " by " . ($testimonial->name ?? 'Guest');
        $htmlContent = View::make('emails.new_story', ['testimonial' => $testimonial])->render();

        return self::sendViaBrevoApi($adminEmail, $subject, $htmlContent, $ccEmails);
    }

    /**
     * Low-level Brevo REST API v3 sender
     */
    public static function sendViaBrevoApi(string $recipientEmail, string $subject, string $htmlContent, array $ccEmails = []): bool
    {
        $apiKey = env('BREVO_API_KEY') ?: config('mail.mailers.smtp.password');
        $senderEmail = config('mail.from.address') ?: env('MAIL_FROM_ADDRESS', 'info@worldinedestinations.com');
        $senderName = config('mail.from.name') ?: env('MAIL_FROM_NAME', 'Worldine Destinations');

        if (empty($apiKey)) {
            Log::error("Brevo API: Cannot send email via REST API. Missing API key.");
            return false;
        }

        $payload = [
            'sender' => [
                'name' => $senderName,
                'email' => $senderEmail,
            ],
            'to' => [
                ['email' => $recipientEmail]
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ];

        if (!empty($ccEmails)) {
            $payload['cc'] = array_map(function ($cc) {
                return ['email' => $cc];
            }, $ccEmails);
        }

        try {
            $response = Http::withHeaders([
                'api-key' => $apiKey,
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->timeout(10)->post('https://api.brevo.com/v3/smtp/email', $payload);

            if ($response->successful()) {
                Log::info("Brevo HTTPS API: Successfully delivered email '{$subject}' to {$recipientEmail} via Port 443! MessageId: " . ($response->json('messageId') ?? 'OK'));
                return true;
            } else {
                Log::error("Brevo HTTPS API Error: Status {$response->status()} - " . $response->body());
                return false;
            }
        } catch (\Throwable $e) {
            Log::error("Brevo HTTPS API Exception: " . $e->getMessage());
            return false;
        }
    }
}
