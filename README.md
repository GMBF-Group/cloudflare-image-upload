# Cloudflare Image Upload Package for Laravel

This Laravel package provides a simple and reusable interface for uploading, retrieving, and deleting images on **Cloudflare Images**.  
It is intended for use in Laravel applications to handle image storage through the Cloudflare Images API.

A reusable Laravel package to easily **upload, retrieve, and delete images** on **Cloudflare Images**.  
Supports Laravel 5.x → 12.x and PHP 7.0 → 8.4. Works with **both request files (UploadedFile)** and **storage file paths**.

---

## Features

- Upload images directly from request or local storage
- Get image details from Cloudflare
- Delete images from Cloudflare
- Ready-to-use Facade and ServiceProvider
- Configurable via `config/cloudflare-image.php`
- Laravel projects reuse-ready
- Clean, maintainable architecture

---

## 📦 Installation

1. Require the package via Composer:

```bash
composer require gmbf-package/cloudflare-image-upload
```

2. (Optional for Laravel <5.5) Add the service provider manually in `config/app.php`:

```php
'providers' => [
    Gmbf\CloudflareImageUpload\CloudflareImageServiceProvider::class,
],
```

3. Publish the config file:

```bash
php artisan vendor:publish --provider="Gmbf\CloudflareImageUpload\CloudflareImageServiceProvider" --tag="config"

```

---

## ⚙️ Configuration

Add the following to your `.env` file:

```env
CLOUDFLARE_API_TOKEN=your_cloudflare_api_token
CLOUDFLARE_ACCOUNT_ID=your_cloudflare_account_id
CLOUDFLARE_IMAGES_KEY=your_optional_key
CLOUDFLARE_IMAGES_DELIVERY_URL=https://your-delivery-url.com
CLOUDFLARE_IMAGES_DEFAULT_VARIATION=your-variant-name
```

After publishing, you can customize the settings in `config/cloudflare-image.php`.

---

## 🚀 Usage

### Upload an image to Cloudflare

```
use Gmbf\CloudflareImageUpload\Facades\CloudflareImage;

// From request
CloudflareImage::upload(request()->file('image'));

// From storage path
CloudflareImage::upload(storage_path('app/public/example.jpg'));
```

---

### Get image details

```
CloudflareImage::get('image_id');
```

---

### Delete an image from Cloudflare

```
CloudflareImage::delete('image_id');
```

---

## 🛠️ Folder Structure

```
gmbf-package/cloudflare-image-upload/
├── composer.json
├── config/
│   └── cloudflare-image.php
├── src/
│   ├── CloudflareImageServiceProvider.php
│   ├── CloudflareImageService.php
│   ├── Facades/
│   │   └── CloudflareImage.php
│   └── Exceptions/
│       └── CloudflareException.php
├── tests/
│   └── CloudflareImageTest.php
├── README.md
└── LICENSE
```

---

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🙌 Credits

Developed and maintained by [GMBF Group](mailto:gmbf@gmail.com).
