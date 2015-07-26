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

interface FilterInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param \GuzzleHttp\Psr7\Response $response
     * @return bool
     */
    public function isIncluded(Response $response);
}