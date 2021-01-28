<?php
/**
 * @author Denis Davydov
 * @copyright © 27.01.2021, InstaForex Group
 * Date: 27.01.2021
 */

declare(strict_types=1);

namespace LaravelGeo\Services;

interface IGeoIP
{
    /**
     * Get user geo info
     *
     * @return array
     */
    public function get(string $ip =  null): array;
}
