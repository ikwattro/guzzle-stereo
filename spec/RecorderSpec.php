<?php

namespace spec\Ikwattro\GuzzleStereo;

use GuzzleHttp\Psr7\Response;
use Ikwattro\GuzzleStereo\Record\Tape;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Yaml\Yaml;

class RecorderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Recorder');
    }

    function it_should_have_a_store_directory_on_construct()
    {
        $dir = __DIR__;
        $this->getStore()->shouldEqual($dir);
    }

    function it_should_load_a_configuration_file_if_provided()
    {
        $this->beConstructedWith(__DIR__, $this->getConfigFile());
        $config = Yaml::parse(file_get_contents($this->getConfigFile()));
        $this->getConfig()->shouldEqual($config);
    }

    function it_should_have_an_empty_collection_of_tapes()
    {
        $this->getTapes()->shouldHaveCount(0);
    }

    function it_should_create_tapes()
    {
        $this->beConstructedWith(__DIR__, $this->getConfigFile());
        $this->getTapes()->shouldHaveCount(1);
    }

    function it_should_get_a_tape_by_name()
    {
        $this->beConstructedWith(__DIR__, $this->getConfigFile());
        $this->getTape('my_tape')->shouldHaveType('Ikwattro\GuzzleStereo\Record\Tape');
    }

    function it_should_throw_exception_if_tape_does_not_exist_when_getting()
    {
        $this->beConstructedWith(__DIR__, $this->getConfigFile());
        $this->shouldThrow('Ikwattro\GuzzleStereo\Exception\RecorderException')->duringGetTape('nonTape');
    }

    function it_should_throw_exception_when_adding_tape_with_duplicated_name(Tape $tape)
    {
        $this->beConstructedWith(__DIR__, $this->getConfigFile());
        $tape->getName()->willReturn('my_tape');
        $this->shouldThrow('Ikwattro\GuzzleStereo\Exception\RecorderException')->duringAddTape($tape);
    }

    function it_should_pass_the_tapes_for_recording_a_response(Response $response, Tape $tape)
    {
        $this->beConstructedWith(__DIR__, $this->getConfigFile());
        $this->addTape($tape);
        $tape->record($response)->shouldBeCalled();
        $this->record($response);
    }

    function it_should_have_a_writer_on_construct()
    {
        $this->getWriter()->shouldHaveType('Ikwattro\GuzzleStereo\Store\Writer');
    }

    function it_should_have_a_response_formatter_on_construct()
    {
        $this->getResponseFormatter()->shouldHaveType('Ikwattro\GuzzleStereo\Formatter\ResponseFormatter');
    }

    private function getConfigFile()
    {
        $configFile = __DIR__.'/resources/stereo.yml';

        return $configFile;
    }
}
