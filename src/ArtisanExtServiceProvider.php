<?php

namespace Sebpro\ArtisanExt;

use Illuminate\Support\ServiceProvider;

class ArtisanExtServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    		$this->app['app:url'] = $this->app->share(function () {
    			return new Commands\ExtHostUrl();
    		});

        $this->app['app:env'] = $this->app->share(function () {
          return new Commands\ExtEnv();
        });

        $this->app['app:cipher'] = $this->app->share(function () {
          return new Commands\ExtCipher();
        });

        $this->app['app:serviceprovider'] = $this->app->share(function() {
          return new Commands\ExtProvider();
        });

        $this->app['app:alias'] = $this->app->share(function() {
          return new Commands\ExtAlias();
        });

        $this->app['app:cache'] = $this->app->share(function() {
          return new Commands\ExtCache();
        });

        $this->app['app:queue'] = $this->app->share(function() {
          return new Commands\ExtQueue();
        });

        $this->app['app:session'] = $this->app->share(function() {
          return new Commands\ExtSession();
        });

        $this->app['app:locale'] = $this->app->share(function() {
          return new Commands\ExtLocale();
        });

        $this->app['redis:password'] = $this->app->share(function() {
          return new Commands\ExtRedisPassword();
        });

        $this->app['redis:port'] = $this->app->share(function() {
          return new Commands\ExtRedisPort();
        });

        $this->app['redis:host'] = $this->app->share(function() {
          return new Commands\ExtRedisHost();
        });

        $this->app['db:name'] = $this->app->share(function() {
          return new Commands\ExtDBName();
        });

        $this->app['db:host'] = $this->app->share(function() {
          return new Commands\ExtDBHost();
        });

        $this->app['db:user'] = $this->app->share(function() {
          return new Commands\ExtDBUser();
        });

        $this->app['db:password'] = $this->app->share(function() {
          return new Commands\ExtDBPassword();
        });

    		$this->commands(
    			'app:url',
          'app:env',
          'app:serviceprovider',
          'app:alias',
          'app:cipher',
          'app:locale',
          'app:cache',
          'app:alias',
          'app:queue',
          'app:session',
          'redis:host',
          'redis:port',
          'redis:password',
          'db:host',
          'db:name',
          'db:password',
          'db:user'
    		);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
