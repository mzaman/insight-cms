<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Domains\V1\News\Services\Api\NewsApiService;
use App\Domains\V1\System\Services\Api\LogApiService;
use App\Domains\V1\System\Repositories\Api\LogApiRepository;
use App\Domains\V1\System\Models\Log as ApiLog;
use App\Domains\V1\Token\Models\ApiKey;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind LogApiRepository to the service container
        $this->app->singleton(LogApiRepository::class, function ($app) {
            return new LogApiRepository(new ApiLog());
        });

        // Bind LogApiService to the service container
        $this->app->singleton(LogApiService::class, function ($app) {
            return new LogApiService($app->make(LogApiRepository::class));
        });
        
        // Bind NewsApiService to the service container, automatically resolve LogApiService and apiKey
        $this->app->singleton(NewsApiService::class, function ($app) {
            return new NewsApiService(ApiKey::getLatestDecryptedApiKey() ?? config('newsapi.api_key'), $app->make(LogApiService::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
