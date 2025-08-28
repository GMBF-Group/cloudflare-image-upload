<?php

namespace Gmbf\CloudflareImageUpload;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class CloudflareImageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/cloudflare-image.php',
            'cloudflare-image'
        );

        $this->app->singleton(CloudflareImageService::class, function ($app) {
            return new CloudflareImageService(
                $app['config']['cloudflare-image.api_token'],
                $app['config']['cloudflare-image.account_id'],
                new Client()
            );
        });

        $this->app->alias(CloudflareImageService::class, 'cloudflare.image');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/cloudflare-image.php' => config_path('cloudflare-image.php'),
        ], 'config');
    }
}
