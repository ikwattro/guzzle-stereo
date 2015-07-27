<?php

namespace spec\Ikwattro\GuzzleStereo\Filter;

use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HasHeaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Content-Type');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Filter\HasHeader');
    }

    function it_should_implement_interface()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Filter\FilterInterface');
    }

    function it_should_have_a_name()
    {
        $this->getName()->shouldReturn('has_header');
    }

    function it_should_have_a_header_key()
    {
        $this->getHeaderName()->shouldReturn('Content-Type');
    }

    function it_should_include_response_if_header_present()
    {
        $response = new Response(200, ['Content-Type' => 'application/json']);
        $this->shouldBeIncluded($response);
    }

    function it_should_not_include_if_header_not_present()
    {
        $response = new Response(200);
        $this->shouldNotBeIncluded($response);
    }
}
