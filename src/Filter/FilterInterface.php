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

interface FilterInterface
{
    /**
     * @return string
     */
    public static function getName();

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function isIncluded(ResponseInterface $response);
}
