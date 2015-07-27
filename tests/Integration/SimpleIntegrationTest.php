<?php

namespace Ikwattro\GuzzleStereo\Tests\Integration;

use Ikwattro\GuzzleStereo\Recorder;

class SimpleIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ikwattro\GuzzleStereo\Recorder
     */
    protected $recorder;

    public function setUp()
    {
        $this->recorder = new Recorder(sys_get_temp_dir(), __DIR__.'/../resources/stereo.yml');
    }

    /**
     * @group build
     */
    public function testAllTapesAreRegistered()
    {
        $this->assertTapeExist('tape_all');
        $this->assertTapeExist('tape_success');
        $this->assertTapeExist('tape_unauthorized');
    }

    public function assertFilterIsSetForSuccessResponses()
    {
        $successTape = $this->recorder->getTape('tape-success');
        $this->assertEquals(200, $successTape->getFilters()[0]->getFilterCode());
    }

    public function assertFilterIsSetForUnauthorizedResponses()
    {
        $successTape = $this->recorder->getTape('tape-unauthorized');
        $this->assertEquals(403, $successTape->getFilters()[0]->getFilterCode());
    }

    private function assertTapeExist($tape)
    {
        $this->assertInstanceOf('Ikwattro\GuzzleStereo\Record\Tape', $this->recorder->getTape($tape));
        $this->assertEquals($tape, $this->recorder->getTape($tape)->getName());
    }
}