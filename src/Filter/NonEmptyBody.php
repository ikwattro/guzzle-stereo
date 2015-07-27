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

class NonEmptyBody implements FilterInterface
{
    const FILTER_NAME = 'non_empty_body';

    /**
     * @return string
     */
    public static function getName()
    {
        return self::FILTER_NAME;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return bool
     */
    public function isIncluded(ResponseInterface $response)
    {
        return !empty((string) $response->getBody());
    }
}
