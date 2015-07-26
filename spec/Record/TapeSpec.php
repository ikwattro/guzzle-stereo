<?php

namespace spec\Ikwattro\GuzzleStereo\Record;

use GuzzleHttp\Psr7\Response;
use Ikwattro\GuzzleStereo\Filter\StatusCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TapeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('tape1');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Record\Tape');
    }

    function it_should_have_a_name_on_construct()
    {
        $this->getName()->shouldReturn('tape1');
    }

    function it_should_have_an_empty_collection_of_filters_on_construct()
    {
        $this->getFilters()->shouldHaveCount(0);
    }

    function it_should_add_filter_to_filters_collection()
    {
        $filter = new StatusCode(200);
        $this->addFilter($filter);
        $this->getFilters()->shouldHaveCount(1);
        $this->getFilters()->shouldContain($filter);
    }

    function it_should_return_false_if_it_does_not_has_any_filters()
    {
        $this->hasFilters()->shouldBe(false);
    }

    function it_should_return_true_if_it_has_filters()
    {
        $filter = new StatusCode(200);
        $this->addFilter($filter);
        $this->hasFilters()->shouldBe(true);
    }

    function it_should_have_an_empty_collection_of_responses()
    {
        $this->getResponses()->shouldHaveCount(0);
    }

    function it_should_return_false_if_no_responses_are_recorded()
    {
        $this->hasResponses()->shouldReturn(false);
    }

    function it_should_return_true_if_responses_are_recorded()
    {
        $response = new Response(200);
        $this->record($response);
        $this->hasResponses()->shouldBe(true);
    }

    function it_should_return_the_recorded_responses()
    {
        $response = new Response(200);
        $this->record($response);
        $this->getResponses()->shouldContain($response);
    }

    function it_should_ask_the_filters_if_the_response_should_be_recorded(StatusCode $filter)
    {
        $response = new Response(200);
        $this->addFilter($filter);
        $filter->isIncluded($response)->shouldBeCalled();
        $this->record($response);
    }

    function it_should_record_the_message_if_the_filters_pass(StatusCode $filter)
    {
        $response = new Response(200);
        $this->addFilter($filter);
        $filter->isIncluded($response)->willReturn(true);
        $this->record($response);
        $this->getResponses()->shouldContain($response);
    }
}
