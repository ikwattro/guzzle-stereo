<?php

namespace spec\Ikwattro\GuzzleStereo\Store;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

class WriterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Store\Writer');
    }

    function it_should_have_the_store_location_on_construct()
    {
        $dir = __DIR__;
        $this->getStoreLocation()->shouldEqual($dir);
    }

    function it_should_check_if_the_directory_is_writable()
    {
        $this->beConstructedWith(sys_get_temp_dir());
        $this->isStoreWritable()->shouldReturn(true);
    }
}
