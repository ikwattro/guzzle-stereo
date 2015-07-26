<?php

namespace Ikwattro\GuzzleStereo\Tests\Mock;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Ikwattro\GuzzleStereo\Recorder;
use Ikwattro\GuzzleStereo\RecorderMiddleware;

class SimpleMockedClient
{
    /**
     * @param \GuzzleHttp\Handler\MockHandler $mockHandler
     * @param \Ikwattro\GuzzleStereo\Recorder $recorder
     * @return \GuzzleHttp\Client
     */
    public static function createMockedClient(MockHandler $mockHandler, Recorder $recorder = null)
    {
        $handler = HandlerStack::create($mockHandler);
        if ($recorder) {
            $handler->push(RecorderMiddleware::record($recorder));
        }

        $client = new Client(['handler' => $handler]);

        return $client;
    }
}