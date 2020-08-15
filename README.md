# Installation

```shell
//config.php
'prime_queue' => [
    'redis' => [
                   'host' => 'example.com',
                   'port' => 1000,
                   'scheme_extensions' => ['phpredis'],
               ]
]
```
```php
// Register Redis Connection factory by builder
use Interop\Queue\ConnectionFactory;

$this->app->singleton(ConnectionFactory::class, function (){
    $cfg = config('prime_queue');
    $builder = new \Prime\Builder();
    $conn = $builder->buildConnection($cfg);
    return $conn;
});
```