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
