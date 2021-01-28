<?php
/**
 * @author Denis Davydov
 * @copyright © 27.01.2021, InstaForex Group
 * Date: 27.01.2021
 */

namespace LaravelGeo\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use LaravelGeo\Services\{ IGeoIP, ServerGeoIP, ServiceGeoIP };

class GeoIPServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/../config/geo.php', 'geo');

        // Регистрация сервиса GeoIp
        $this->app->singleton(IGeoIP::class, function($app) {
            $request = app(Request::class);
            switch(App::environment()) {
                case 'local':
                    return new ServiceGeoIP($request);
                default:
                    return new ServerGeoIP($request);
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('GeoIP', IGeoIP::class);
    }
}
