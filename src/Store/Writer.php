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

use Ikwattro\GuzzleStereo\Exception\RecorderException;

class Writer
{
    /**
     * @var string
     */
    protected $storeLocation;

    /**
     * @param string $storeLocation
     */
    public function __construct($storeLocation)
    {
        $this->storeLocation = (string) $storeLocation;
    }

    /**
     * @return string
     */
    public function getStoreLocation()
    {
        return $this->storeLocation;
    }

    /**
     * @return bool
     */
    public function isStoreWritable()
    {
        return is_writable($this->storeLocation);
    }

    /**
     * @param string $file
     * @param mixed  $content
     */
    public function write($file, $content)
    {
        if (!$this->isStoreWritable()) {
            throw new RecorderException(sprintf('The directory "%s" is not writable', $this->storeLocation));
        }
        file_put_contents($this->storeLocation.DIRECTORY_SEPARATOR.$file, $content);
    }
}
