<?php

namespace App\Providers;

use App\Jobs\PenjualanDetailDeleted;
use App\Jobs\PenjualanDetailJob;
use App\Jobs\PenjualanDetailUpdated;
use App\Jobs\PenjualanJob;
use App\Jobs\PenjualanUpdated;
use App\Jobs\StokUpdated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \App::bindMethod(PenjualanJob::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(PenjualanUpdated::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(PenjualanDetailJob::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(PenjualanDetailUpdated::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(PenjualanDetailDeleted::class . '@handle', fn ($job) => $job->handle());
        \App::bindMethod(StokUpdated::class . '@handle', fn ($job) => $job->handle());
    }
}
