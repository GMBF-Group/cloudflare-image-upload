
<?php

return [
    'api_token' => env('CLOUDFLARE_API_TOKEN'),
    'id_account' => env('CLOUDFLARE_ACCOUNT_ID'),
    'key'          => env('CLOUDFLARE_IMAGES_KEY', null),
	'delivery_url' => env('CLOUDFLARE_IMAGES_DELIVERY_URL', null),
	'variant'      => env('CLOUDFLARE_IMAGES_DEFAULT_VARIATION', null)
];