<?php
/**
 * @author Denis Davydov
 * @copyright © 27.01.2021, InstaForex Group
 * Date: 27.01.2021
 */

namespace LaravelGeo\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ServerGeoIP implements IGeoIP
{
    private $_params_key;
    private $_headers;

    public function __construct(Request $request)
    {
        $this->_params_key = Config::get('geo.key_params');
        $this->_headers = collect($request->headers->all())->transform(function($item) {
            return $item[0];
        });
    }

    public function get(string $ip = null): array
    {
        return array_intersect_key($this->_headers->all(), array_flip(array_keys($this->_params_key)));
    }
}
