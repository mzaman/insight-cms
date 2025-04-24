<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domains\V1\News\Services\Api\PostApiService;

class SyncNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize news from the third-party API and store it in the database.';

    /**
     * The PostApiService instance.
     *
     * @var PostApiService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @param PostApiService $postApiService
     * @return void
     */
    public function __construct(PostApiService $postApiService)
    {
        parent::__construct();

        $this->service = $postApiService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Trigger the synchronization
            $posts = $this->service->fetchAndStorePosts();

            // Output success message
            $this->info('News synchronization completed successfully.');
            // Log to verify execution
            \Log::info('SyncNewsCron job executed at: ' . now());
            
        } catch (\Exception $e) {
            // Output error message if something goes wrong
            $this->error('Failed to synchronize news: ' . $e->getMessage());
        }
    }
}