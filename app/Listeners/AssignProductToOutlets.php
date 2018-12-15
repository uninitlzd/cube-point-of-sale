<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssignProductToOutlets implements ShouldQueue
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
     * @param  ProductCreated  $event
     * @return void
     */
    public function handle(ProductCreated $event)
    {
        $outlets = $event->product->shop->outlets;
        $outlets->map(function ($outlet, $index) use ($event){
           $outlet->products()->save($event->product);
        });
    }
}
