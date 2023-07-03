<?php

namespace App\Providers;

use App\Repositories\IpAddress\IpAddressRepository;
use App\Repositories\IpAddress\IpAddressRepositoryInterface;
use App\Repositories\Label\LabelRepository;
use App\Repositories\Label\LabelRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
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
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(IpAddressRepositoryInterface::class, IpAddressRepository::class);
        $this->app->bind(LabelRepositoryInterface::class, LabelRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
