<?php

namespace spec\Ikwattro\GuzzleStereo\Store;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Store\Reader');
    }

    function it_should_have_a_finder_on_construct()
    {
        $this->getFinder()->shouldHaveType('Symfony\Component\Finder\Finder');
    }

    function it_should_retrieve_content_of_tape()
    {
        $content = json_encode(array('id' => 1));
        $uid = uniqid('_');
        file_put_contents(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uid . '.json', $content);
        $this->getTapeContent(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uid . '.json')->shouldEqual($content);
    }

    function it_should_throw_exception_when_tape_do_not_exist()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringGetTapeContent('/tmp/tape.json');
    }
}
