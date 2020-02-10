<?php

namespace App\Providers;

use App\Transformers\UserTransformer;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Schema::defaultStringLength(191);

        Resource::withoutWrapping();

        $this->registerBladeComponents();

        $this->bootInertia();
    }

    /**
     * Register Blade components.
     *
     * @return void
     */
    protected function registerBladeComponents()
    {
        Blade::component('components.alert', 'alert');
        Blade::component('components.errors', 'errors');
        // Blade::component('components.modal', 'modal');
    }

    /**
     * Boot Inertia package.
     *
     * @return void
     */
    protected function bootInertia()
    {
        Inertia::share('app.name', $this->app['config']->get('app.name'));

        Inertia::share('auth.user', function () {
            if ($user = auth()->user()) {
                return fractal($user, new UserTransformer);
            }

            return null;
        });

        Inertia::share('errors', function () {
            return session()->has('errors')
                ? session()->get('errors')->getBag('default')->getMessages()
                : (object) [];
        });
    }
}
