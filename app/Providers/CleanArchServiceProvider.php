<?php

namespace App\Providers;


use Core\Domain\Repository\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use App\Repositories\Eloquent\ProductEloquentRepository;
use Core\Domain\Repository\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CleanArchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->bingRepositories();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function bingRepositories()
    {
        /**
         * Repositories
         */
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryEloquentRepository::class
        );
        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductEloquentRepository::class
        );


        
    }
}
