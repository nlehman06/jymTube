<?php

namespace App\Providers;

use App\StreamingServices\FacebookService;
use App\StreamingServices\StreamingServiceInterface;
use Illuminate\Support\ServiceProvider;

class StreamingServiceProvider extends ServiceProvider {

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StreamingServiceInterface::class, FacebookService::class);
    }
}
