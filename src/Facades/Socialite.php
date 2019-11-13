<?php

namespace Webmasterninja\Socialite\Facades;

use Illuminate\Support\Facades\Facade;
use Webmasterninja\Socialite\Contracts\Factory;

/**
 * @method static \Webmasterninja\Socialite\Contracts\Provider driver(string $driver = null)
 * @see \Webmasterninja\Socialite\SocialiteManager
 */
class Socialite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
