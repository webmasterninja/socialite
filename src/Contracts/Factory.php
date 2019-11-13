<?php

namespace Webmasterninja\Socialite\Contracts;

interface Factory
{
    /**
     * Get an OAuth provider implementation.
     *
     * @param  string  $driver
     * @return \Webmasterninja\Socialite\Contracts\Provider
     */
    public function driver($driver = null);
}
