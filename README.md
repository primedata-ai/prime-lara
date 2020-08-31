# Installation

```php
// check: config/queue.php

return [

    'connections' => [
        'redis' => [
            'driver'      => 'redis',
            'connection'  => 'default',
            'queue'       => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'persistent'  => env('REDIS_QUEUE_PERSISTENCE', true),
            'host'        => env('REDIS_QUEUE_SERVER_HOST'),
            'port'        => env('REDIS_QUEUE_SERVER_PORT'),
            'database'    => env('REDIS_QUEUE_SERVER_DB'),
            'password'    => env('REDIS_QUEUE_SERVER_PASSWORD'),
            'block_for'   => null,
            'cluster'     => 'predis',
        ],

    ],

];

```
```php
//config/prime.php
return [
    'source_key' => 'web-1fcrwsKgV0Zk2EdpCFYIvYbNRgs',
    'write_key'  => '1fcrwstLt8g0ggTL5K87a6O6umy',
];
```
```php

use Illuminate\Support\ServiceProvider;
use Prime\LaravelBuffer;
use Prime\QueueBuffer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(QueueBuffer::class, LaravelBuffer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
```
