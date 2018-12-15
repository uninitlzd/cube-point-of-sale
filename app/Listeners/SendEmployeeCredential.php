<?php

namespace App\Listeners;

use App\Events\EmployeeRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmployeeCredential implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmployeeRegistered  $event
     * @return void
     */
    public function handle(EmployeeRegistered $event)
    {
        Mail::to($event->employee)
            ->queue(new \App\Mail\EmployeeRegistered($event->employee, $event->shop, $event->password));
    }
}
