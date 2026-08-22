<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mail:test {to?}', function ($to = null) {
    $recipient = $to ?: config('mail.from.address') ?: 'naveenpunchihewa9@gmail.com';
    
    $this->info("--- Testing Mail Configuration ---");
    $this->line("Mailer: " . config('mail.default'));
    $this->line("Host: " . config('mail.mailers.smtp.host'));
    $this->line("Port: " . config('mail.mailers.smtp.port'));
    $this->line("Encryption: " . (config('mail.mailers.smtp.encryption') ?: 'none / tls'));
    $this->line("Username: " . config('mail.mailers.smtp.username'));
    $this->line("From: " . config('mail.from.address') . ' <' . config('mail.from.name') . '>');
    $this->line("Sending test email to: " . $recipient);
    $this->newLine();

    $smtpPassed = false;
    try {
        \Illuminate\Support\Facades\Mail::raw("This is a live test email from Worldine Destinations (" . config('app.url') . ") sent at " . now()->toDateTimeString(), function ($message) use ($recipient) {
            $message->to($recipient)
                    ->subject('Worldine Destinations - SMTP Live Test');
        });

        $this->info("✓ Success! Test email was successfully accepted by SMTP server and delivered to {$recipient}");
        $smtpPassed = true;
    } catch (\Throwable $e) {
        $this->error("✕ SMTP Mail sending failed!");
        $this->error("Error Message: " . $e->getMessage());
        $this->newLine();
    }

    if (!$smtpPassed) {
        $this->warn("--- Testing Brevo REST API Fallback (HTTPS Port 443) ---");
        $html = "<p>This is a live test email sent via <strong>Brevo HTTPS REST API</strong> (Port 443) from Worldine Destinations at " . now()->toDateTimeString() . "</p>";
        $apiSuccess = \App\Services\BrevoMailerService::sendViaBrevoApi($recipient, 'Worldine Destinations - Brevo HTTPS API Test', $html);
        if ($apiSuccess) {
            $this->info("✓ Success! Test email was successfully delivered via Brevo HTTPS REST API (Port 443) to {$recipient}");
        } else {
            $this->error("✕ Brevo REST API also failed. Please check your Brevo API key and verified sender email in .env or storage/logs/laravel.log.");
        }
    }
})->purpose('Send a test email via configured SMTP or Brevo API to verify live server settings');
