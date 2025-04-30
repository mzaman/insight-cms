<?php

namespace App\Domains\V1\Token\Models\Traits\Method;

/**
 * Trait ApiKeyMethod.
 */
trait ApiKeyMethod
{
  
    // Method to decrypt the API key, but won't show in the JSON response automatically
    public function decryptApiKey(): string
    {
        if (empty($this->attributes['api_key'])) {
            throw new \Exception('API key is empty.');
        }

        return Crypt::decryptString($this->attributes['api_key']);
    }

    /**
     * A static method to get the latest decrypted API key
     */
    public static function getLatestDecryptedApiKey(): string
    {
        $apiKey = self::latest()->first();

        if (!$apiKey) {
            throw new \Exception('API key not found.');
        }

        return $apiKey->decryptApiKey(); // Only decrypt when needed
    }
}
