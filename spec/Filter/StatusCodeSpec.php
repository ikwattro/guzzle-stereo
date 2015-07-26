<?php

namespace spec\Ikwattro\GuzzleStereo\Filter;

use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatusCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(200);
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Filter\StatusCode');
    }

    function it_should_implement_interface()
    {
        $this->beConstructedWith(200);
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Filter\FilterInterface');
    }

    function it_should_have_a_name_on_construct()
    {
        $this->beConstructedWith(200);
        $this->getName()->shouldReturn('status_code');
    }

    function it_should_have_a_code_on_construct()
    {
        $this->beConstructedWith(200);
        $this->getFilterCode()->shouldReturn(200);
    }

    function it_should_return_true_when_response_has_status_code_filter()
    {
        $this->beConstructedWith(200);
        $response = new Response(200);
        $this->shouldBeIncluded($response);
    }

    function it_should_return_false_when_response_has_not_status_code()
    {
        $this->beConstructedWith(400);
        $response = new Response(200);
        $this->shouldNotBeIncluded($response);
    }
}
