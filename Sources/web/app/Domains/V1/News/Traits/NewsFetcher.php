<?php

namespace App\Domains\V1\News\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Domains\V1\Auth\Models\User;
use App\Domains\V1\Token\Models\ApiKey;
use Illuminate\Support\Facades\Crypt;
use Exception;

/**
 * Trait NewsFetcher.
 */
trait NewsFetcher {
  
    /**
     * Decrypt the latest API key from the database.
     */
    protected function getDecryptedApiKey(): string
    {
        $encryptedKey = ApiKey::latest()->first()?->api_key;

        if (!$encryptedKey) {
            throw new Exception('API key not found.');
        }

        return Crypt::decryptString($encryptedKey);
    }

    /**
     * Make a GET request to the external API.
     */
    protected function fetchFromApi(string $endpoint, array $params = []): array
    {
        try {
            $client = new Client();
            $response = $client->get($endpoint, ['query' => $params]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            Log::error("API request failed: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Resolve the user ID based on CLI or Web request.
     */
    protected function resolveSyncUserId(): int
    {
        if (php_sapi_name() === 'cli') {
            return User::where('email', 'cliuser@mail.com')->first()?->id ?? 1;
        }

        return Auth::id() ?? 1;
    }
}
