<?php

namespace spec\Ikwattro\GuzzleStereo\Filter;

use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NonEmptyBodySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Filter\NonEmptyBody');
    }

    function it_should_implement_interface()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Filter\FilterInterface');
    }

    function it_should_be_included_if_response_has_body()
    {
        $response = new Response(200, array(), json_encode(array('id' => 1)));
        $this->shouldBeIncluded($response);
    }

    function it_should_not_be_included_if_response_has_no_body()
    {
        $response = new Response(200);
        $this->shouldNotBeIncluded($response);
    }
}
