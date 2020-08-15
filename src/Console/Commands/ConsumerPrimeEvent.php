<?php

namespace Prime\Console\Commands;

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
     * @var Context
     */
    private $context;

    /**
     * @var Client
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @param Context $context
     * @param Client $client
     */
    public function __construct(Context $context, Client $client)
    {
        parent::__construct();
        $this->context = $context;
        $this->client = $client;
    }

    /**
     * Execute the console command.
     * @param $topic
     * @throws \Exception
     */
    public function handle($topic)
    {
        $queueConsumer = new QueueConsumer($this->context, new ChainExtension([
            new ReplyExtension()
        ]));

        $queueConsumer->bind($topic, new ConsumePrimeEvent($this->client));
        $queueConsumer->consume();
    }
}
