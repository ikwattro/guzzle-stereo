<?php

/**
 * This file is part of the GuzzleStereo package
*
* (c) Christophe Willemsen <willemsen.christophe@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace Ikwattro\GuzzleStereo;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Ikwattro\GuzzleStereo\Formatter\ResponseFormatter;
use Ikwattro\GuzzleStereo\Store\Reader;

class Player
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param $tapeFileLocation
     * @return \Ikwattro\GuzzleStereo\Player
     */
    public static function replayFromTape($tapeFileLocation)
    {
        $reader = new Reader();
        $formatter = new ResponseFormatter();
        $content = $reader->getTapeContent($tapeFileLocation);

        return new self($formatter->rebuildFromTape($content));
    }

    /**
     * @param $content
     * @return \Ikwattro\GuzzleStereo\Player
     */
    public static function replayFromContent($content)
    {
        $formatter = new ResponseFormatter();

        return new self($formatter->rebuildFromTape($content));
    }

    /**
     * @param array $responses
     */
    public function __construct(array $responses)
    {
        $mock = new MockHandler($responses);
        $stack = HandlerStack::create($mock);

        $this->client = new Client(['handler' => $stack]);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function head($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function patch($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function put($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($uri, array $options = [])
    {
        return $this->client->get($uri, $options);
    }
}
