<?php

namespace Webmasterninja\Socialite\Tests\Fixtures;

use Webmasterninja\Socialite\Two\FacebookProvider;
use Mockery as m;
use stdClass;

class FacebookTestProviderStub extends FacebookProvider
{
    /**
     * @var \GuzzleHttp\Client|\Mockery\MockInterface
     */
    public $http;

    protected function getUserByToken($token)
    {
        return ['id' => 'foo'];
    }

    /**
     * Get a fresh instance of the Guzzle HTTP client.
     *
     * @return \GuzzleHttp\Client|\Mockery\MockInterface
     */
    protected function getHttpClient()
    {
        if ($this->http) {
            return $this->http;
        }

        return $this->http = m::mock(stdClass::class);
    }
}
