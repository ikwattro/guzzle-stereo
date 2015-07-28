<?php

namespace Ikwattro\GuzzleStereo\Tests\Integration;

use GuzzleHttp\Exception\RequestException;
use Ikwattro\GuzzleStereo\Player;
use Ikwattro\GuzzleStereo\Recorder;
use Ikwattro\GuzzleStereo\Tests\Mock\SimpleMockedClient;
use Ikwattro\GuzzleStereo\Tests\Mock\SimpleMockHandler;

class PlayerIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ikwattro\GuzzleStereo\Recorder
     */
    protected $recorder;

    public function setUp()
    {
        $this->recorder = new Recorder(sys_get_temp_dir(), __DIR__.'/../resources/stereo.yml');
    }

    public function testPlayerCanReplayFromContent()
    {
        $mock = SimpleMockHandler::create()
          ->withMultipleResponses(5, 200)
          ->withMultipleResponses(5, 403)
          ->withMultipleResponses(5, 404)
          ->build();
        $client = SimpleMockedClient::createMockedClient($mock, $this->recorder);
        for ($i = 0; $i < 15; $i++) {
            try {
                $client->get('/');
            } catch (RequestException $e) {

            }
        }

        $content = $this->recorder->getTapeContent('tape-all');

        $player = Player::replayFromContent($content);
        $this->assertInstanceOf('GuzzleHttp\Client', $player->getClient());
        $this->assertEquals(200, $player->get('/')->getStatusCode());
    }
}