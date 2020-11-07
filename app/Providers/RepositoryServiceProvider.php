<?php

namespace App\Providers;

use App\Repositories\Database\EmailMessageRepository;
use App\Repositories\EmailMessageRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(EmailMessageRepositoryInterface::class, EmailMessageRepository::class);
    }
}
