<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Link;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
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
        View::composer(['frontend.layouts.app'], function ($view) {
            $abouts = Cache::remember('globalAbouts', 3600, function () {
                return About::select(['title', 'slug'])->oldest()->get();
            });
        
            $links = Cache::remember('globalLinks', 3600, function () {
                return Link::select(['linkTitle', 'linkHttp'])->oldest()->get();
            });
        
            $view->with([
                'globalAbouts' => $abouts,
                'globalLinks' => $links,
            ]);
        });

        // Ambil nilai appName dari tabel settings, gunakan default jika tidak ada
        $appName = Setting::getSetting('app_name', 'Default App Name');
        // Bagikan appName ke semua view
        View::share('appName', $appName);

        // Ambil nilai footerText dari tabel settings, gunakan default jika tidak ada
        $footerText = Setting::getSetting('footer_text', 'Default Footer Text');
        // Bagikan footerText ke semua view
        View::share('footerText', $footerText);
        
        // Ambil nilai appLogo dari tabel settings, gunakan default jika tidak ada
        $appLogo = Setting::getSetting('appLogo', 'Default App Logo');
        // Bagikan appLogo ke semua view
        View::share('appLogo', $appLogo);

        // Ambil nilai facebook dari tabel settings, gunakan default jika tidak ada
        $facebook = Setting::getSetting('facebook', 'Default Facebook');
        // Bagikan facebook ke semua view
        View::share('facebook', $facebook);

        // Ambil nilai instagram dari tabel settings, gunakan default jika tidak ada
        $instagram = Setting::getSetting('instagram', 'Default Instagram');
        // Bagikan instagram ke semua view
        View::share('instagram', $instagram);
        

   
    }
}
