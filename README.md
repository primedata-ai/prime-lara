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
// Register Redis Connection factory by builder
use Interop\Queue\ConnectionFactory;
use Prime\Client;

$this->app->singleton(ConnectionFactory::class, function (){
    $cfg = config('prime');
    $builder = new \Prime\Builder();
    $conn = $builder->buildConnection($cfg['queue']);
    return $conn;
});
$this->app->resolving(QueueBuffer::class, function ($buffer, $app){
    $cfg = config('prime');
    
    $app->singleton(Client::class, new Client($cfg['source_key'], $cfg['write_key'], $buffer))
});
```