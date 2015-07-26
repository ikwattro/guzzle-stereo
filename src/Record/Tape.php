<?php

/**
 * This file is part of the GuzzleStero package
*
* (c) Christophe Willemsen <willemsen.christophe@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace Ikwattro\GuzzleStereo\Record;

use Ikwattro\GuzzleStereo\Filter\FilterInterface;
use Psr\Http\Message\ResponseInterface;

class Tape
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Ikwattro\GuzzleStereo\Filter\FilterInterface[]
     */
    protected $filters = [];

    /**
     * @var \Psr\Http\Message\ResponseInterface[]
     */
    protected $responses = [];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function record(ResponseInterface $response)
    {
        if ($this->processFiltersStack($response)) {
            $this->responses[] = $response;
        }
    }

    /**
     * @return \Ikwattro\GuzzleStereo\Filter\FilterInterface[]
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @param \Ikwattro\GuzzleStereo\Filter\FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @return bool
     */
    public function hasFilters()
    {
        return !empty($this->filters);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface[]
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @return bool
     */
    public function hasResponses()
    {
        return !empty($this->responses);
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return bool
     */
    public function processFiltersStack(ResponseInterface $response)
    {
        if (!$this->hasFilters()) { return true; }

        foreach ($this->filters as $filter) {
            if ($filter->isIncluded($response)) {
                return true;
            }
        }

        return false;
    }
}
