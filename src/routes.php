<?php

use Illuminate\Support\Facades\Route;
use Gmbf\CloudflareImageUpload\CloudflareImageUploadController;

Route::get('cloudflare-image-upload', function () {
    return 'Hello from the Cloudflare Image Upload package';
});

Route::post('/cloudflare/upload', [CloudflareImageUploadController::class, 'uploadToCloudflare'])->name('cloudflare.upload');
Route::get('/cloudflare/image/{id}', [CloudflareImageUploadController::class, 'getImageFromCloudflare'])->name('cloudflare.image');
Route::delete('/cloudflare/delete/{id}', [CloudflareImageUploadController::class, 'deleteFromCloudflare'])->name('cloudflare.delete');
