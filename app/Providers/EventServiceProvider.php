<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        'App\Events\Event' => [
//            'App\Listeners\EventListener',
//        ],
        'App\Events\RowAEvent' => [
            'App\Listeners\RowAEventListener',
        ],
        'App\Events\RowBEvent' => [
            'App\Listeners\RowBEventListener',
        ],
        'App\Events\RowCEvent' => [
            'App\Listeners\RowCEventListener',
        ],
        'App\Events\RowEvent' => [
            'App\Listeners\RowEventListener',
        ],
        'App\Events\AcoutEvent' => [
             'App\Listeners\AcoutEventListener',
         ],
        'App\Events\ActiveLogEvent' => [
            'App\Listeners\ActiveLogEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
