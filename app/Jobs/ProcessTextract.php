<?php

namespace App\Jobs;

use App\Services\TextractOcrService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class ProcessTextract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected string $file = '';
    /**
     * Create a new job instance.
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $textractOcrService = new TextractOcrService();
        $app_id = config('app.pusher.pusher_app_id');
        $app_key = config('app.pusher.pusher_app_key');
        $app_secret = config('app.pusher.pusher_app_secret');
        $app_cluster = config('app.pusher.pusher_app_cluster');

        try {
            $data = $textractOcrService->getDetail($this->file);
            $pusher = new Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);
            $pusher->trigger('ocr-channel', 'ocr-event', $data);
            Log::info('result: '. json_encode($data));
        } catch (Exception $e) {
            Log::info('error : '.$e->getMessage());
        } catch (GuzzleException $e) {
            Log::info('error : '.$e->getMessage());
        }
    }
}
