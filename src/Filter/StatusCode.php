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

namespace Ikwattro\GuzzleStereo\Filter;

use GuzzleHttp\Psr7\Response;

class StatusCode implements FilterInterface
{
    const FILTER_NAME = 'status_code';

    /**
     * @var int
     */
    protected $filterCode;

    /**
     * @return string
     */
    public function getName()
    {
        return self::FILTER_NAME;
    }

    /**
     * @param int $code
     */
    public function __construct($code)
    {
        $this->filterCode = (int) $code;
    }

    /**
     * @return int
     */
    public function getFilterCode()
    {
        return $this->filterCode;
    }

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     * @return bool
     */
    public function isIncluded(Response $response)
    {
        return $response->getStatusCode() === $this->filterCode;
    }
}
