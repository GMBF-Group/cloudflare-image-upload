<?php

namespace Gmbf\CloudflareImageUpload\Facades;

use Illuminate\Support\Facades\Facade;

class CloudflareImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cloudflare.image';
    }
}
