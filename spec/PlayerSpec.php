<?php

namespace spec\Ikwattro\GuzzleStereo;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PlayerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Player');
    }
}
