<?php

namespace Ikwattro\GuzzleStereo\Tests\Mock;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class SimpleMockHandler
{
    protected $responses = [];

    public static function create()
    {
        return new static();
    }

    public function withSuccessResponse(array $headers = array(), $body = null)
    {
        $this->responses[] = new Response(200, $headers, $body);

        return $this;
    }

    public function withResponse($code, array $headers = array(), $body = null)
    {
        $this->responses[] = new Response($code, $headers, $body);

        return $this;
    }

    public function withMultipleResponses($count, $code, array $headers = array(), $body = null)
    {
        foreach(range(1,$count) as $i) {
            $this->responses[] = new Response($code, $headers, $body);
        }

        return $this;
    }

    public function build()
    {
        return new MockHandler($this->responses);
    }
}