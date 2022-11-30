<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
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
        Response::macro('resource', function ($view, JsonResource $resource) {
            return request()->expectsJson() || request()->boolean('json')
                ? $resource
                : view($view, (array)json_decode($resource->toJson()));
        });

        Inertia::macro('resource', function ($view, JsonResource $resource) {
            return request()->expectsJson() || request()->boolean('json')
                ? $resource
                : $this->render($view, [
                    "{$resource->getTable()}" => (array)json_decode($resource->toJson())
                ]);
            // dd($this);
        });
    }
}
