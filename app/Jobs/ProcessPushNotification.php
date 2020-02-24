<?php

namespace App\Jobs;

use App\Http\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ios_tokens;
    protected $android_tokens;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ios_tokens, $android_tokens)
    {
        $this->ios_tokens = $ios_tokens;
        $this->android_tokens = $android_tokens;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $service = new NotificationService();
        $service->pushAndroid($this->android_tokens);
        $service->pushIOS($this->ios_tokens);
    }
}
