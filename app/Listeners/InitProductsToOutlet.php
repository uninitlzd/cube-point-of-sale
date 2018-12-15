<?php

namespace App\Listeners;

use App\Events\OutletCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InitProductsToOutlet implements ShouldQueue
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
     * @param  OutletCreated  $event
     * @return void
     */
    public function handle(OutletCreated $event)
    {
        $products = $event->outlet->shop->products;
        $event->outlet->products()->sync($products);
    }
}
