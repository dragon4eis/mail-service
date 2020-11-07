<?php

namespace App\Providers;

use App\Services\EmailLogService;
use App\Services\EmailLogServiceInterface;
use App\Services\EmailMessageService;
use App\Services\EmailMessageServiceInterface;
use App\Services\MailSenderInterface;
use App\Services\MailSenderService;
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
        $this->app->bind(MailSenderInterface::class, MailSenderService::class);
    }
}
