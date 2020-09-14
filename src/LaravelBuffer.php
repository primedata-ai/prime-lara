<?php


namespace Prime;


use Illuminate\Support\Facades\Log;
use Interop\Queue\ConnectionFactory;
use Interop\Queue\Context;
use Interop\Queue\Producer;
use Interop\Queue\Exception;
use Interop\Queue\Exception\InvalidDestinationException;
use Interop\Queue\Exception\InvalidMessageException;

class LaravelBuffer implements QueueBuffer
{
    /**
     * @var Context
     */
    private $queueContext;

    /**
     * @var Producer
     */
    private $producer;

    /**
     * LaravelBuffer constructor.
     * @param ConnectionFactory $factory
     */
    public function __construct(ConnectionFactory $factory)
    {
        $context = $factory->createContext();
        $this->queueContext = $context;
        $this->producer = $this->queueContext->createProducer();
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(string $topic, \JsonSerializable $msg)
    {
        $topic = $this->queueContext->createTopic($topic);
        $message = $this->queueContext->createMessage(serialize($msg));
        try {
            $this->producer->send($topic, $message);
        } catch (InvalidDestinationException $e) {
            Log::error($e->getMessage(), $msg->jsonSerialize());
        } catch (InvalidMessageException $e) {
            Log::error($e->getMessage(), $msg->jsonSerialize());
        } catch (Exception $e) {
            Log::error($e->getMessage(), $msg->jsonSerialize());
        }
    }
}
