# LaravelGeo
Determine the geo location of website visitors based on their IP addresses or Headers info from server

# Quick start
add GeoIPSeviceProvider in your service container

/*
* Package Service Providers...
*/
\LaravelGeo\Providers\GeoIPServiceProvider::class
  
# How to use

use LaravelGeo\Facades\GeoIP;
GeoIP::get($ip = null)
if $ip == null -> $request->getClientIp()
