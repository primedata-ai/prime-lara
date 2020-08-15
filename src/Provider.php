<?php


namespace Prime;


use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Interop\Queue\ConnectionFactory;
use Illuminate\Contracts\Container\Container;
use Interop\Queue\Context;

/**
 * Class Provider
 * @package Prime
 */
class Provider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->resolving(ConnectionFactory::class, function ($api, $app) {
            /**
             * @var $app Container
             * @var $api ConnectionFactory
             */
            $context = $api->createContext();
            $app->singleton(Context::class, $context);
            $app->singleton(QueueBuffer::class, new LaravelBuffer($context));
        });
    }
}