<?php

namespace Gmbf\CloudflareImageUpload;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\UploadedFile;

class CloudflareImageService
{
    const API_ENDPOINT = 'https://api.cloudflare.com/client/v4/accounts/';

    protected $client;
    protected $apiToken;
    protected $accountId;

    public function __construct(string $apiToken, string $accountId, $client = null)
    {
        if (empty($apiToken) || empty($accountId)) {
            throw new \InvalidArgumentException('Cloudflare API Token and Account ID are required.');
        }

        $this->apiToken  = $apiToken;
        $this->accountId = $accountId;
        $this->client    = $client ?: new Client();
    }

    /**
     * Upload image to Cloudflare
     *
     * @param \Illuminate\Http\UploadedFile|string $file
     * @param string|null $fileName
     * @return array
     */
    public function upload($file, string $fileName = null): array
    {
        if ($file instanceof UploadedFile) {

            $filePath = $file->getRealPath();
            $fileName = $fileName ?: $file->getClientOriginalName();

        } elseif (is_string($file) && file_exists($file)) {

            $filePath = $file;
            $fileName = $fileName ?: basename($file);
            
        } else {
            throw new \InvalidArgumentException('Invalid file input. Must be UploadedFile or existing file path.');
        }

        try {
            $response = $this->client->post($this->buildUrl(), [
                'headers' => $this->getAuthHeaders(),
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => $fileName,
                    ],
                ],
            ]);
            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Get image details
     */
    public function get(string $imageId): array
    {
        try {
            $response = $this->client->get($this->buildUrl($imageId), [
                'headers' => $this->getAuthHeaders(),
            ]);
            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Delete image
     */
    public function delete(string $imageId): array
    {
        try {
            $response = $this->client->delete($this->buildUrl($imageId), [
                'headers' => $this->getAuthHeaders(),
            ]);
            return json_decode((string) $response->getBody(), true);
        } catch (RequestException $e) {
            return $this->handleException($e);
        }
    }

    protected function buildUrl(string $path = ''): string
    {
        $base = self::API_ENDPOINT . $this->accountId . '/images/v1';
        return $path ? $base . '/' . trim($path, '/') : $base;
    }

    protected function getAuthHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Accept'        => 'application/json',
        ];
    }

    protected function handleException(RequestException $e): array
    {
        $responseBody = $e->hasResponse() ? json_decode((string) $e->getResponse()->getBody(), true) : [];

        return [
            'success'  => false,
            'errors'   => $responseBody['errors'] ?? [['message' => $e->getMessage()]],
            'messages' => $responseBody['messages'] ?? [],
        ];
    }
}
