<?php

/**
 * This file is part of the GuzzleStereo package.
 *
 * (c) Christophe Willemsen <willemsen.christophe@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ikwattro\GuzzleStereo\Store;

use Symfony\Component\Finder\Finder;

class Reader
{
    /**
     * @var \Symfony\Component\Finder\Finder
     */
    protected $finder;

    /**
     *
     */
    public function __construct()
    {
        $this->finder = new Finder();
    }

    /**
     * @return \Symfony\Component\Finder\Finder
     */
    public function getFinder()
    {
        return $this->finder;
    }

    public function getTapeContent($tapeLocation)
    {
        if (!file_exists($tapeLocation)) {
            throw new \InvalidArgumentException(sprintf('Note tape found in "%s"', $tapeLocation));
        }

        return file_get_contents($tapeLocation);
    }
}
