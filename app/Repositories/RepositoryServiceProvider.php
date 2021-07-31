<?php
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider{
    public function register()
    {
        //Auth Repository
        $this->app->bind(
            'App\Repositories\Auth\AuthInterface',
            'App\Repositories\Auth\AuthRepository'
        );

        // User Repository
        $this->app->bind(
            'App\Repositories\User\UserInterface',
            'App\Repositories\User\UserRepository'
        );
    }
}
