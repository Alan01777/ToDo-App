<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::preventLazyLoading(!$this->app->isProduction());
        Task::preventLazyLoading(!$this->app->isProduction());
        Tag::preventLazyLoading(!$this->app->isProduction());
        Category::preventLazyLoading(!$this->app->isProduction());
    }
}
