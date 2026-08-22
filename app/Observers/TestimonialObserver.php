<?php

namespace App\Observers;

use App\Mail\NewStoryNotification;
use App\Models\ContactSetting;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestimonialObserver
{
    /**
     * Handle the Testimonial "created" event.
     */
    public function created(Testimonial $testimonial): void
    {
        $contactSettings = null;
        try {
            $contactSettings = ContactSetting::find(1);
        } catch (\Throwable $e) {
            // fallback if database table is unavailable
        }

        $adminEmail = $contactSettings?->notification_email 
            ?: env('ADMIN_NOTIFICATION_EMAIL', config('mail.from.address', 'naveenpunchihewa9@gmail.com'));

        $ccEmails = [];
        if (!empty($contactSettings?->notification_cc_emails)) {
            $rawCcs = preg_split('/[,;]+/', $contactSettings->notification_cc_emails);
            foreach ($rawCcs as $rawCc) {
                $trimmed = trim($rawCc);
                if (filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
                    $ccEmails[] = $trimmed;
                }
            }
        }

        dispatch(function () use ($adminEmail, $ccEmails, $testimonial) {
            \App\Services\BrevoMailerService::sendStory($testimonial, $adminEmail, $ccEmails);
        })->afterResponse();
    }
}
