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
    private string $clientApi = 'https://geoip.contentdatapro.com/';
    private string $baseRoute = 'api/getgeo?ip=';
    private  string $clientIp;
    private $paramsKey;
    private array $baseAnswer = [
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
    private string $baseLang = 'en';

    public function __construct(Request $request)
    {
        $this->clientIp = $request->getClientIp();
        $this->_params_key = Config::get('geo.key_params');
    }

    public function get(string $ip = null): array
    {
        $clientIp = $ip ?? $this->clientIp;
        try {
            $http = Http::get($this->clientApi . $this->baseRoute . $clientIp);
            if($http->successful())
            {
                return $this->formatAnswer($http->json());
            }
            return $this->baseAnswer;
        } catch (\Throwable $e) {
            return $this->baseAnswer;
        }
    }

    private function formatAnswer(array $data): array
    {
        $response = [];
        foreach($this->paramsKey as $key => $val)
        {
            $param = Arr::get($data, $val);
            $response[$key] = is_array($param) ? $param[$this->baseLang] : $param;
        }
        return $response;
    }
}
