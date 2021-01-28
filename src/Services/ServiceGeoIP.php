<?php
/**
 * @author Denis Davydov
 * @copyright © 27.01.2021, InstaForex Group
 * Date: 27.01.2021
 */

namespace LaravelGeo\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{ Config, Http };

class ServiceGeoIP implements IGeoIP
{
    private string $_client_api = 'https://geoip.contentdatapro.com/';
    private string $_base_route = 'api/getgeo?ip=';
    private  string $_client_ip;
    private $_params_key;
    private array $_base_answer = [
        'GEOIP2_COUNTRY_CODE' => 'RU',
        'GEOIP2_COUNTRY_NAME' => 'Russia',
        'GEOIP2_CITY_COUNTRY_CODE' => 'RU',
        'GEOIP2_CITY' => 'St Petersburg',
        'GEOIP2_POSTAL_CODE' => 190121,
        'GEOIP2_CITY_CONTINENT_CODE' => 'EU',
        'GEOIP2_LONGITUDE' => '30.26190',
        'GEOIP2_SUBDIVISION_CODE' => 'SPE',
        'GEOIP2_SUBDIVISION_NAME' => 'St.-Petersburg'
    ];
    private string $_base_lang = 'en';

    public function __construct(Request $request)
    {
        $this->_client_ip = $request->getClientIp();
        $this->_params_key = Config::get('geo.key_params');
    }

    public function get(): array
    {
        try {
            $http = Http::get($this->_client_api . $this->_base_route . $this->_client_ip);
            if($http->successful())
            {
                return $this->_format_answer($http->json());
            }
            return $this->_base_answer;
        } catch (\Throwable $e) {
            echo "<xmp>";
            print_r($e);
            echo "</xmp>";
            die('here');
            return $this->_base_answer;
        }
    }

    private function _format_answer(array $data): array
    {
        $response = [];
        foreach($this->_params_key as $key => $val)
        {
            $param = Arr::get($data, $val);
            $response[$key] = is_array($param) ? $param[$this->_base_lang] : $param;
        }
        return $response;
    }
}
