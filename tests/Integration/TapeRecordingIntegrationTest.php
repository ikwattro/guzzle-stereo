<?php

namespace Ikwattro\GuzzleStereo\Tests\Integration;

use GuzzleHttp\Exception\RequestException;
use Ikwattro\GuzzleStereo\Recorder;
use Ikwattro\GuzzleStereo\Tests\Mock\SimpleMockedClient;
use Ikwattro\GuzzleStereo\Tests\Mock\SimpleMockHandler;

class TapeRecordingIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ikwattro\GuzzleStereo\Recorder
     */
    protected $recorder;

    public function setUp()
    {
        $this->recorder = new Recorder(sys_get_temp_dir(), __DIR__.'/../resources/stereo.yml');
    }

    public function testTapeAllIsRecordingAllMessages()
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
        $this->assertCount(15, $this->recorder->getTape('tape-all')->getResponses());
    }

    public function testTapeSuccessIsRecordingOnlySuccessMessages()
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
        $this->assertCount(5, $this->recorder->getTape('tape-success')->getResponses());
    }

    public function testTapeUnauthorizedIsRecordingOnlyUnauthorizedMessages()
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
        $this->assertCount(5, $this->recorder->getTape('tape-unauthorized')->getResponses());
    }

    public function testNonEmptyBodyFilterIsRecordingTracks()
    {
        $mock = SimpleMockHandler::create()
          ->withMultipleResponses(5, 200, array(), json_encode(array('id' => 1)))
          ->build();
        $client = SimpleMockedClient::createMockedClient($mock, $this->recorder);
        for ($i = 0; $i < 5; $i++) {
            try {
                $client->get('/');
            } catch (RequestException $e) {

            }
        }
        $this->assertCount(5, $this->recorder->getTape('filter-non-empty')->getResponses());
    }

    public function testNonEmptyBodyFilterIsNotRecordingTracksWhenBodyIsEmpty()
    {
        $mock = SimpleMockHandler::create()
          ->withMultipleResponses(5, 200, array())
          ->build();
        $client = SimpleMockedClient::createMockedClient($mock, $this->recorder);
        for ($i = 0; $i < 5; $i++) {
            try {
                $client->get('/');
            } catch (RequestException $e) {

            }
        }
        $this->assertCount(0, $this->recorder->getTape('filter-non-empty')->getResponses());
    }

    public function testRecorderIsDumpingTapes()
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
        $this->recorder->dump();
        $successTapeFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'record_tape-success.json';
        $AllTapeFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'record_tape-all.json';
        $UnauthTapeFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'record_tape-unauthorized.json';
        $this->assertFileExists($successTapeFile);
        $this->assertFileExists($AllTapeFile);
        $this->assertFileExists($UnauthTapeFile);
    }
}