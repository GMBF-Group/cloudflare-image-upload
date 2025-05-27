<?php

namespace Gmbf\CloudflareImageUpload;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudflareImageUploadController extends Controller
{
    protected $token;
    protected $account_id;

    public function __construct()
    {
        $this->token = config('cloudflareImage.api_token');
        $this->account_id = config('cloudflareImage.id_account');
    }

    public function index()
    {
        return view('cloudflareImageUpload::app');
    }

    public function uploadToCloudflare(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $response = Http::withToken($this->token)
            ->attach('file', file_get_contents($image), $image->getClientOriginalName())
            ->post("https://api.cloudflare.com/client/v4/accounts/" . $this->account_id . "/images/v1");

        $responseBody = json_decode($response->body(), true);
        return $responseBody;
    }

    public function getImageFromCloudflare($imageId)
    {
        $response = Http::withToken($this->token)
            ->get("https://api.cloudflare.com/client/v4/accounts/" . $this->account_id  . "/images/v1/" . $imageId);

        if ($response->successful()) {
            $result = $response->json();
            return response()->json([
                'image_url' => $result['result']['variants'][0]
            ]);
        } else {
            return response()->json(['error' => 'Failed to fetch image'], 400);
        }
    }

    public function deleteFromCloudflare($imageId)
    {
        $response = Http::withToken($this->token)
            ->delete("https://api.cloudflare.com/client/v4/accounts/" . $this->account_id  . "/images/v1/" . $imageId);

        \Log::debug('Cloudflare API Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json()
        ]);

        return $response->successful();
    }
}
