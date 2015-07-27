<?php

namespace Ikwattro\GuzzleStereo\Tests\Integration\Filter;

use Ikwattro\GuzzleStereo\Filter\FilterInterface;
use Psr\Http\Message\ResponseInterface;

class CustomFilter implements  FilterInterface
{
    const FILTER_NAME = 'custom-filter';

    public static function getName()
    {
        return self::FILTER_NAME;
    }

    public function isIncluded(ResponseInterface $response)
    {
        return true;
    }
}