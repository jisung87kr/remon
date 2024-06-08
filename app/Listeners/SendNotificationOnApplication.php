<?php

namespace App\Listeners;

use App\Enums\Campaign\ApplicationStatus;
use App\Events\ApplicationProcessed;
use App\Notifications\Campaign\Application\Applied;
use App\Notifications\Campaign\Application\Approved;
use App\Notifications\Campaign\Application\Canceled;
use App\Notifications\Campaign\Application\Completed;
use App\Notifications\Campaign\Application\Pending;
use App\Notifications\Campaign\Application\Posted;
use App\Notifications\Campaign\Application\Rejected;
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
//        switch ($event->application->status){
//            case ApplicationStatus::APPLIED->value:
//                $event->application->user->notify(new Applied($event->application));
//                break;
//            case ApplicationStatus::CANCELED->value:
//                $event->application->user->notify(new Canceled($event->application));
//                break;
//            case ApplicationStatus::APPROVED->value:
//                $event->application->user->notify(new Approved($event->application));
//                break;
//            case ApplicationStatus::REJECTED->value:
//                $event->application->user->notify(new Rejected($event->application));
//                break;
//            case ApplicationStatus::PENDING->value:
//                $event->application->user->notify(new Pending($event->application));
//                break;
//            case ApplicationStatus::POSTED->value:
//                $event->application->user->notify(new Posted($event->application));
//                break;
//            case ApplicationStatus::COMPLETED->value:
//                $event->application->user->notify(new Completed($event->application));
//                break;
//        }

        Log::channel('slack')->info("캠페인 신청서 상태 변경 {id} : {status}", [
            'id' => $event->application->id,
            'status' => $event->application->status,
        ]);
    }
}
