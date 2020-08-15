# Installation

```shell
//config.php
'prime' => [
    'queue' => [
        'redis' => [
                   'host' => 'example.com',
                   'port' => 1000,
                   'scheme_extensions' => ['phpredis'],
               ]
    ],
    'sdk' => [
        'source_key' => '',
        'write_key' => ''
    ]
]
```
```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Interop\Queue\ConnectionFactory;
use Prime\Client;
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
        $this->app->singleton(ConnectionFactory::class, function () {
            $cfg = config('queue');
            $builder = new \Prime\Builder();
            return $builder->buildConnection($cfg['connections']);
        });

        $this->app->afterResolving(QueueBuffer::class, function ($buffer, $app) {
            Log::info('resolving queue buffer');
            $cfg = config('queue');
            $redis = $cfg['connections']['redis'];
            if (empty($redis)) {
                Log::error('redis is not configured');
                return;
            }
            Log::info('resolving client');

            $app->singleton(Client::class, new Client($cfg['source_key'], $cfg['write_key'], $buffer));
        });
    }
```
