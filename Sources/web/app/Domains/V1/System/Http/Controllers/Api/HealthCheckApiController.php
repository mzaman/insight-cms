<?php

namespace App\Domains\V1\System\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use App\Domains\V1\News\Traits\NewsFetcher;

class HealthCheckApiController extends Controller
{
    use NewsFetcher;

    /**
     * Perform the health check and return the system status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function healthCheck()
    {
        // Initialize an array to store health check results
        $healthStatus = [
            'cms_version' => '1.0.0', // Current CMS version
            'uptime' => $this->getUptime(), // Get system uptime
            'database' => $this->checkDatabase(), // Check database connectivity
            'cache' => $this->checkCache(), // Check Redis cache connectivity
            'news_api' => $this->checkNewsAPI() // Check NewsAPI connectivity
        ];

        // Default status is healthy unless any component fails
        $status = 'healthy';
        
        // Loop through the health status checks and set overall status to 'unhealthy' if any check fails
        foreach ($healthStatus as $key => $statusCheck) {
            // Ensure that $statusCheck is always an array before accessing it
            if (is_array($statusCheck) && isset($statusCheck['status']) && $statusCheck['status'] == 'unhealthy') {
                $status = 'unhealthy';
            }
        }

        // Return the health status response
        return response()->json([
            'status' => $status,
            'details' => $healthStatus
        ], $status === 'healthy' ? 200 : 503); // Return HTTP 200 for healthy, 503 for unhealthy
    }

    private function getUptime()
    {
        // Check if the application is running in a Docker container
        if (getenv('DOCKER') === 'true') {
            // Attempt to get the container's ID from the cgroup file in Docker
            $containerId = trim(shell_exec('cat /proc/self/cgroup | grep "docker" | sed "s/.*\\(\\w\\+\\)$/\\1/"'));
            
            // Retrieve the container's start time using Docker's inspect command
            $startTime = trim(shell_exec("docker inspect --format '{{.State.StartedAt}}' $containerId"));
            
            // If we successfully got the start time, return it, otherwise return 'Unavailable'
            return $startTime ?: 'Unavailable';
        }
    
        // Fallback for systems that are not running inside Docker (Linux/macOS/Windows)
        return $this->getSystemUptime();
    }
    
    /**
     * Get the system uptime (e.g., how long the server has been running).
     *
     * @return string
     */
    private function getSystemUptime()
    {
        // For Linux/macOS systems, use the uptime command
        if (stristr(PHP_OS, 'LINUX') || stristr(PHP_OS, 'DARWIN')) {
            $uptime = shell_exec('uptime -p'); // Unix-based systems
            return $uptime ?: 'Unavailable'; // If the uptime command fails, return 'Unavailable'
        }
    
        // For Windows, use the 'systeminfo' command to get the boot time
        if (stristr(PHP_OS, 'WIN')) {
            $uptime = shell_exec('systeminfo | find "System Boot Time"');
            if ($uptime) {
                // Extract the boot time from the systeminfo output using regex
                preg_match('/(\w+\s\d+\s\d+,\s\d+)\s(\d+:\d+:\d+\s[APM]+)/', $uptime, $matches);
                return $matches[0] ?? 'Unavailable'; // Return the boot time or 'Unavailable' if not found
            }
        }
    
        // If the system is not Linux, macOS, or Windows, return 'Unavailable'
        return 'Unavailable';
    }

    /**
     * Check if the database connection is healthy.
     *
     * @return array
     */
    private function checkDatabase()
    {
        try {
            // Attempt to establish a database connection and execute a query
            DB::connection()->getPdo();
            // If successful, return healthy status
            return ['status' => 'healthy', 'message' => 'Database connected'];
        } catch (\Exception $e) {
            // If database connection fails, return unhealthy status with the error message
            return ['status' => 'unhealthy', 'message' => 'Database connection failed: ' . $e->getMessage()];
        }
    }

    /**
     * Check if Redis cache is working.
     *
     * @return array
     */
    private function checkCache()
    {
        try {
            // Attempt to write to Redis cache and then read the value
            Cache::store('redis')->put('health_check', 'ok', 1);
            // If successful, return healthy status
            return ['status' => 'healthy', 'message' => 'Cache connected'];
        } catch (\Exception $e) {
            // If Redis connection fails, return unhealthy status with the error message
            return ['status' => 'unhealthy', 'message' => 'Redis connection failed: ' . $e->getMessage()];
        }
    }

    /**
     * Check if NewsAPI is reachable and returning valid responses.
     *
     * @return array
     */
    private function checkNewsAPI()
    {
        try {
            $userId = $this->resolveSyncUserId();

            $apiKey = $this->getDecryptedApiKey();

            $apiUrl = config('news.api_base_url') . '/' . config('news.api_version') . '/top-headlines';

            $apiData = $this->fetchFromApi($apiUrl, [
                'apiKey' => $apiKey,
                'country' => 'us',
            ]);
            
            // If the response is successful, return healthy status
            return ['status' => 'healthy', 'message' => 'NewsAPI connected'];
        } catch (\Exception $e) {
            // If NewsAPI connection fails, return unhealthy status with the error message
            return ['status' => 'unhealthy', 'message' => 'NewsAPI connection failed: ' . $e->getMessage()];
        }
    }
}
