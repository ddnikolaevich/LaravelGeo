<?php
/**
 * @author Denis Davydov
 * @copyright © 27.01.2021, InstaForex Group
 * Date: 27.01.2021
 */

namespace LaravelGeo;

class Greetr
{
    public function greet(String $sName)
    {
        return 'Hi ' . $sName . '! How are you doing today?';
    }
}
