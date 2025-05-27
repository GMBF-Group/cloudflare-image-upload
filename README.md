# Cloudflare Image Upload Package for Laravel

This Laravel package provides a simple and reusable interface for uploading, retrieving, and deleting images on **Cloudflare Images**.  
It is intended for use in Laravel applications to handle image storage through the Cloudflare Images API.

---

## 📦 Installation

1. Require the package via Composer:

```bash
composer require gmbf/cloudflare-image-upload
```

2. (Optional for Laravel <5.5) Add the service provider manually in `config/app.php`:

```php
'providers' => [
    Gmbf\CloudflareImageUpload\CloudflareImageUploadServiceProvider::class,
],
```

3. Publish the config file:

```bash
php artisan vendor:publish --tag=config
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

After publishing, you can customize the settings in `config/cloudflareImage.php`.

---

## 🚀 Usage

### Upload an image to Cloudflare

`POST /cloudflare/upload`

- **Form field**: `image` (type: `file`)
- **Response**: JSON response from Cloudflare with image details

### Get a Cloudflare image

`GET /cloudflare/image/{id}`

- Replace `{id}` with the Cloudflare image ID
- Returns the first image variant URL in JSON format

### Delete an image from Cloudflare

`DELETE /cloudflare/delete/{id}`

- Replace `{id}` with the Cloudflare image ID
- Returns a success/failure response

---

## 🗂️ Routes

| Method | Endpoint                | Controller Method          |
| ------ | ----------------------- | -------------------------- |
| POST   | /cloudflare/upload      | `uploadToCloudflare()`     |
| GET    | /cloudflare/image/{id}  | `getImageFromCloudflare()` |
| DELETE | /cloudflare/delete/{id} | `deleteFromCloudflare()`   |

---

## 🛠️ Folder Structure

```
gmbf/cloudflare-image-upload/
├── config/
│   └── cloudflareImage.php
├── src/
│   ├── MyPackageController.php
│   ├── MyPackageProvider.php
│   ├── routes.php
├── .gitignore
├── composer.json
├── README.md
```

---

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🙌 Credits

Developed and maintained by [GMBF Group](mailto:gmbf@gmail.com).
