<?php

/**
 * This file is part of the GuzzleStereo package.
 *
 * (c) Christophe Willemsen <willemsen.christophe@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ikwattro\GuzzleStereo\Filter;

use Psr\Http\Message\ResponseInterface;

class HasHeader implements FilterInterface
{
    const FILTER_NAME = 'has_header';

    /**
     * @var string
     */
    protected $headerName;

    /**
     * @param $headerName
     */
    public function __construct($headerName)
    {
        $this->headerName = (string) $headerName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::FILTER_NAME;
    }

    /**
     * @return string
     */
    public function getHeaderName()
    {
        return $this->headerName;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function isIncluded(ResponseInterface $response)
    {
        return $response->hasHeader($this->headerName);
    }
}
