<?php

namespace Prime\Console\Commands;

use Interop\Queue\ConnectionFactory;
use Prime\Client;
use Prime\Console\Jobs\ConsumePrimeEvent;
use Illuminate\Console\Command;
use Enqueue\Consumption\ChainExtension;
use Enqueue\Consumption\QueueConsumer;
use Enqueue\Consumption\Extension\ReplyExtension;
use Interop\Queue\Context;

class ConsumerPrimeEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync {topic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send data from TOPIC to PrimeDATA';
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Client
     */
    private $client;

    /**
     * ConsumerPrimeEvent constructor.
     * @param ConnectionFactory $factory
     * @param Client $client
     */
    public function __construct(ConnectionFactory $factory, Client $client)
    {
        parent::__construct();
        $this->context = $factory->createContext();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     * @param $topic
     * @throws \Exception
     */
    public function handle()
    {
        $topic = $this->argument("topic");
        $queueConsumer = new QueueConsumer($this->context, new ChainExtension([
            new ReplyExtension()
        ]));

        $queueConsumer->bind($topic, new ConsumePrimeEvent($this->client));
        $queueConsumer->consume();
    }
}
