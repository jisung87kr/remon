<?php

namespace App\Listeners;

use App\Events\ApplicationProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotificationOnApplication
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ApplicationProcessed $event): void
    {
        Log::channel('slack')->info("캠페인 신청서 상태 변경 {id} : {status}", [
            'id' => $event->application->id,
            'status' => $event->application->status,
        ]);
    }
}
