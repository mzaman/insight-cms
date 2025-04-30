<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use App\Domains\V1\Token\Models\ApiKey;  // Make sure to import the ApiKey model

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert API keys (ensure to encrypt the key before saving it)
        $apiKeys = [
            [
                'service_name' => 'NewsAPI',
                'api_key' => Crypt::encryptString(\Config::get('newsapi.api_key')),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        // Insert the records into the api_keys table
        foreach ($apiKeys as $key) {
            ApiKey::firstOrCreate([
                'service_name' => $key['service_name']
            ], $key);
        }

        // Optionally: Print a success message
        $this->command->info('API keys seeded successfully!');
    }
}