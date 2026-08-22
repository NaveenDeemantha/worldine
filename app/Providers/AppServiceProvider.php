<?php

namespace App\Providers;

use App\Models\Inquiry;
use App\Models\Testimonial;
use App\Observers\InquiryObserver;
use App\Observers\TestimonialObserver;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Inquiry::observe(InquiryObserver::class);
        Testimonial::observe(TestimonialObserver::class);
    }
}
