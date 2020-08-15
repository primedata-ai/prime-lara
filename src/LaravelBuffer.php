<?php


namespace Prime;


use Illuminate\Support\Facades\Log;
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
     * @param $queueContext
     */
    public function __construct(Context $queueContext)
    {
        $this->queueContext = $queueContext;
        $this->producer = $this->queueContext->createProducer();
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(string $topic, \JsonSerializable $msg)
    {
        $topic = $this->queueContext->createTopic('aTopic');
        $message = $this->queueContext->createMessage($msg);
        try {
            $this->producer->send($topic, $message);
        } catch (InvalidDestinationException $e) {
            Log::error($e->getMessage(), $msg);
        } catch (InvalidMessageException $e) {
            Log::error($e->getMessage(), $msg);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $msg);
        }
    }
}