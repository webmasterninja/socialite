<?php

namespace Webmasterninja\Socialite;

use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Webmasterninja\Socialite\One\TwitterProvider;
use Webmasterninja\Socialite\Two\BitbucketProvider;
use Webmasterninja\Socialite\Two\FacebookProvider;
use Webmasterninja\Socialite\Two\GithubProvider;
use Webmasterninja\Socialite\Two\GitlabProvider;
use Webmasterninja\Socialite\Two\GoogleProvider;
use Webmasterninja\Socialite\Two\LinkedInProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;

class SocialiteManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    protected function createGithubDriver()
    {
        $config = $this->app['config']['services.github'];

        return $this->buildProvider(
            GithubProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    protected function createFacebookDriver()
    {
        $config = $this->app['config']['services.facebook'];

        return $this->buildProvider(
            FacebookProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    protected function createGoogleDriver()
    {
        $config = $this->app['config']['services.google'];

        return $this->buildProvider(
            GoogleProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    protected function createLinkedinDriver()
    {
        $config = $this->app['config']['services.linkedin'];

        return $this->buildProvider(
          LinkedInProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    protected function createBitbucketDriver()
    {
        $config = $this->app['config']['services.bitbucket'];

        return $this->buildProvider(
          BitbucketProvider::class, $config
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    protected function createGitlabDriver()
    {
        $config = $this->app['config']['services.gitlab'];

        return $this->buildProvider(
            GitlabProvider::class, $config
        );
    }

    /**
     * Build an OAuth 2 provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \Webmasterninja\Socialite\Two\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->app['request'], $config['client_id'],
            $config['client_secret'], $this->formatRedirectUrl($config),
            Arr::get($config, 'guzzle', [])
        );
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Webmasterninja\Socialite\One\AbstractProvider
     */
    protected function createTwitterDriver()
    {
        $config = $this->app['config']['services.twitter'];

        return new TwitterProvider(
            $this->app['request'], new TwitterServer($this->formatConfig($config))
        );
    }

    /**
     * Format the server configuration.
     *
     * @param  array  $config
     * @return array
     */
    public function formatConfig(array $config)
    {
        return array_merge([
            'identifier' => $config['client_id'],
            'secret' => $config['client_secret'],
            'callback_uri' => $this->formatRedirectUrl($config),
        ], $config);
    }

    /**
     * Format the callback URL, resolving a relative URI if needed.
     *
     * @param  array  $config
     * @return string
     */
    protected function formatRedirectUrl(array $config)
    {
        $redirect = value($config['redirect']);

        return Str::startsWith($redirect, '/')
                    ? $this->app['url']->to($redirect)
                    : $redirect;
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No Socialite driver was specified.');
    }
}
