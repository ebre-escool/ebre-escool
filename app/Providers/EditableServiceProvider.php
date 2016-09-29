<?php

namespace App\Providers;

use App\Repositories\Contracts\EditableRepository;
use App\Repositories\EditableByModelRepository;
use Illuminate\Support\ServiceProvider;

class EditableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EditableRepository::class,
            EditableByModelRepository::class
        );
    }
}
