<?php

namespace spec\Ikwattro\GuzzleStereo;

use Ikwattro\GuzzleStereo\Filter\FilterInterface;
use Ikwattro\GuzzleStereo\Filter\StatusCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MixerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Ikwattro\GuzzleStereo\Mixer');
    }

    function it_should_have_an_empty_colleciton_of_filters()
    {
        $this->getFilters()->shouldHaveCount(0);
    }

    function it_should_return_whether_or_not_a_filter_is_present()
    {
        $this->hasFilter('filter')->shouldReturn(false);
    }

    function it_should_register_a_filter(FilterInterface $filter)
    {
        $filter = 'Ikwattro\GuzzleStereo\Filter\StatusCode';
        $this->addFilter($filter);
        $this->hasFilter('status_code')->shouldReturn(true);
    }

    function it_should_throw_an_exception_if_filter_has_duplicated_name()
    {
        $filter = 'Ikwattro\GuzzleStereo\Filter\StatusCode';
        $this->addFilter($filter);
        $filter2 = 'Ikwattro\GuzzleStereo\Filter\StatusCode';
        $this->shouldThrow('Ikwattro\GuzzleStereo\Exception\RecorderException')->duringAddFilter($filter2);
    }

    function it_should_return_a_filter_by_name()
    {
        $filter = 'Ikwattro\GuzzleStereo\Filter\StatusCode';
        $this->addFilter($filter);
        $this->getFilter('status_code')->shouldReturn('Ikwattro\GuzzleStereo\Filter\StatusCode');
    }

    function it_should_throw_an_exception_if_asked_filter_does_not_exist()
    {
        $this->shouldThrow('Ikwattro\GuzzleStereo\Exception\RecorderException')->duringGetFilter('filter');
    }

    function it_should_create_new_instance_of_filter()
    {
        $filter = 'Ikwattro\GuzzleStereo\Filter\StatusCode';
        $this->addFilter($filter);
        $this->createFilter('status_code', 200)->shouldHaveType($filter);
    }

    function it_should_create_new_instance_of_filter_when_passing_args_in_array()
    {
        $filter = 'Ikwattro\GuzzleStereo\Filter\StatusCode';
        $this->addFilter($filter);
        $this->createFilter('status_code', [200])->shouldHaveType($filter);
    }
}
