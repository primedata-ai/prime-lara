<?php


namespace Prime\Console\Jobs;

use Interop\Queue\Processor;
use Interop\Queue\Message;
use Interop\Queue\Context;
use Prime\Client;
use Prime\Tracking\Event;


class ConsumePrimeEvent implements Processor
{
    private $client;

    /**
     * ConsumePrimeEvent constructor.
     * @param $client Client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function process(Message $message, Context $context)
    {
        /**
         * @var $event Event
         */
        $event = unserialize($message->getBody());
        $this->client->sync($event);
    }
}
