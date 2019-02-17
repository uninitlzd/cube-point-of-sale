<?php

namespace App\Listeners;

use App\Events\EmployeeRegistered;
use App\Models\EmployeeDetail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetEmployeeDetail
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
     * @param EmployeeRegistered $event
     * @return void
     */
    public function handle(EmployeeRegistered $event)
    {

    }
}
