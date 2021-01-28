<?php
/**
 * @author Denis Davydov
 * @copyright © 28.01.2021, InstaForex Group
 * Date: 28.01.2021
 */

namespace LaravelGeo\Facades;

use Illuminate\Support\Facades\Facade;

class GeoIP extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GeoIP';
    }
}
