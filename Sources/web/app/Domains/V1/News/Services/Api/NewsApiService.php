<?php

namespace App\Domains\V1\News\Services\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Domains\V1\System\Services\Api\LogApiService;
use Exception;

class NewsApiService
{
    const MAX_RETRIES = 3; 
    const MAX_DELAY = 5000; 
    const RETRY_DELAY = 1000; 

    protected $logApiService;
    protected $apiKey;
    protected $service;

    /**
     * Constructor to set the API key.
     *
     * @param string $apiKey
     * @param LogApiService $logApiService
     */
    public function __construct(string $apiKey, LogApiService $logApiService)
    {
        $this->logApiService = $logApiService;  // Automatically resolved by Laravel for DI binding in AppServiceProvider
        $this->apiKey = $apiKey;  
        $this->client = new Client();  
    }

    /**
     * Generate an external ID based on the endpoint and parameters for logging.
     *
     * @param string $endpoint
     * @param array $params
     * @return string
     */
    protected function generateExternalId($endpoint, $params)
    {
        return md5($endpoint . json_encode($params));
    }

    /**
     * Log the API request and response to the database.
     *
     * @param string $endpoint
     * @param array $params
     * @param \GuzzleHttp\Psr7\Response|null $response
     * @param string $externalId
     * @param float $responseTime
     * @param int $attempt
     * @param string|null $errorMessage
     * @return void
     */
    protected function logApiRequest($endpoint, $params, $response = null, $externalId = '', $responseTime = 0, $attempt = 0, $errorMessage = null)
    {
        $statusCode = $response ? $response->getStatusCode() : 0;
        $requestTime = now(); 
        $requestHeaders = $response ? json_encode($response->getHeaders()) : null;

        // Prepare log data
        $logData = [
            'request_time' => $requestTime,
            'status_code' => $statusCode,
            'response_time' => $responseTime,
            'error_message' => $errorMessage,
            'external_id' => $externalId,
            'endpoint' => $endpoint,
            'request_headers' => $requestHeaders,
            'retry_count' => $attempt,
        ];

        // Log the data using LogApiService
        $this->logApiService->create($logData); 
    }

    /**
     * Make a generic API request (supports GET, POST, PUT, DELETE, etc.) with retry mechanism and log to database.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE, etc.)
     * @param string $endpoint The API endpoint
     * @param array $params The query parameters or body parameters
     * @param string|null $externalId The external ID for the request (optional)
     * @return array The decoded response
     */
    public function makeApiRequest($method, $endpoint, $params = [], $externalId = null)
    {
        $attempt = 0;
        $startTime = microtime(true);  

        if (!$externalId) {
            $externalId = $this->generateExternalId($endpoint, $params);
        }

        while ($attempt < self::MAX_RETRIES) {
            try {
                // Prepare headers with the API key
                $headers = [
                    'X-Api-Key' => $this->apiKey,
                ];

                // Make the request using the Guzzle client
                $response = $this->client->request($method, $endpoint, [
                    'query' => $params,
                    'headers' => $headers,
                ]);

                // Calculate response time
                $responseTime = (microtime(true) - $startTime) * 1000;  

                // Log the request information
                $this->logApiRequest($endpoint, $params, $response, $externalId, $responseTime, $attempt);

                return json_decode($response->getBody()->getContents(), true);

            } catch (RequestException $e) {
                // Log the error and retry attempt
                $this->logApiRequest($endpoint, $params, null, $externalId, 0, $attempt, $e->getMessage());

                if ($attempt < self::MAX_RETRIES - 1) {
                    $delay = min(self::RETRY_DELAY * (pow(2, $attempt)), self::MAX_DELAY); 
                    Log::info("Retrying API request in {$delay}ms...");
                    usleep($delay * 1000); 
                }
            }

            $attempt++;
        }

        Log::critical("API request failed after " . self::MAX_RETRIES . " attempts.");
        $this->logApiRequest($endpoint, $params, null, $externalId, 0, $attempt, 'Max retries reached.');
        throw new \Exception("API request failed after multiple attempts.");
    }

    /**
     * Fetch news data from the external News API (e.g., top headlines).
     *
     * @return array
     */
    public function fetchTopHeadlines(): array
    {
        $apiUrl = config('newsapi.base_url') . '/' . config('newsapi.version') . '/top-headlines';

        return $this->makeApiRequest('GET', $apiUrl, [
            'country' => 'us',
            'category' => 'general', 
            'pageSize' => 20,
            'page' => 1,
        ]);
    }
}