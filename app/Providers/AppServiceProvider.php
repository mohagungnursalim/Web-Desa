<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Link;
use Illuminate\Support\Facades\View;
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
          // Share variable global ke semua view
          View::composer('*', function ($view) {
            $abouts = About::select(['title','slug'])->oldest()->get(); // Ambil data dari database
            $view->with('globalAbouts', $abouts);
        });

        View::composer('*', function ($view) {
            $links = Link::select(['linkTitle','linkHttp'])->oldest()->get(); // Ambil data dari database
            $view->with('globalLinks', $links);
        });
    }
}
