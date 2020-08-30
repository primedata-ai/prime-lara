<?php


namespace Prime;


use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Log;
use Interop\Queue\ConnectionFactory;
use Illuminate\Contracts\Container\Container;
use Interop\Queue\Context;

/**
 * Class Provider
 * @package Prime
 */
class Provider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PrimeConfig::class, function ($app) {
            /**
             * @var $api Client
             */
            $cfg = $app['config']['prime'];
            return new PrimeConfig($cfg['source_key'], $cfg['write_key']);
        });
        $this->app->singleton(ConnectionFactory::class, function ($app) {
            $cfg = $app['config']['queue'];
            $builder = new \Prime\Builder();
            return $builder->buildConnection($cfg['connections']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class, ConnectionFactory::class];
    }
}
