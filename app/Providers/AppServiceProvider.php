<?php

namespace App\Providers;

use App\Services\EmailLogService;
use App\Services\EmailLogServiceInterface;
use App\Services\EmailMessageService;
use App\Services\EmailMessageServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EmailMessageServiceInterface::class, EmailMessageService::class);
        $this->app->bind(EmailLogServiceInterface::class, EmailLogService::class);
    }
}
