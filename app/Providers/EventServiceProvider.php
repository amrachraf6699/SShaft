<?php

namespace App\Providers;

use App\Events\GeneralAssemblyMemberCreated;
use App\Events\GeneralAssemblyMemberPaymentConfirm;
use App\Listeners\NotifyGeneralAssemblyMemberCreated;
use App\Listeners\NotifyGeneralAssemblyMemberPaymentConfirm;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        //...
        GeneralAssemblyMemberCreated::class => [
            NotifyGeneralAssemblyMemberCreated::class,
        ],
        GeneralAssemblyMemberPaymentConfirm::class => [
            NotifyGeneralAssemblyMemberPaymentConfirm::class,
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
