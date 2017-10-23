<?php

namespace App\Listeners;

use App\Events\DistributionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DistributionEventListener
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
     * @param  DistributionEvent  $event
     * @return void
     */
    public function handle(DistributionEvent $event)
    {
        //
    }
}
