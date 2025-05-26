<?php

namespace Gmbf\CloudflareImageUpload;

use Illuminate\Support\ServiceProvider;

class CloudflareImageUploadServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->make(CloudflareImageUploadController::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/cloudflareImage.php', 'cloudflareImage'
        );
    }

    public function boot(): void
    {
        include __DIR__ . '/routes.php';

        $this->loadViewsFrom(__DIR__.'/views', 'cloudflareImageUpload');

        $this->publishes([
            __DIR__ . '/../config/cloudflareImage.php' => config_path('cloudflareImage.php'),
        ], 'config');
    }
}
